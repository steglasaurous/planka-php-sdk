<?php

declare(strict_types=1);

namespace Planka\Bridge\Controllers;

use Planka\Bridge\Actions\Notification\NotificationReadAllAction;
use Planka\Bridge\Actions\Notification\NotificationUpdateAction;
use Planka\Bridge\Actions\Notification\NotificationListAction;
use Planka\Bridge\Actions\Notification\NotificationVewAction;
use Planka\Bridge\Views\Dto\Notification\NotificationItemDto;
use Planka\Bridge\Views\Dto\Notification\NotificationListDto;
use Planka\Bridge\TransportClients\Client;
use Planka\Bridge\Config;

final class Notification
{
    public function __construct(
        private readonly Config $config,
        private readonly Client $client,
    ) {}

    /** 'GET /api/notifications' */
    public function list(): NotificationListDto
    {
        return $this->client->get(new NotificationListAction(token: $this->config->getAuthToken()));
    }

    /** 'GET /api/notifications/:id' */
    public function getOne(string $notifyId): NotificationItemDto
    {
        return $this->client->get(new NotificationVewAction(
            notifyId: $notifyId,
            token: $this->config->getAuthToken(),
        ));
    }

    /** 'PATCH /api/notifications/:id' */
    public function markIsRead(string $notifyId): NotificationItemDto
    {
        return $this->client->patch(new NotificationUpdateAction(
            notifyId: $notifyId,
            isRead: true,
            token: $this->config->getAuthToken(),
        ));
    }

    /**
     * @param list<string> $notifyIdList
     *
     * @return list<NotificationItemDto>
     */
    public function markManyIsRead(array $notifyIdList): array
    {
        return array_map(fn(string $id) => $this->markIsRead($id), $notifyIdList);
    }

    /** 'PATCH /api/notifications/:id' */
    public function markIsNotRead(string $notifyId): NotificationItemDto
    {
        return $this->client->patch(new NotificationUpdateAction(
            notifyId: $notifyId,
            isRead: false,
            token: $this->config->getAuthToken(),
        ));
    }

    /**
     * @param list<string> $notifyIdList
     *
     * @return list<NotificationItemDto>
     */
    public function markManyIsNotRead(array $notifyIdList): array
    {
        return array_map(fn(string $id) => $this->markIsNotRead($id), $notifyIdList);
    }

    /**
     * 'POST /api/notifications/read-all'.
     *
     * @return list<NotificationItemDto>
     */
    public function readAll(): array
    {
        return $this->client->post(new NotificationReadAllAction(token: $this->config->getAuthToken()));
    }
}
