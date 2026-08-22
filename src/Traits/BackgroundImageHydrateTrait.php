<?php

declare(strict_types=1);

namespace Planka\Bridge\Traits;

use Planka\Bridge\Views\Factory\Background\BackgroundImageDtoFactory;
use Symfony\Contracts\HttpClient\ResponseInterface;
use Planka\Bridge\Views\Dto\Background\BackgroundImageDto;
use Planka\Bridge\Exceptions\ResponseException;

trait BackgroundImageHydrateTrait
{
    final public function hydrate(ResponseInterface $response): BackgroundImageDto
    {
        $result = $response->toArray();

        if (array_key_exists('item', $result)) {
            $dto = (new BackgroundImageDtoFactory())->create($result['item']);

            if (null !== $dto) {
                return $dto;
            }
        }

        throw new ResponseException($response->getContent());
    }
}
