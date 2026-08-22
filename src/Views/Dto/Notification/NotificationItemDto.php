<?php

declare(strict_types=1);

namespace Planka\Bridge\Views\Dto\Notification;

use Planka\Bridge\Enum\NotificationTypeEnum;

class NotificationItemDto
{
    public function __construct(
        public readonly string $id,
        public readonly ?\DateTimeImmutable $createdAt,
        public readonly ?\DateTimeImmutable $updatedAt,
        public readonly bool $isRead,
        public readonly string $userId,
        public readonly ?string $creatorUserId,
        public readonly ?string $boardId,
        public readonly ?string $cardId,
        public readonly ?string $commentId,
        public readonly ?string $actionId,
        public readonly ?NotificationTypeEnum $type,
        public readonly array $data,
    ) {}
}
