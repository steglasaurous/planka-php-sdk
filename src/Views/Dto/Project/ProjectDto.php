<?php

declare(strict_types=1);

namespace Planka\Bridge\Views\Dto\Project;

use Planka\Bridge\Enum\BackgroundGradientEnum;
use Planka\Bridge\Contracts\Dto\OutputDtoInterface;
use Planka\Bridge\Enum\BackgroundTypeEnum;

class ProjectDto implements OutputDtoInterface
{
    public function __construct(
        public readonly string $id,
        public readonly ?\DateTimeImmutable $createdAt,
        public readonly ?\DateTimeImmutable $updatedAt,
        public string $name,
        public ?string $description,
        public ?string $ownerProjectManagerId,
        public ?string $backgroundImageId,
        public ?BackgroundTypeEnum $backgroundType,
        public ?BackgroundGradientEnum $backgroundGradient,
        public bool $isHidden,
        public bool $isFavorite = false,
        public readonly array $_rawResponse = [],
    ) {}
}
