<?php

declare(strict_types=1);

namespace Planka\Bridge\Traits;

use Planka\Bridge\Views\Factory\TaskList\TaskListDtoFactory;
use Planka\Bridge\Views\Dto\TaskList\TaskListDto;
use Symfony\Contracts\HttpClient\ResponseInterface;
use Planka\Bridge\Exceptions\ResponseException;

trait TaskListHydrateTrait
{
    final public function hydrate(ResponseInterface $response): TaskListDto
    {
        $result = $response->toArray();

        if (array_key_exists('item', $result)) {
            return (new TaskListDtoFactory())->create($result['item']);
        }

        throw new ResponseException($response->getContent());
    }
}
