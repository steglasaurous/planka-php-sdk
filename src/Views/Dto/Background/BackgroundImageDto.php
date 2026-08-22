<?php

declare(strict_types=1);

namespace Planka\Bridge\Views\Dto\Background;

use Planka\Bridge\Contracts\Dto\OutputDtoInterface;

class BackgroundImageDto implements OutputDtoInterface
{
    /**
     * @param array<string, string> $thumbnailUrls
     */
    public function __construct(
        public readonly string $id,
        public readonly string $projectId,
        public readonly string $size,
        public readonly string $url,
        public readonly array $thumbnailUrls,
        public readonly ?\DateTimeImmutable $createdAt,
        public readonly ?\DateTimeImmutable $updatedAt,
    ) {}
}
