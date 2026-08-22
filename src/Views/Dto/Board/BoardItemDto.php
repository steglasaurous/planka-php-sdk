<?php

declare(strict_types=1);

namespace Planka\Bridge\Views\Dto\Board;

use Planka\Bridge\Contracts\Dto\OutputDtoInterface;
use Planka\Bridge\Enum\BoardViewEnum;
use Planka\Bridge\Enum\CardTypeEnum;

final class BoardItemDto implements OutputDtoInterface
{
    public function __construct(
        public readonly ?string $id,
        public readonly ?string $projectId,
        public readonly ?int $position,
        public readonly ?string $name,
        public readonly ?BoardViewEnum $defaultView,
        public readonly ?CardTypeEnum $defaultCardType,
        public readonly bool $limitCardTypesToDefaultOne,
        public readonly bool $alwaysDisplayCardCreator,
        public readonly bool $displayCardAges,
        public readonly bool $expandTaskListsByDefault,
        public readonly ?\DateTimeImmutable $createdAt,
        public readonly ?\DateTimeImmutable $updatedAt = null,
    ) {}
}
