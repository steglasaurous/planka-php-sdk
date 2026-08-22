<?php

declare(strict_types=1);

namespace Planka\Bridge\Controllers;

use Planka\Bridge\Actions\TaskList\TaskListCreateAction;
use Planka\Bridge\Actions\TaskList\TaskListDeleteAction;
use Planka\Bridge\Actions\TaskList\TaskListUpdateAction;
use Planka\Bridge\Actions\TaskList\TaskListViewAction;
use Planka\Bridge\Views\Dto\TaskList\TaskListDto;
use Planka\Bridge\TransportClients\Client;
use Planka\Bridge\Config;

final class TaskList
{
    public function __construct(
        private readonly Config $config,
        private readonly Client $client,
    ) {}

    /** 'POST /api/cards/:cardId/task-lists' */
    public function create(
        string $cardId,
        int $position,
        string $name,
        ?bool $showOnFrontOfCard = null,
        ?bool $hideCompletedTasks = null,
    ): TaskListDto {
        return $this->client->post(new TaskListCreateAction(
            cardId: $cardId,
            position: $position,
            name: $name,
            token: $this->config->getAuthToken(),
            showOnFrontOfCard: $showOnFrontOfCard,
            hideCompletedTasks: $hideCompletedTasks,
        ));
    }

    /** 'GET /api/task-lists/:id' */
    public function get(string $taskListId): TaskListDto
    {
        return $this->client->get(new TaskListViewAction(
            taskListId: $taskListId,
            token: $this->config->getAuthToken(),
        ));
    }

    /** 'PATCH /api/task-lists/:id' */
    public function update(TaskListDto $taskList): TaskListDto
    {
        return $this->client->patch(new TaskListUpdateAction(
            taskList: $taskList,
            token: $this->config->getAuthToken(),
        ));
    }

    /** 'DELETE /api/task-lists/:id' */
    public function delete(string $taskListId): TaskListDto
    {
        return $this->client->delete(new TaskListDeleteAction(
            taskListId: $taskListId,
            token: $this->config->getAuthToken(),
        ));
    }
}
