<?php

declare(strict_types=1);

namespace Planka\Bridge\Views\Factory\CustomField;

use Planka\Bridge\Views\Dto\CustomField\BaseCustomFieldGroupDto;
use Planka\Bridge\Contracts\Factory\OutputInterface;
use Planka\Bridge\Traits\DateConverterTrait;

final class BaseCustomFieldGroupDtoFactory implements OutputInterface
{
    use DateConverterTrait;

    public function create(array $data): BaseCustomFieldGroupDto
    {
        return new BaseCustomFieldGroupDto(
            id: $data['id'],
            projectId: $data['projectId'],
            name: $data['name'] ?? '',
            createdAt: $this->convertToDateTime($data['createdAt'] ?? null),
            updatedAt: $this->convertToDateTime($data['updatedAt'] ?? null),
        );
    }
}
