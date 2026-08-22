<?php

declare(strict_types=1);

namespace Planka\Bridge\Views\Factory\CustomField;

use Planka\Bridge\Views\Dto\CustomField\CustomFieldGroupDto;
use Planka\Bridge\Contracts\Factory\OutputInterface;
use Planka\Bridge\Traits\DateConverterTrait;

final class CustomFieldGroupDtoFactory implements OutputInterface
{
    use DateConverterTrait;

    public function create(array $data): CustomFieldGroupDto
    {
        return new CustomFieldGroupDto(
            id: $data['id'],
            boardId: $data['boardId'] ?? null,
            cardId: $data['cardId'] ?? null,
            baseCustomFieldGroupId: $data['baseCustomFieldGroupId'] ?? null,
            createdAt: $this->convertToDateTime($data['createdAt'] ?? null),
            updatedAt: $this->convertToDateTime($data['updatedAt'] ?? null),
            position: (int) ($data['position'] ?? 0),
            name: $data['name'] ?? null,
        );
    }
}
