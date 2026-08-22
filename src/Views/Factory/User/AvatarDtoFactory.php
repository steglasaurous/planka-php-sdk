<?php

declare(strict_types=1);

namespace Planka\Bridge\Views\Factory\User;

use Planka\Bridge\Contracts\Factory\OutputInterface;
use Planka\Bridge\Views\Dto\User\AvatarDto;

final class AvatarDtoFactory implements OutputInterface
{
    /**
     * @param array{url?: string, thumbnailUrls?: array<string, string>}|null $data
     */
    public function create(?array $data): ?AvatarDto
    {
        if (empty($data) || empty($data['url'])) {
            return null;
        }

        return new AvatarDto(
            url: $data['url'],
            thumbnailUrls: $data['thumbnailUrls'] ?? [],
        );
    }
}
