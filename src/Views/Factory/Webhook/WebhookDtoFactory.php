<?php

declare(strict_types=1);

namespace Planka\Bridge\Views\Factory\Webhook;

use Planka\Bridge\Contracts\Factory\OutputInterface;
use Planka\Bridge\Views\Dto\Webhook\WebhookDto;
use Planka\Bridge\Traits\DateConverterTrait;

final class WebhookDtoFactory implements OutputInterface
{
    use DateConverterTrait;

    public function create(array $data): WebhookDto
    {
        return new WebhookDto(
            id: $data['id'],
            name: $data['name'],
            url: $data['url'],
            accessToken: $data['accessToken'] ?? null,
            events: $data['events'] ?? null,
            excludedEvents: $data['excludedEvents'] ?? null,
            createdAt: $this->convertToDateTime($data['createdAt'] ?? null),
            updatedAt: $this->convertToDateTime($data['updatedAt'] ?? null),
        );
    }
}
