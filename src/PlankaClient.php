<?php

declare(strict_types=1);

namespace Planka\Bridge;

use Planka\Bridge\Actions\Auth\RevokePendingTokenAction;
use Planka\Bridge\Exceptions\AuthenticateException;
use Planka\Bridge\Actions\Auth\AuthenticateAction;
use Planka\Bridge\Views\Dto\Auth\AuthenticateResult;
use Planka\Bridge\Controllers\NotificationService;
use Planka\Bridge\Actions\Auth\AcceptTermsAction;
use Planka\Bridge\Controllers\BoardMembership;
use Planka\Bridge\Controllers\BackgroundImage;
use Planka\Bridge\Actions\Auth\VerifyTotpAction;
use Planka\Bridge\Actions\Common\GetInfoAction;
use Planka\Bridge\Actions\Common\GetTermsAction;
use Planka\Bridge\Controllers\CardMembership;
use Planka\Bridge\Controllers\ProjectManager;
use Planka\Bridge\Controllers\CustomField;
use Planka\Bridge\Exceptions\LogoutException;
use Planka\Bridge\Actions\Auth\LogoutAction;
use Planka\Bridge\Controllers\Notification;
use Planka\Bridge\Views\Dto\Common\BootstrapDto;
use Planka\Bridge\TransportClients\Client;
use Planka\Bridge\Controllers\Attachment;
use Planka\Bridge\Controllers\CardAction;
use Planka\Bridge\Controllers\AppConfig;
use Planka\Bridge\Controllers\BoardList;
use Planka\Bridge\Controllers\CardLabel;
use Planka\Bridge\Controllers\CardTask;
use Planka\Bridge\Views\Dto\Common\TermsDto;
use Planka\Bridge\Controllers\TaskList;
use Planka\Bridge\Controllers\Comment;
use Planka\Bridge\Controllers\Project;
use Planka\Bridge\Controllers\Webhook;
use Planka\Bridge\Controllers\Board;
use Planka\Bridge\Controllers\Label;
use Planka\Bridge\Controllers\Card;
use Planka\Bridge\Contracts\Actions\ActionInterface;
use Planka\Bridge\Controllers\User;
use Symfony\Contracts\HttpClient\ResponseInterface;

/**
 * PHP client for the Planka 2.2.1 REST API.
 */
final class PlankaClient
{
    public readonly Attachment $attachment;

    public readonly BackgroundImage $backgroundImage;

    public readonly Board $board;

    public readonly BoardList $boardList;

    public readonly BoardMembership $boardMembership;

    public readonly Card $card;

    public readonly CardAction $cardAction;

    public readonly CardLabel $cardLabel;

    public readonly CardTask $cardTask;

    public readonly CardMembership $cardMembership;

    public readonly Comment $comment;

    public readonly AppConfig $appConfig;

    public readonly CustomField $customField;

    public readonly Label $label;

    public readonly Notification $notification;

    public readonly NotificationService $notificationService;

    public readonly Project $project;

    public readonly ProjectManager $projectManager;

    public readonly TaskList $taskList;

    public readonly User $user;

    public readonly Webhook $webhook;

    private readonly Client $client;

    public function __construct(
        private readonly Config $config,
        ?Client $client = null,
    ) {
        if (null === $client) {
            $client = new Client(
                $this->config->getBaseUri(),
                $this->config->getPort(),
                apiKey: $this->config->getApiKey(),
            );
        }

        $this->client = $client;

        $this->attachment = new Attachment($config, $this->client);
        $this->backgroundImage = new BackgroundImage($config, $this->client);
        $this->board = new Board($config, $this->client);
        $this->boardList = new BoardList($config, $this->client);
        $this->boardMembership = new BoardMembership($config, $this->client);
        $this->card = new Card($config, $this->client);
        $this->cardAction = new CardAction($config, $this->client);
        $this->cardLabel = new CardLabel($config, $this->client);
        $this->cardMembership = new CardMembership($config, $this->client);
        $this->cardTask = new CardTask($config, $this->client);
        $this->comment = new Comment($config, $this->client);
        $this->appConfig = new AppConfig($config, $this->client);
        $this->customField = new CustomField($config, $this->client);
        $this->label = new Label($config, $this->client);
        $this->notification = new Notification($config, $this->client);
        $this->notificationService = new NotificationService($config, $this->client);
        $this->project = new Project($config, $this->client);
        $this->projectManager = new ProjectManager($config, $this->client);
        $this->taskList = new TaskList($config, $this->client);
        $this->user = new User($config, $this->client);
        $this->webhook = new Webhook($config, $this->client);
    }

