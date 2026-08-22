<?php

declare(strict_types=1);

namespace Planka\Bridge\Controllers;

use Planka\Bridge\Actions\Board\BoardActionViewAction;
use Planka\Bridge\Views\Dto\Card\CardActionListDto;
use Planka\Bridge\Actions\Board\BoardSubscribeAction;
use Planka\Bridge\Actions\Board\BoardCreateAction;
use Planka\Bridge\Actions\Board\BoardDeleteAction;
use Planka\Bridge\Actions\Board\BoardUpdateAction;
use Planka\Bridge\Actions\Board\BoardViewAction;
use Planka\Bridge\Views\Dto\Board\BoardDto;
use Planka\Bridge\TransportClients\Client;
use Planka\Bridge\Enum\BoardViewEnum;
use Planka\Bridge\Enum\CardTypeEnum;
use Planka\Bridge\Config;

final class Board
{
    public function __construct(
        private readonly Config $config,
        private readonly Client $client,
    ) {}

    /** 'POST /api/projects/:projectId/boards' */
    public function create(
        string $projectId,
        string $name,
        int $position,
        ?string $importType = null,
        ?string $importFile = null,
    ): BoardDto {
        return $this->client->post(new BoardCreateAction(
            projectId: $projectId,
            name: $name,
            position: $position,
            token: $this->config->getAuthToken(),
            importType: $importType,
            importFile: $importFile,
        ));
    }

    /** 'GET /api/boards/:id' */
    public function get(string $boardId): BoardDto
    {
        return $this->client->get(new BoardViewAction(token: $this->config->getAuthToken(), boardId: $boardId));
    }

    /** 'PATCH /api/boards/:id' */
    public function update(
        string $boardId,
        ?string $name = null,
        ?int $position = null,
        ?BoardViewEnum $defaultView = null,
        ?CardTypeEnum $defaultCardType = null,
        ?bool $limitCardTypesToDefaultOne = null,
        ?bool $alwaysDisplayCardCreator = null,
        ?bool $displayCardAges = null,
        ?bool $expandTaskListsByDefault = null,
        ?bool $isSubscribed = null,
    ): BoardDto {
        return $this->client->patch(new BoardUpdateAction(
            boardId: $boardId,
            token: $this->config->getAuthToken(),
            name: $name,
            position: $position,
            defaultView: $defaultView,
            defaultCardType: $defaultCardType,
            limitCardTypesToDefaultOne: $limitCardTypesToDefaultOne,
            alwaysDisplayCardCreator: $alwaysDisplayCardCreator,
            displayCardAges: $displayCardAges,
            expandTaskListsByDefault: $expandTaskListsByDefault,
            isSubscribed: $isSubscribed,
        ));
    }

    /** 'PATCH /api/boards/:id' with isSubscribed */
    public function subscribe(string $boardId, bool $isSubscribed = true): BoardDto
    {
        return $this->client->patch(new BoardSubscribeAction(
            boardId: $boardId,
            isSubscribed: $isSubscribed,
            token: $this->config->getAuthToken(),
        ));
    }

    /** 'GET /api/boards/:boardId/actions' */
    public function getActions(string $boardId, ?string $beforeId = null): CardActionListDto
    {
        return $this->client->get(new BoardActionViewAction(
            boardId: $boardId,
            token: $this->config->getAuthToken(),
            beforeId: $beforeId,
        ));
    }

    /** 'DELETE /api/boards/:id' */
    public function delete(string $boardId): BoardDto
    {
        return $this->client->delete(new BoardDeleteAction(boardId: $boardId, token: $this->config->getAuthToken()));
    }
}
