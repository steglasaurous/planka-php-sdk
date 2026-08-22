<?php

declare(strict_types=1);

namespace Planka\Bridge\Actions\User;

use Planka\Bridge\Contracts\Actions\ResponseResultInterface;
use Planka\Bridge\Contracts\Actions\AuthenticateInterface;
use Planka\Bridge\Contracts\Actions\ActionInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;
use Planka\Bridge\Traits\AuthenticateTrait;

final class UserTotpSetupAction implements ActionInterface, AuthenticateInterface, ResponseResultInterface
{
    use AuthenticateTrait;

    public function __construct(
        private readonly string $userId,
        private readonly string $currentPassword,
        string $token,
    ) {
        $this->setToken($token);
    }

    public function url(): string
    {
        return "api/users/{$this->userId}/totp/setup";
    }

    public function getOptions(): array
    {
        return [
            'json' => [
                'currentPassword' => $this->currentPassword,
            ],
        ];
    }

    /**
     * @return array{secret?: string, provisioningUri?: string}
     */
    public function hydrate(ResponseInterface $response): array
    {
        $data = $response->toArray();

        return $data['item'] ?? [];
    }
}
