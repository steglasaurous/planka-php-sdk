<?php

declare(strict_types=1);

namespace Planka\Bridge\Views\Dto\Attachment;

use Planka\Bridge\Views\Dto\Image\ImageDto;
use Planka\Bridge\Views\Dto\Attachment\AttachmentDataDto;

class AttachmentDto
{
    public function __construct(
        public readonly string $id,
        public readonly string $name,
        public readonly string $cardId,
        public readonly string $type,
        public readonly AttachmentDataDto $data,
        public readonly string $creatorUserId,
        public readonly \DateTimeImmutable $createdAt,
        public readonly ?\DateTimeImmutable $updatedAt = null,
    ) {}
}
