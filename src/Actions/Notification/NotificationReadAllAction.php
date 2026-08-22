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

use function Fp\Collection\map;

final class NotificationReadAllAction implements ActionInterface, AuthenticateInterface, ResponseResultInterface
{
    use AuthenticateTrait;

    public function __construct(string $token)
    {
        $this->setToken($token);
    }

    public function url(): string
    {
        return 'api/notifications/read-all';
    }

    public function getOptions(): array
    {
        return [];
    }

    /**
     * @return list<NotificationItemDto>
     */
    public function hydrate(ResponseInterface $response): array
    {
        $data = $response->toArray();

        return map($data['items'] ?? [], fn(array $item) => (new NotificationItemDtoFactory())->create($item));
    }
}
