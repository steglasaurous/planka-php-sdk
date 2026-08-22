<?php

declare(strict_types=1);

namespace Planka\Bridge\Actions\Card;

use Planka\Bridge\Contracts\Actions\ResponseResultInterface;
use Planka\Bridge\Contracts\Actions\AuthenticateInterface;
use Planka\Bridge\Contracts\Actions\ActionInterface;
use Planka\Bridge\Traits\AuthenticateTrait;
use Planka\Bridge\Traits\CardHydrateTrait;
use Planka\Bridge\Enum\CardTypeEnum;

final class CardCreateAction implements ActionInterface, AuthenticateInterface, ResponseResultInterface
{
    use AuthenticateTrait;
    use CardHydrateTrait;

    public function __construct(
        private readonly string $listId,
        private readonly string $name,
        private readonly CardTypeEnum $type,
        private readonly int $position,
        string $token,
        private readonly ?string $description = null,
        private readonly ?\DateTimeInterface $dueDate = null,
        private readonly ?bool $isDueCompleted = null,
    ) {
        $this->setToken($token);
    }

    public function url(): string
    {
        return "api/lists/{$this->listId}/cards";
    }

    public function getOptions(): array
    {
        $json = [
            'name' => $this->name,
            'position' => $this->position,
            'type' => $this->type->value,
        ];

        if (null !== $this->description) {
            $json['description'] = $this->description;
        }

        if (null !== $this->dueDate) {
            $json['dueDate'] = $this->dueDate->format('Y-m-d\TH:i:s.v\Z');
        }

        if (null !== $this->isDueCompleted) {
            $json['isDueCompleted'] = $this->isDueCompleted;
        }

        return [
            'json' => $json,
        ];
    }
}
