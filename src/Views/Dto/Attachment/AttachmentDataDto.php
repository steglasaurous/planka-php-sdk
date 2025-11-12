<?php

declare(strict_types=1);

namespace Planka\Bridge\Views\Dto\Attachment;

use Planka\Bridge\Views\Dto\Image\ImageDto;

class AttachmentDataDto
{
    public function __construct(        
        public readonly string $encoding,
        public readonly string $mimeType,
        public readonly int $sizeInBytes,
        public readonly string $url,
        public readonly array $thumbnailUrls,
        public readonly ?ImageDto $image = null,
    ) {}
}
