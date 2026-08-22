<?php

declare(strict_types=1);

namespace Planka\Bridge\Actions\TaskList;

use Planka\Bridge\Contracts\Actions\ResponseResultInterface;
use Planka\Bridge\Contracts\Actions\AuthenticateInterface;
use Planka\Bridge\Contracts\Actions\ActionInterface;
use Planka\Bridge\Views\Dto\TaskList\TaskListDto;
use Planka\Bridge\Traits\TaskListHydrateTrait;
use Planka\Bridge\Traits\AuthenticateTrait;

final class TaskListUpdateAction implements ActionInterface, AuthenticateInterface, ResponseResultInterface
{
    use AuthenticateTrait;
    use TaskListHydrateTrait;

    public function __construct(private readonly TaskListDto $taskList, string $token)
    {
        $this->setToken($token);
    }

    public function url(): string
    {
        return "api/task-lists/{$this->taskList->id}";
    }

    public function getOptions(): array
    {
        return [
            'json' => [
                'position' => $this->taskList->position,
                'name' => $this->taskList->name,
                'showOnFrontOfCard' => $this->taskList->showOnFrontOfCard,
                'hideCompletedTasks' => $this->taskList->hideCompletedTasks,
            ],
        ];
    }
}
