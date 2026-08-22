<?php

declare(strict_types=1);

namespace Planka\Bridge\Actions\Notification;

use Planka\Bridge\Views\Factory\Notification\NotificationItemDtoFactory;
use Planka\Bridge\Views\Dto\Notification\NotificationItemDto;
use Planka\Bridge\Contracts\Actions\ResponseResultInterface;
use Planka\Bridge\Contracts\Actions\AuthenticateInterface;
use Planka\Bridge\Contracts\Actions\ActionInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;
use Planka\Bridge\Traits\AuthenticateTrait;

final class NotificationUpdateAction implements ActionInterface, AuthenticateInterface, ResponseResultInterface
{
    use AuthenticateTrait;

    public function __construct(
        private readonly string $notifyId,
        private readonly bool $isRead,
        string $token,
    ) {
        $this->setToken($token);
    }

    public function url(): string
    {
        return "api/notifications/{$this->notifyId}";
    }

    public function getOptions(): array
    {
        return [
            'json' => [
                'isRead' => $this->isRead,
            ],
        ];
    }

    public function hydrate(ResponseInterface $response): NotificationItemDto
    {
        $data = $response->toArray();

        return (new NotificationItemDtoFactory())->create($data['item'] ?? $data);
    }
}
