<?php

declare(strict_types=1);

namespace Planka\Bridge\Traits;

use Planka\Bridge\Views\Factory\CustomField\CustomFieldGroupDtoFactory;
use Planka\Bridge\Views\Dto\CustomField\CustomFieldGroupDto;
use Symfony\Contracts\HttpClient\ResponseInterface;
use Planka\Bridge\Exceptions\ResponseException;

trait CustomFieldGroupHydrateTrait
{
    final public function hydrate(ResponseInterface $response): CustomFieldGroupDto
    {
        $result = $response->toArray();

        if (array_key_exists('item', $result)) {
            return (new CustomFieldGroupDtoFactory())->create($result['item']);
        }

        throw new ResponseException($response->getContent());
    }
}
