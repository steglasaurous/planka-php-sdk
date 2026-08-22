<?php

declare(strict_types=1);

namespace Planka\Bridge\Views\Factory\Card;

use Planka\Bridge\Contracts\Factory\OutputInterface;
use Planka\Bridge\Views\Dto\Card\CardTaskDto;
use Planka\Bridge\Traits\DateConverterTrait;

final class CardTaskDtoFactory implements OutputInterface
{
    use DateConverterTrait;

    public function create(array $data): CardTaskDto
    {
        return new CardTaskDto(
            id: $data['id'],
            createdAt: $this->convertToDateTime($data['createdAt'] ?? null),
            updatedAt: $this->convertToDateTime($data['updatedAt'] ?? null),
            position: (int) ($data['position'] ?? 0),
            name: $data['name'] ?? null,
            isCompleted: (bool) ($data['isCompleted'] ?? false),
            taskListId: $data['taskListId'] ?? '',
            linkedCardId: $data['linkedCardId'] ?? null,
            assigneeUserId: $data['assigneeUserId'] ?? null,
        );
    }
}
