<?php

declare(strict_types=1);

namespace Planka\Bridge\Views\Factory\CustomField;

use Planka\Bridge\Views\Dto\CustomField\CustomFieldValueDto;
use Planka\Bridge\Contracts\Factory\OutputInterface;
use Planka\Bridge\Traits\DateConverterTrait;

final class CustomFieldValueDtoFactory implements OutputInterface
{
    use DateConverterTrait;

    public function create(array $data): CustomFieldValueDto
    {
        return new CustomFieldValueDto(
            id: $data['id'],
            cardId: $data['cardId'],
            customFieldGroupId: $data['customFieldGroupId'],
            customFieldId: $data['customFieldId'],
            content: $data['content'] ?? null,
            createdAt: $this->convertToDateTime($data['createdAt'] ?? null),
            updatedAt: $this->convertToDateTime($data['updatedAt'] ?? null),
        );
    }
}
