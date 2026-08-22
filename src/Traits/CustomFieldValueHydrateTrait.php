<?php

declare(strict_types=1);

namespace Planka\Bridge\Traits;

use Planka\Bridge\Views\Factory\CustomField\CustomFieldValueDtoFactory;
use Planka\Bridge\Views\Dto\CustomField\CustomFieldValueDto;
use Symfony\Contracts\HttpClient\ResponseInterface;
use Planka\Bridge\Exceptions\ResponseException;

trait CustomFieldValueHydrateTrait
{
    final public function hydrate(ResponseInterface $response): CustomFieldValueDto
    {
        $result = $response->toArray();

        if (array_key_exists('item', $result)) {
            return (new CustomFieldValueDtoFactory())->create($result['item']);
        }

        throw new ResponseException($response->getContent());
    }
}
