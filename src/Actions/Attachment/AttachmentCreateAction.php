<?php

declare(strict_types=1);

namespace Planka\Bridge\Actions\Attachment;

use Planka\Bridge\Contracts\Actions\ResponseResultInterface;
use Planka\Bridge\Contracts\Actions\AuthenticateInterface;
use Symfony\Component\Mime\Part\Multipart\FormDataPart;
use Planka\Bridge\Contracts\Actions\ActionInterface;
use Planka\Bridge\Exceptions\FileExistException;
use Planka\Bridge\Traits\AttachmentHydrateTrait;
use Planka\Bridge\Enum\AttachmentTypeEnum;
use Planka\Bridge\Traits\AuthenticateTrait;
use Symfony\Component\Mime\Part\DataPart;

final class AttachmentCreateAction implements ActionInterface, AuthenticateInterface, ResponseResultInterface
{
    use AuthenticateTrait;
    use AttachmentHydrateTrait;

    /**
     * @throws FileExistException
     */
    public function __construct(
        private readonly string $cardId,
        private readonly string $name,
        private readonly AttachmentTypeEnum $type,
        string $token,
        private readonly ?string $file = null,
        private readonly ?string $url = null,
    ) {
        $this->setToken($token);

        if (AttachmentTypeEnum::FILE === $this->type) {
            if (null === $this->file || !file_exists($this->file) || !is_readable($this->file)) {
                throw new FileExistException("File not exist {$this->file}");
            }
        }
    }

    public function url(): string
    {
        return "api/cards/{$this->cardId}/attachments";
    }

    public function getOptions(): array
    {
        $formFields = [
            'type' => $this->type->value,
            'name' => $this->name,
        ];

        if (null !== $this->file) {
            $formFields['file'] = DataPart::fromPath($this->file);
        }

        if (null !== $this->url) {
            $formFields['url'] = $this->url;
        }

        $formData = new FormDataPart($formFields);

        return [
            'headers' => $formData->getPreparedHeaders()->toArray(),
            'body' => $formData->bodyToIterable(),
        ];
    }
}
