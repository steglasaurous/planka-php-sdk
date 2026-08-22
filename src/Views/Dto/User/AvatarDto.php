<?php

declare(strict_types=1);

namespace Planka\Bridge\Views\Dto\User;

use Planka\Bridge\Contracts\Dto\OutputDtoInterface;

class AvatarDto implements OutputDtoInterface
{
    /**
     * @param array<string, string> $thumbnailUrls
     */
    public function __construct(
        public readonly string $url,
        public readonly array $thumbnailUrls,
    ) {}
}
