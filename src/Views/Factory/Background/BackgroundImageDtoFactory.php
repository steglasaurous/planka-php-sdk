<?php

declare(strict_types=1);

namespace Planka\Bridge\Views\Factory\Background;

use Planka\Bridge\Views\Dto\Background\BackgroundImageDto;
use Planka\Bridge\Contracts\Factory\OutputInterface;
use Planka\Bridge\Traits\DateConverterTrait;

final class BackgroundImageDtoFactory implements OutputInterface
{
    use DateConverterTrait;

    public function create(?array $data): ?BackgroundImageDto
    {
        if (empty($data) || empty($data['id'])) {
            return null;
        }

        return new BackgroundImageDto(
            id: $data['id'],
            projectId: $data['projectId'] ?? '',
            size: (string) ($data['size'] ?? ''),
            url: $data['url'] ?? '',
            thumbnailUrls: $data['thumbnailUrls'] ?? [],
            createdAt: $this->convertToDateTime($data['createdAt'] ?? null),
            updatedAt: $this->convertToDateTime($data['updatedAt'] ?? null),
        );
    }
}
