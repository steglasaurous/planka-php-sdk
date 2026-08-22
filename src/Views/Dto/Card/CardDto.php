<?php

declare(strict_types=1);

namespace Planka\Bridge\Views\Dto\Card;

use Planka\Bridge\Contracts\Dto\OutputDtoInterface;
use Planka\Bridge\Enum\CardTypeEnum;

class CardDto implements OutputDtoInterface
{
    public function __construct(
        public readonly string $id,
        public readonly ?\DateTimeImmutable $createdAt,
        public readonly ?\DateTimeImmutable $updatedAt,
        public CardTypeEnum $type,
        public int $position,
        public string $name,
        public ?string $description,
        public ?\DateTimeImmutable $dueDate,
        public ?bool $isDueCompleted,
        public ?StopWatchDto $stopwatch,
        public int $commentsTotal,
        public bool $isClosed,
        public readonly ?\DateTimeImmutable $listChangedAt,
        public string $boardId,
        public string $listId,
        public ?string $creatorUserId,
        public ?string $prevListId,
        public ?string $coverAttachmentId,
        public bool $isSubscribed,
        public readonly CardIncludedDto $included,
    ) {}
}
