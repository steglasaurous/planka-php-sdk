<?php

declare(strict_types=1);

namespace Planka\Bridge\Views\Factory\Project;

use Planka\Bridge\Enum\BackgroundGradientEnum;
use Planka\Bridge\Contracts\Factory\OutputInterface;
use Planka\Bridge\Views\Dto\Project\ProjectDto;
use Planka\Bridge\Enum\BackgroundTypeEnum;
use Planka\Bridge\Traits\DateConverterTrait;

final class ProjectDtoFactory implements OutputInterface
{
    use DateConverterTrait;

    public function create(array $data): ProjectDto
    {
        return new ProjectDto(
            id: $data['id'],
            createdAt: $this->convertToDateTime($data['createdAt'] ?? null),
            updatedAt: $this->convertToDateTime($data['updatedAt'] ?? null),
            name: $data['name'],
            description: $data['description'] ?? null,
            ownerProjectManagerId: $data['ownerProjectManagerId'] ?? null,
            backgroundImageId: $data['backgroundImageId'] ?? null,
            backgroundType: BackgroundTypeEnum::tryFrom($data['backgroundType'] ?? ''),
            backgroundGradient: BackgroundGradientEnum::tryFrom($data['backgroundGradient'] ?? ''),
            isHidden: (bool) ($data['isHidden'] ?? false),
            isFavorite: (bool) ($data['isFavorite'] ?? false),
            _rawResponse: $data,
        );
    }
}
