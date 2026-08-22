<?php

declare(strict_types=1);

namespace Planka\Bridge\Actions\Card;

use Planka\Bridge\Contracts\Actions\ResponseResultInterface;
use Planka\Bridge\Contracts\Actions\AuthenticateInterface;
use Planka\Bridge\Contracts\Actions\ActionInterface;
use Planka\Bridge\Traits\AuthenticateTrait;
use Planka\Bridge\Traits\CardHydrateTrait;

final class CardDuplicateAction implements ActionInterface, AuthenticateInterface, ResponseResultInterface
{
    use AuthenticateTrait;
    use CardHydrateTrait;

    public function __construct(
        private readonly string $cardId,
        string $token,
        private readonly ?string $boardId = null,
        private readonly ?string $listId = null,
        private readonly ?int $position = null,
        private readonly ?string $name = null,
    ) {
        $this->setToken($token);
    }

    public function url(): string
    {
        return "api/cards/{$this->cardId}/duplicate";
    }

    public function getOptions(): array
    {
        $json = [];

        if (null !== $this->boardId) {
            $json['boardId'] = $this->boardId;
        }

        if (null !== $this->listId) {
            $json['listId'] = $this->listId;
        }

        if (null !== $this->position) {
            $json['position'] = $this->position;
        }

        if (null !== $this->name) {
            $json['name'] = $this->name;
        }

        return ['json' => $json];
    }
}
