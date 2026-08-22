<?php

declare(strict_types=1);

namespace Planka\Bridge\Views\Factory\TaskList;

use Planka\Bridge\Views\Dto\TaskList\TaskListDto;
use Planka\Bridge\Contracts\Factory\OutputInterface;
use Planka\Bridge\Traits\DateConverterTrait;

final class TaskListDtoFactory implements OutputInterface
{
    use DateConverterTrait;

    public function create(array $data): TaskListDto
    {
        return new TaskListDto(
            id: $data['id'],
            cardId: $data['cardId'],
            createdAt: $this->convertToDateTime($data['createdAt'] ?? null),
            updatedAt: $this->convertToDateTime($data['updatedAt'] ?? null),
            position: (int) ($data['position'] ?? 0),
            name: $data['name'] ?? '',
            showOnFrontOfCard: (bool) ($data['showOnFrontOfCard'] ?? false),
            hideCompletedTasks: (bool) ($data['hideCompletedTasks'] ?? false),
        );
    }
}
