<?php

declare(strict_types=1);

namespace Planka\Bridge\Views\Dto\CustomField;

use Planka\Bridge\Contracts\Dto\OutputDtoInterface;

class CustomFieldGroupDto implements OutputDtoInterface
{
    public function __construct(
        public readonly string $id,
        public readonly ?string $boardId,
        public readonly ?string $cardId,
        public readonly ?string $baseCustomFieldGroupId,
        public readonly ?\DateTimeImmutable $createdAt,
        public readonly ?\DateTimeImmutable $updatedAt,
        public int $position,
        public ?string $name,
    ) {}
}
