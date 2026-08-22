<?php

declare(strict_types=1);

namespace Planka\Bridge\Actions\NotificationService;

use Planka\Bridge\Contracts\Actions\ResponseResultInterface;
use Planka\Bridge\Contracts\Actions\AuthenticateInterface;
use Planka\Bridge\Traits\NotificationServiceHydrateTrait;
use Planka\Bridge\Enum\NotificationServiceFormatEnum;
use Planka\Bridge\Contracts\Actions\ActionInterface;
use Planka\Bridge\Traits\AuthenticateTrait;

final class NotificationServiceUpdateAction implements ActionInterface, AuthenticateInterface, ResponseResultInterface
{
    use AuthenticateTrait;
    use NotificationServiceHydrateTrait;

    public function __construct(
        private readonly string $id,
        string $token,
        private readonly ?string $url = null,
        private readonly ?NotificationServiceFormatEnum $format = null,
    ) {
        $this->setToken($token);
    }

    public function url(): string
    {
        return "api/notification-services/{$this->id}";
    }

    public function getOptions(): array
    {
        $json = [];

        if (null !== $this->url) {
            $json['url'] = $this->url;
        }

        if (null !== $this->format) {
            $json['format'] = $this->format->value;
        }

        return ['json' => $json];
    }
}
