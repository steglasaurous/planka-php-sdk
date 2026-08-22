<?php

declare(strict_types=1);

namespace Planka\Bridge\Actions\Webhook;

use Planka\Bridge\Contracts\Actions\ResponseResultInterface;
use Planka\Bridge\Contracts\Actions\AuthenticateInterface;
use Planka\Bridge\Contracts\Actions\ActionInterface;
use Planka\Bridge\Traits\WebhookHydrateTrait;
use Planka\Bridge\Traits\AuthenticateTrait;

final class WebhookCreateAction implements ActionInterface, AuthenticateInterface, ResponseResultInterface
{
    use AuthenticateTrait;
    use WebhookHydrateTrait;

    /**
     * @param list<string>|null $events
     * @param list<string>|null $excludedEvents
     */
    public function __construct(
        private readonly string $name,
        private readonly string $url,
        string $token,
        private readonly ?string $accessToken = null,
        private readonly ?array $events = null,
        private readonly ?array $excludedEvents = null,
    ) {
        $this->setToken($token);
    }

    public function url(): string
    {
        return 'api/webhooks';
    }

    public function getOptions(): array
    {
        $json = [
            'name' => $this->name,
            'url' => $this->url,
        ];

        if (null !== $this->accessToken) {
            $json['accessToken'] = $this->accessToken;
        }

        if (null !== $this->events) {
            $json['events'] = $this->events;
        }

        if (null !== $this->excludedEvents) {
            $json['excludedEvents'] = $this->excludedEvents;
        }

        return ['json' => $json];
    }
}