    /**
     * 'POST /api/access-tokens'.
     *
     * @throws AuthenticateException
     */
    public function authenticate(bool $withHttpOnlyToken = false): AuthenticateResult
    {
        /** @var ResponseInterface $response */
        $response = $this->client->post(new AuthenticateAction(
            $this->config->getUser(),
            $this->config->getPassword(),
            $withHttpOnlyToken,
        ));

        $data = $response->toArray(false);
        $status = $response->getStatusCode();

        if (200 === $status && !empty($data['item']) && is_string($data['item'])) {
            $this->config->setAuthToken($data['item']);

            return new AuthenticateResult(success: true, token: $data['item']);
        }

        if (403 === $status) {
            $message = $data['message'] ?? '';
            $pendingToken = is_string($data['item'] ?? null) ? $data['item'] : ($data['pendingToken'] ?? null);
            $challenge = match ($message) {
                'TOTP verification required' => AuthenticateResult::CHALLENGE_TOTP,
                'Terms acceptance required' => AuthenticateResult::CHALLENGE_TERMS,
                default => null,
            };

            if (null !== $challenge) {
                return new AuthenticateResult(
                    success: false,
                    pendingToken: is_string($pendingToken) ? $pendingToken : null,
                    challenge: $challenge,
                );
            }
        }

        throw new AuthenticateException($data['message'] ?? 'not authenticate');
    }

    /**
     * 'POST /api/access-tokens/verify-totp'.
     *
     * @throws AuthenticateException
     */
    public function verifyTotp(string $pendingToken, string $code, bool $trustDevice = false): AuthenticateResult
    {
        return $this->completePendingAuth(new VerifyTotpAction($pendingToken, $code, $trustDevice));
    }

    /**
     * 'POST /api/access-tokens/accept-terms'.
     *
     * @throws AuthenticateException
     */
    public function acceptTerms(string $pendingToken, string $signature, ?string $initialLanguage = null): AuthenticateResult
    {
        return $this->completePendingAuth(new AcceptTermsAction($pendingToken, $signature, $initialLanguage));
    }

    /**
     * 'POST /api/access-tokens/revoke-pending-token'.
     */
    public function revokePendingToken(string $pendingToken): void
    {
        $this->client->post(new RevokePendingTokenAction($pendingToken));
    }

    /**
     * 'DELETE /api/access-tokens/me'.
     *
     * @throws AuthenticateException|LogoutException
     */
    public function logout(): void
    {
        $response = $this->client->delete(new LogoutAction(token: $this->config->getAuthToken()));

        $this->config->setAuthToken(null);

        if (200 !== $response->getStatusCode()) {
            throw new LogoutException($response->getContent());
        }
    }

    /** 'GET /api/bootstrap' */
    public function getInfo(): BootstrapDto
    {
        return $this->client->get(new GetInfoAction());
    }

    /** 'GET /api/terms' */
    public function getTerms(?string $language = null): TermsDto
    {
        return $this->client->get(new GetTermsAction($language));
    }

    /**
     * @throws AuthenticateException
     */
    private function completePendingAuth(ActionInterface $action): AuthenticateResult
    {
        /** @var ResponseInterface $response */
        $response = $this->client->post($action);
        $data = $response->toArray(false);

        if (200 === $response->getStatusCode() && !empty($data['item']) && is_string($data['item'])) {
            $this->config->setAuthToken($data['item']);

            return new AuthenticateResult(success: true, token: $data['item']);
        }

        throw new AuthenticateException($data['message'] ?? 'not authenticate');
    }
}
