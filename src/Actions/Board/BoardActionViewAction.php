<?php

declare(strict_types=1);

namespace Planka\Bridge\Actions\Board;

use Planka\Bridge\Views\Factory\Card\CardActionListDtoFactory;
use Planka\Bridge\Contracts\Actions\ResponseResultInterface;
use Planka\Bridge\Contracts\Actions\AuthenticateInterface;
use Planka\Bridge\Contracts\Actions\ActionInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;
use Planka\Bridge\Views\Dto\Card\CardActionListDto;
use Planka\Bridge\Traits\AuthenticateTrait;

final class BoardActionViewAction implements ActionInterface, AuthenticateInterface, ResponseResultInterface
{
    use AuthenticateTrait;

    public function __construct(
        private readonly string $boardId,
        string $token,
        private readonly ?string $beforeId = null,
    ) {
        $this->setToken($token);
    }

    public function url(): string
    {
        return "api/boards/{$this->boardId}/actions";
    }

    public function getOptions(): array
    {
        if (null === $this->beforeId) {
            return [];
        }

        return [
            'query' => [
                'beforeId' => $this->beforeId,
            ],
        ];
    }

    public function hydrate(ResponseInterface $response): CardActionListDto
    {
        return (new CardActionListDtoFactory())->create($response->toArray());
    }
}
