<?php

declare(strict_types=1);

namespace Planka\Bridge\Traits;

use Planka\Bridge\Views\Factory\Webhook\WebhookDtoFactory;
use Symfony\Contracts\HttpClient\ResponseInterface;
use Planka\Bridge\Views\Dto\Webhook\WebhookDto;
use Planka\Bridge\Exceptions\ResponseException;

use function Fp\Collection\map;

trait WebhookHydrateTrait
{
    final public function hydrate(ResponseInterface $response): WebhookDto|array
    {
        $result = $response->toArray();

        if (array_key_exists('item', $result)) {
            return (new WebhookDtoFactory())->create($result['item']);
        }

        if (array_key_exists('items', $result)) {
            return map($result['items'], fn(array $item) => (new WebhookDtoFactory())->create($item));
        }

        throw new ResponseException($response->getContent());
    }
}
