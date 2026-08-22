<?php

declare(strict_types=1);

namespace Planka\Bridge\Views\Factory\Attachment;

use Planka\Bridge\Views\Factory\Image\ImageDtoFactory;
use Planka\Bridge\Views\Dto\Attachment\AttachmentDto;
use Planka\Bridge\Contracts\Factory\OutputInterface;
use Planka\Bridge\Traits\DateConverterTrait;
use Planka\Bridge\Views\Dto\Attachment\AttachmentDataDto;

final class AttachmentDtoFactory implements OutputInterface
{
    use DateConverterTrait;

    public function create(?array $data): ?AttachmentDto
    {
        if (empty($data) || empty($data['id'])) {
            return null;
        }

        $payload = $data['data'] ?? [];

        return new AttachmentDto(
            id: $data['id'],
            createdAt: $this->convertToDateTime($data['createdAt'] ?? null),
            updatedAt: $this->convertToDateTime($data['updatedAt'] ?? null),
            type: $data['type'] ?? 'file',
            data: new AttachmentDataDto(
                encoding: $payload['encoding'] ?? '',
                mimeType: $payload['mimeType'] ?? '',
                sizeInBytes: (int) ($payload['sizeInBytes'] ?? $payload['size'] ?? 0),
                url: $payload['url'] ?? ($data['url'] ?? ''),
                thumbnailUrls: $payload['thumbnailUrls'] ?? [],
                image: (new ImageDtoFactory())->create($payload['image'] ?? null),
            ),
            name: $data['name'] ?? '',
            cardId: $data['cardId'] ?? '',
            creatorUserId: $data['creatorUserId'] ?? null,
        );
    }
}
