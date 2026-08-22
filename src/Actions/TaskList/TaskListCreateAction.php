<?php

declare(strict_types=1);

namespace Planka\Bridge\Actions\TaskList;

use Planka\Bridge\Contracts\Actions\ResponseResultInterface;
use Planka\Bridge\Contracts\Actions\AuthenticateInterface;
use Planka\Bridge\Contracts\Actions\ActionInterface;
use Planka\Bridge\Traits\TaskListHydrateTrait;
use Planka\Bridge\Traits\AuthenticateTrait;

final class TaskListCreateAction implements ActionInterface, AuthenticateInterface, ResponseResultInterface
{
    use AuthenticateTrait;
    use TaskListHydrateTrait;

    public function __construct(
        private readonly string $cardId,
        private readonly int $position,
        private readonly string $name,
        string $token,
        private readonly ?bool $showOnFrontOfCard = null,
        private readonly ?bool $hideCompletedTasks = null,
    ) {
        $this->setToken($token);
    }

    public function url(): string
    {
        return "api/cards/{$this->cardId}/task-lists";
    }

    public function getOptions(): array
    {
        $json = [
            'position' => $this->position,
            'name' => $this->name,
        ];

        if (null !== $this->showOnFrontOfCard) {
            $json['showOnFrontOfCard'] = $this->showOnFrontOfCard;
        }

        if (null !== $this->hideCompletedTasks) {
            $json['hideCompletedTasks'] = $this->hideCompletedTasks;
        }

        return ['json' => $json];
    }
}
