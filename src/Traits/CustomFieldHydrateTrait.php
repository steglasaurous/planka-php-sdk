<?php

declare(strict_types=1);

namespace Planka\Bridge\Traits;

use Planka\Bridge\Views\Factory\CustomField\CustomFieldDtoFactory;
use Planka\Bridge\Views\Dto\CustomField\CustomFieldDto;
use Symfony\Contracts\HttpClient\ResponseInterface;
use Planka\Bridge\Exceptions\ResponseException;

trait CustomFieldHydrateTrait
{
    final public function hydrate(ResponseInterface $response): CustomFieldDto
    {
        $result = $response->toArray();

        if (array_key_exists('item', $result)) {
            return (new CustomFieldDtoFactory())->create($result['item']);
        }

        throw new ResponseException($response->getContent());
    }
}
