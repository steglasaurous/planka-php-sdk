<?php

declare(strict_types=1);

namespace Planka\Bridge\Views\Factory\Notification;

use Planka\Bridge\Views\Dto\Notification\NotificationItemDto;
use Planka\Bridge\Contracts\Factory\OutputInterface;
use Planka\Bridge\Enum\NotificationTypeEnum;
use Planka\Bridge\Traits\DateConverterTrait;

final class NotificationItemDtoFactory implements OutputInterface
{
    use DateConverterTrait;

    public function create(array $data): NotificationItemDto
    {
        return new NotificationItemDto(
            id: $data['id'],
            createdAt: $this->convertToDateTime($data['createdAt'] ?? null),
            updatedAt: $this->convertToDateTime($data['updatedAt'] ?? null),
            isRead: (bool) ($data['isRead'] ?? false),
            userId: $data['userId'],
            creatorUserId: $data['creatorUserId'] ?? null,
            boardId: $data['boardId'] ?? null,
            cardId: $data['cardId'] ?? null,
            commentId: $data['commentId'] ?? null,
            actionId: $data['actionId'] ?? null,
            type: NotificationTypeEnum::tryFrom($data['type'] ?? ''),
            data: $data['data'] ?? [],
        );
    }
}
