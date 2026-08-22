<?php

declare(strict_types=1);

namespace Planka\Bridge\Actions\NotificationService;

use Planka\Bridge\Contracts\Actions\ResponseResultInterface;
use Planka\Bridge\Contracts\Actions\AuthenticateInterface;
use Planka\Bridge\Traits\NotificationServiceHydrateTrait;
use Planka\Bridge\Enum\NotificationServiceFormatEnum;
use Planka\Bridge\Contracts\Actions\ActionInterface;
use Planka\Bridge\Traits\AuthenticateTrait;

final class NotificationServiceCreateAction implements ActionInterface, AuthenticateInterface, ResponseResultInterface
{
    use AuthenticateTrait;
    use NotificationServiceHydrateTrait;

    public function __construct(
        private readonly string $parentId,
        private readonly bool $forBoard,
        private readonly string $url,
        private readonly NotificationServiceFormatEnum $format,
        string $token,
    ) {
        $this->setToken($token);
    }

    public function url(): string
    {
        return $this->forBoard
            ? "api/boards/{$this->parentId}/notification-services"
            : "api/users/{$this->parentId}/notification-services";
    }

    public function getOptions(): array
    {
        return [
            'json' => [
                'url' => $this->url,
                'format' => $this->format->value,
            ],
        ];
    }
}
