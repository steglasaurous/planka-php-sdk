<?php

declare(strict_types=1);

namespace Planka\Bridge\Actions\Webhook;

use Planka\Bridge\Contracts\Actions\ResponseResultInterface;
use Planka\Bridge\Contracts\Actions\AuthenticateInterface;
use Planka\Bridge\Contracts\Actions\ActionInterface;
use Planka\Bridge\Views\Dto\Webhook\WebhookDto;
use Planka\Bridge\Traits\WebhookHydrateTrait;
use Planka\Bridge\Traits\AuthenticateTrait;

final class WebhookUpdateAction implements ActionInterface, AuthenticateInterface, ResponseResultInterface
{
    use AuthenticateTrait;
    use WebhookHydrateTrait;

    public function __construct(private readonly WebhookDto $webhook, string $token)
    {
        $this->setToken($token);
    }

    public function url(): string
    {
        return "api/webhooks/{$this->webhook->id}";
    }

    public function getOptions(): array
    {
        return [
            'json' => [
                'name' => $this->webhook->name,
                'url' => $this->webhook->url,
                'accessToken' => $this->webhook->accessToken,
                'events' => $this->webhook->events,
                'excludedEvents' => $this->webhook->excludedEvents,
            ],
        ];
    }
}
