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

    /**
     * @param array{
     *     id: string,
     *     createdAt: string,
     *     updatedAt: ?string,
     *     name: string,
     *     cardId: string,
     *     url: string,
     *     coverUrl: ?string,
     *     creatorUserId: string,
     *     image: array{height: int, width: int}
     * }|null $data
     */
    public function create(?array $data): ?AttachmentDto
    {
        if (empty($data)) {
            return null;
        }

        return new AttachmentDto(
            id: $data['id'],
            createdAt: $this->convertToDateTime($data['createdAt']),
            updatedAt: $this->convertToDateTime($data['updatedAt']),
            type: $data['type'],
            data: (new AttachmentDataDto(
                encoding: $data['data']['encoding'] ?? '',
                mimeType: $data['data']['mimeType'] ?? '',
                sizeInBytes: $data['data']['sizeInBytes'],
                url: $data['data']['url'],
                thumbnailUrls: $data['data']['thumbnailUrls'] ?? [],
                image: (new ImageDtoFactory())->create($data['data']['image'] ?? null),
            )),       
            name: $data['name'],
            cardId: $data['cardId'],     
            creatorUserId: $data['creatorUserId'],
        );
    }
}
