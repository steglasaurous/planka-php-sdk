<?php

declare(strict_types=1);

namespace Planka\Bridge\Controllers;

use Planka\Bridge\Actions\Webhook\WebhookCreateAction;
use Planka\Bridge\Actions\Webhook\WebhookDeleteAction;
use Planka\Bridge\Actions\Webhook\WebhookUpdateAction;
use Planka\Bridge\Actions\Webhook\WebhookListAction;
use Planka\Bridge\Views\Dto\Webhook\WebhookDto;
use Planka\Bridge\TransportClients\Client;
use Planka\Bridge\Config;

final class Webhook
{
    public function __construct(
        private readonly Config $config,
        private readonly Client $client,
    ) {}

    /**
     * 'GET /api/webhooks'.
     *
     * @return list<WebhookDto>
     */
    public function list(): array
    {
        return $this->client->get(new WebhookListAction(token: $this->config->getAuthToken()));
    }

    /** 'POST /api/webhooks' */
    public function create(
        string $name,
        string $url,
        ?string $accessToken = null,
        ?array $events = null,
        ?array $excludedEvents = null,
    ): WebhookDto {
        return $this->client->post(new WebhookCreateAction(
            name: $name,
            url: $url,
            token: $this->config->getAuthToken(),
            accessToken: $accessToken,
            events: $events,
            excludedEvents: $excludedEvents,
        ));
    }

    /** 'PATCH /api/webhooks/:id' */
    public function update(WebhookDto $webhook): WebhookDto
    {
        return $this->client->patch(new WebhookUpdateAction(
            webhook: $webhook,
            token: $this->config->getAuthToken(),
        ));
    }

    /** 'DELETE /api/webhooks/:id' */
    public function delete(string $id): WebhookDto
    {
        return $this->client->delete(new WebhookDeleteAction(id: $id, token: $this->config->getAuthToken()));
    }
}
