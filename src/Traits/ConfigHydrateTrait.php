<?php

declare(strict_types=1);

namespace Planka\Bridge\Traits;

use Planka\Bridge\Views\Factory\Config\ConfigDtoFactory;
use Symfony\Contracts\HttpClient\ResponseInterface;
use Planka\Bridge\Views\Dto\Config\ConfigDto;
use Planka\Bridge\Exceptions\ResponseException;

trait ConfigHydrateTrait
{
    final public function hydrate(ResponseInterface $response): ConfigDto
    {
        $result = $response->toArray();

        if (array_key_exists('item', $result)) {
            return (new ConfigDtoFactory())->create($result['item']);
        }

        throw new ResponseException($response->getContent());
    }
}
