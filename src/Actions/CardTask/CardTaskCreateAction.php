<?php

declare(strict_types=1);

namespace Planka\Bridge\Actions\CardTask;

use Planka\Bridge\Contracts\Actions\ResponseResultInterface;
use Planka\Bridge\Contracts\Actions\AuthenticateInterface;
use Planka\Bridge\Contracts\Actions\ActionInterface;
use Planka\Bridge\Traits\CardTaskHydrateTrait;
use Planka\Bridge\Traits\AuthenticateTrait;

final class CardTaskCreateAction implements ActionInterface, AuthenticateInterface, ResponseResultInterface
{
    use AuthenticateTrait;
    use CardTaskHydrateTrait;

    public function __construct(
        private readonly string $taskListId,
        private readonly int $position,
        string $token,
        private readonly ?string $name = null,
        private readonly ?bool $isCompleted = null,
        private readonly ?string $linkedCardId = null,
    ) {
        $this->setToken($token);
    }

    public function url(): string
    {
        return "api/task-lists/{$this->taskListId}/tasks";
    }

    public function getOptions(): array
    {
        $json = [
            'position' => $this->position,
        ];

        if (null !== $this->name) {
            $json['name'] = $this->name;
        }

        if (null !== $this->isCompleted) {
            $json['isCompleted'] = $this->isCompleted;
        }

        if (null !== $this->linkedCardId) {
            $json['linkedCardId'] = $this->linkedCardId;
        }

        return [
            'json' => $json,
        ];
    }
}
