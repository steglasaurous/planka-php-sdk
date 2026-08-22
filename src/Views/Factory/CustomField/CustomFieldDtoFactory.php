<?php

declare(strict_types=1);

namespace Planka\Bridge\Views\Factory\CustomField;

use Planka\Bridge\Views\Dto\CustomField\CustomFieldDto;
use Planka\Bridge\Contracts\Factory\OutputInterface;
use Planka\Bridge\Traits\DateConverterTrait;

final class CustomFieldDtoFactory implements OutputInterface
{
    use DateConverterTrait;

    public function create(array $data): CustomFieldDto
    {
        return new CustomFieldDto(
            id: $data['id'],
            baseCustomFieldGroupId: $data['baseCustomFieldGroupId'] ?? null,
            customFieldGroupId: $data['customFieldGroupId'] ?? null,
            createdAt: $this->convertToDateTime($data['createdAt'] ?? null),
            updatedAt: $this->convertToDateTime($data['updatedAt'] ?? null),
            position: (int) ($data['position'] ?? 0),
            name: $data['name'] ?? '',
            showOnFrontOfCard: (bool) ($data['showOnFrontOfCard'] ?? false),
        );
    }
}
