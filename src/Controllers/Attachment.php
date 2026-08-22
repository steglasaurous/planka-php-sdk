<?php

declare(strict_types=1);

namespace Planka\Bridge\Controllers;

use Planka\Bridge\Actions\Attachment\AttachmentCreateAction;
use Planka\Bridge\Actions\Attachment\AttachmentDeleteAction;
use Planka\Bridge\Actions\Attachment\AttachmentUpdateAction;
use Planka\Bridge\Views\Dto\Attachment\AttachmentDto;
use Planka\Bridge\Exceptions\FileExistException;
use Planka\Bridge\Enum\AttachmentTypeEnum;
use Planka\Bridge\TransportClients\Client;
use Planka\Bridge\Config;

final class Attachment
{
    public function __construct(
        private readonly Config $config,
        private readonly Client $client,
    ) {}

    /**
     * 'POST /api/cards/:cardId/attachments'.
     *
     * @throws FileExistException
     */
    public function upload(
        string $cardId,
        string $name,
        string $file,
        AttachmentTypeEnum $type = AttachmentTypeEnum::FILE,
    ): AttachmentDto {
        return $this->client->post(new AttachmentCreateAction(
            cardId: $cardId,
            name: $name,
            type: $type,
            token: $this->config->getAuthToken(),
            file: $file,
        ));
    }

    /** 'POST /api/cards/:cardId/attachments' as a link */
    public function addLink(string $cardId, string $name, string $url): AttachmentDto
    {
        return $this->client->post(new AttachmentCreateAction(
            cardId: $cardId,
            name: $name,
            type: AttachmentTypeEnum::LINK,
            token: $this->config->getAuthToken(),
            url: $url,
        ));
    }

    /** 'PATCH /api/attachments/:id' */
    public function updateName(string $attachmentId, string $name): AttachmentDto
    {
        return $this->client->patch(new AttachmentUpdateAction(
            attachmentId: $attachmentId,
            name: $name,
            token: $this->config->getAuthToken(),
        ));
    }

    /** 'DELETE /api/attachments/:id' */
    public function delete(string $attachmentId): AttachmentDto
    {
        return $this->client->delete(new AttachmentDeleteAction(
            attachmentId: $attachmentId,
            token: $this->config->getAuthToken(),
        ));
    }
}
