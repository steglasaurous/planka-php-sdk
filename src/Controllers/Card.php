<?php

declare(strict_types=1);

namespace Planka\Bridge\Controllers;

use Planka\Bridge\Actions\Card\CardReadNotificationsAction;
use Planka\Bridge\Actions\Card\CardClearDueDateAction;
use Planka\Bridge\Actions\Card\CardDuplicateAction;
use Planka\Bridge\Actions\Card\CardSubscribeAction;
use Planka\Bridge\Actions\Card\CardCreateAction;
use Planka\Bridge\Actions\Card\CardDeleteAction;
use Planka\Bridge\Actions\Card\CardUpdateAction;
use Planka\Bridge\Actions\Card\CardTimerAction;
use Planka\Bridge\Actions\Card\CardListAction;
use Planka\Bridge\Actions\Card\CardMoveAction;
use Planka\Bridge\Actions\Card\CardViewAction;
use Planka\Bridge\TransportClients\Client;
use Planka\Bridge\Views\Dto\Card\CardDto;
use Planka\Bridge\Enum\CardTypeEnum;
use Planka\Bridge\Config;

final class Card
{
    public function __construct(
        private readonly Config $config,
        private readonly Client $client,
    ) {}

    /** 'POST /api/lists/:listId/cards' */
    public function create(
        string $listId,
        string $name,
        int $position,
        CardTypeEnum|string $type = CardTypeEnum::PROJECT,
        ?string $description = null,
        ?\DateTimeInterface $dueDate = null,
        ?bool $isDueCompleted = null,
    ): CardDto {
        $cardType = $type instanceof CardTypeEnum ? $type : CardTypeEnum::from($type);

        return $this->client->post(new CardCreateAction(
            listId: $listId,
            name: $name,
            type: $cardType,
            position: $position,
            token: $this->config->getAuthToken(),
            description: $description,
            dueDate: $dueDate,
            isDueCompleted: $isDueCompleted,
        ));
    }

    /**
     * 'GET /api/lists/:listId/cards'.
     *
     * @param list<string>|null $userIds
     * @param list<string>|null $labelIds
     *
     * @return list<CardDto>
     */
    public function list(
        string $listId,
        ?string $beforeId = null,
        ?string $beforeListChangedAt = null,
        ?string $search = null,
        ?array $userIds = null,
        ?array $labelIds = null,
    ): array {
        return $this->client->get(new CardListAction(
            listId: $listId,
            token: $this->config->getAuthToken(),
            beforeId: $beforeId,
            beforeListChangedAt: $beforeListChangedAt,
            search: $search,
            userIds: $userIds,
            labelIds: $labelIds,
        ));
    }

    /** 'GET /api/cards/:id' */
    public function get(string $cardId): CardDto
    {
        return $this->client->get(new CardViewAction(cardId: $cardId, token: $this->config->getAuthToken()));
    }

    /** 'POST /api/cards/:id/duplicate' */
    public function duplicate(
        string $cardId,
        ?string $boardId = null,
        ?string $listId = null,
        ?int $position = null,
        ?string $name = null,
    ): CardDto {
        return $this->client->post(new CardDuplicateAction(
            cardId: $cardId,
            token: $this->config->getAuthToken(),
            boardId: $boardId,
            listId: $listId,
            position: $position,
            name: $name,
        ));
    }

    /** 'PATCH /api/cards/:id' */
    public function update(CardDto $card): CardDto
    {
        return $this->client->patch(new CardUpdateAction(
            card: $card,
            token: $this->config->getAuthToken(),
        ));
    }

    /** 'PATCH /api/cards/:id' */
    public function clearTime(CardDto $card): CardDto
    {
        return $this->client->patch(new CardClearDueDateAction(
            card: $card,
            token: $this->config->getAuthToken(),
        ));
    }

    /** 'PATCH /api/cards/:id' */
    public function moveCard(CardDto $card): CardDto
    {
        return $this->client->patch(new CardMoveAction(
            card: $card,
            token: $this->config->getAuthToken(),
        ));
    }

    /** 'PATCH /api/cards/:id' */
    public function addSpentTime(CardDto $card, int $seconds): CardDto
    {
        return $this->client->patch(new CardUpdateAction(
            card: $card,
            token: $this->config->getAuthToken(),
            spentSeconds: $seconds,
        ));
    }

    /** 'PATCH /api/cards/:id' */
    public function triggerTimer(CardDto $card, bool $start): CardDto
    {
        return $this->client->patch(new CardTimerAction(
            card: $card,
            token: $this->config->getAuthToken(),
            start: $start,
        ));
    }

    /** 'DELETE /api/cards/:id' */
    public function delete(string $cardId): void
    {
        $this->client->delete(new CardDeleteAction(cardId: $cardId, token: $this->config->getAuthToken()));
    }

    /** 'PATCH /api/cards/:id' with isSubscribed */
    public function subscribe(string $cardId, bool $isSubscribed = true): CardDto
    {
        return $this->client->patch(new CardSubscribeAction(
            cardId: $cardId,
            isSubscribed: $isSubscribed,
            token: $this->config->getAuthToken(),
        ));
    }

    /** 'PATCH /api/cards/:id' with isSubscribed=false */
    public function unsubscribe(string $cardId): CardDto
    {
        return $this->subscribe($cardId, false);
    }

    /** 'POST /api/cards/:id/read-notifications' */
    public function readNotifications(string $cardId): CardDto
    {
        return $this->client->post(new CardReadNotificationsAction(
            cardId: $cardId,
            token: $this->config->getAuthToken(),
        ));
    }
}
