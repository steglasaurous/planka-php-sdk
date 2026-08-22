<?php

declare(strict_types=1);

namespace Planka\Bridge\Views\Dto\Card;

use Planka\Bridge\Enum\ActionTypeEnum;

class CardActionItemDto
{
    public function __construct(
        public readonly string $id,
        public readonly ?\DateTimeImmutable $createdAt,
        public readonly ?\DateTimeImmutable $updatedAt,
        public readonly ?ActionTypeEnum $type,
        public readonly array $data,
        public readonly string $cardId,
        public readonly ?string $boardId,
        public readonly ?string $userId,
    ) {}
}
