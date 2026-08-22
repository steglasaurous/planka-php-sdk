<?php

declare(strict_types=1);

namespace Planka\Bridge\Controllers;

use Planka\Bridge\Actions\NotificationService\NotificationServiceCreateAction;
use Planka\Bridge\Actions\NotificationService\NotificationServiceDeleteAction;
use Planka\Bridge\Actions\NotificationService\NotificationServiceUpdateAction;
use Planka\Bridge\Actions\NotificationService\NotificationServiceTestAction;
use Planka\Bridge\Views\Dto\NotificationService\NotificationServiceDto;
use Planka\Bridge\Enum\NotificationServiceFormatEnum;
use Planka\Bridge\TransportClients\Client;
use Planka\Bridge\Config;

final class NotificationService
{
    public function __construct(
        private readonly Config $config,
        private readonly Client $client,
    ) {}

    /** 'POST /api/boards/:boardId/notification-services' */
    public function createForBoard(string $boardId, string $url, NotificationServiceFormatEnum $format): NotificationServiceDto
    {
        return $this->client->post(new NotificationServiceCreateAction(
            parentId: $boardId,
            forBoard: true,
            url: $url,
            format: $format,
            token: $this->config->getAuthToken(),
        ));
    }

    /** 'POST /api/users/:userId/notification-services' */
    public function createForUser(string $userId, string $url, NotificationServiceFormatEnum $format): NotificationServiceDto
    {
        return $this->client->post(new NotificationServiceCreateAction(
            parentId: $userId,
            forBoard: false,
            url: $url,
            format: $format,
            token: $this->config->getAuthToken(),
        ));
    }

    /** 'PATCH /api/notification-services/:id' */
    public function update(
        string $id,
        ?string $url = null,
        ?NotificationServiceFormatEnum $format = null,
    ): NotificationServiceDto {
        return $this->client->patch(new NotificationServiceUpdateAction(
            id: $id,
            token: $this->config->getAuthToken(),
            url: $url,
            format: $format,
        ));
    }

    /** 'DELETE /api/notification-services/:id' */
    public function delete(string $id): NotificationServiceDto
    {
        return $this->client->delete(new NotificationServiceDeleteAction(
            id: $id,
            token: $this->config->getAuthToken(),
        ));
    }

    /** 'POST /api/notification-services/:id/test' */
    public function test(string $id): NotificationServiceDto
    {
        return $this->client->post(new NotificationServiceTestAction(
            id: $id,
            token: $this->config->getAuthToken(),
        ));
    }
}
