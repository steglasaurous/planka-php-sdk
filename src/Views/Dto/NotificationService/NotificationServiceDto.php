<?php

declare(strict_types=1);

namespace Planka\Bridge\Views\Dto\NotificationService;

use Planka\Bridge\Enum\NotificationServiceFormatEnum;
use Planka\Bridge\Contracts\Dto\OutputDtoInterface;

class NotificationServiceDto implements OutputDtoInterface
{
    public function __construct(
        public readonly string $id,
        public readonly ?string $userId,
        public readonly ?string $boardId,
        public string $url,
        public NotificationServiceFormatEnum $format,
        public readonly ?\DateTimeImmutable $createdAt,
        public readonly ?\DateTimeImmutable $updatedAt,
    ) {}
}
