<?php

declare(strict_types=1);

namespace Planka\Bridge\Actions\TaskList;

use Planka\Bridge\Contracts\Actions\ResponseResultInterface;
use Planka\Bridge\Contracts\Actions\AuthenticateInterface;
use Planka\Bridge\Contracts\Actions\ActionInterface;
use Planka\Bridge\Traits\TaskListHydrateTrait;
use Planka\Bridge\Traits\AuthenticateTrait;

final class TaskListDeleteAction implements ActionInterface, AuthenticateInterface, ResponseResultInterface
{
    use AuthenticateTrait;
    use TaskListHydrateTrait;

    public function __construct(private readonly string $taskListId, string $token)
    {
        $this->setToken($token);
    }

    public function url(): string
    {
        return "api/task-lists/{$this->taskListId}";
    }

    public function getOptions(): array
    {
        return [];
    }
}
