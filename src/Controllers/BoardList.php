<?php

declare(strict_types=1);

namespace Planka\Bridge\Controllers;

use Planka\Bridge\Actions\BoardList\BoardListMoveCardsAction;
use Planka\Bridge\Actions\BoardList\BoardListCreateAction;
use Planka\Bridge\Actions\BoardList\BoardListDeleteAction;
use Planka\Bridge\Actions\BoardList\BoardListUpdateAction;
use Planka\Bridge\Actions\BoardList\BoardListClearAction;
use Planka\Bridge\Actions\BoardList\BoardListSortAction;
use Planka\Bridge\Actions\BoardList\BoardListViewAction;
use Planka\Bridge\Views\Dto\Board\BoardListDto;
use Planka\Bridge\Enum\ListSortFieldEnum;
use Planka\Bridge\TransportClients\Client;
use Planka\Bridge\Enum\ListColorEnum;
use Planka\Bridge\Enum\ListTypeEnum;
use Planka\Bridge\Enum\SortOrderEnum;
use Planka\Bridge\Config;

final class BoardList
{
    public function __construct(
        private readonly Config $config,
        private readonly Client $client,
    ) {}

    /** 'POST /api/boards/:boardId/lists' */
    public function create(
        string $boardId,
        string $name,
        int $position,
        ListTypeEnum $type = ListTypeEnum::ACTIVE,
    ): BoardListDto {
        return $this->client->post(new BoardListCreateAction(
            boardId: $boardId,
            name: $name,
            position: $position,
            type: $type,
            token: $this->config->getAuthToken(),
        ));
    }

    /** 'PATCH /api/lists/:id' */
    public function update(
        string $listId,
        ?string $name = null,
        ?string $boardId = null,
        ?ListTypeEnum $type = null,
        ?int $position = null,
        ?ListColorEnum $color = null,
    ): BoardListDto {
        return $this->client->patch(new BoardListUpdateAction(
            listId: $listId,
            token: $this->config->getAuthToken(),
            name: $name,
            boardId: $boardId,
            type: $type,
            position: $position,
            color: $color,
        ));
    }

    /** 'GET /api/lists/:id' */
    public function get(string $listId): BoardListDto
    {
        return $this->client->get(new BoardListViewAction(listId: $listId, token: $this->config->getAuthToken()));
    }

    /** 'POST /api/lists/:id/sort' */
    public function sort(string $listId, ListSortFieldEnum $fieldName, ?SortOrderEnum $order = null): BoardListDto
    {
        return $this->client->post(new BoardListSortAction(
            listId: $listId,
            fieldName: $fieldName,
            token: $this->config->getAuthToken(),
            order: $order,
        ));
    }

    /** 'POST /api/lists/:id/clear' */
    public function clear(string $listId): BoardListDto
    {
        return $this->client->post(new BoardListClearAction(listId: $listId, token: $this->config->getAuthToken()));
    }

    /** 'POST /api/lists/:id/move-cards' */
    public function moveCards(string $listId, string $targetListId): BoardListDto
    {
        return $this->client->post(new BoardListMoveCardsAction(
            listId: $listId,
            targetListId: $targetListId,
            token: $this->config->getAuthToken(),
        ));
    }

    /** 'DELETE /api/lists/:id' */
    public function delete(string $listId): BoardListDto
    {
        return $this->client->delete(new BoardListDeleteAction(listId: $listId, token: $this->config->getAuthToken()));
    }
}
