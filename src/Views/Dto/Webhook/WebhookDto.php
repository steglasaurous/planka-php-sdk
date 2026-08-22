<?php

declare(strict_types=1);

namespace Planka\Bridge\Views\Dto\Webhook;

use Planka\Bridge\Contracts\Dto\OutputDtoInterface;

class WebhookDto implements OutputDtoInterface
{
    /**
     * @param list<string>|null $events
     * @param list<string>|null $excludedEvents
     */
    public function __construct(
        public readonly string $id,
        public string $name,
        public string $url,
        public ?string $accessToken,
        public ?array $events,
        public ?array $excludedEvents,
        public readonly ?\DateTimeImmutable $createdAt,
        public readonly ?\DateTimeImmutable $updatedAt,
    ) {}
}
