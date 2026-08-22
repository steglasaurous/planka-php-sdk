<?php

declare(strict_types=1);

namespace Planka\Bridge\Traits;

use Planka\Bridge\Views\Factory\NotificationService\NotificationServiceDtoFactory;
use Planka\Bridge\Views\Dto\NotificationService\NotificationServiceDto;
use Symfony\Contracts\HttpClient\ResponseInterface;
use Planka\Bridge\Exceptions\ResponseException;

trait NotificationServiceHydrateTrait
{
    final public function hydrate(ResponseInterface $response): NotificationServiceDto
    {
        $result = $response->toArray();

        if (array_key_exists('item', $result)) {
            return (new NotificationServiceDtoFactory())->create($result['item']);
        }

        throw new ResponseException($response->getContent());
    }
}
