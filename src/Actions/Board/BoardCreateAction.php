<?php

declare(strict_types=1);

namespace Planka\Bridge\Actions\Board;

use Planka\Bridge\Contracts\Actions\ResponseResultInterface;
use Planka\Bridge\Contracts\Actions\AuthenticateInterface;
use Symfony\Component\Mime\Part\Multipart\FormDataPart;
use Planka\Bridge\Contracts\Actions\ActionInterface;
use Planka\Bridge\Exceptions\FileExistException;
use Planka\Bridge\Traits\AuthenticateTrait;
use Planka\Bridge\Traits\BoardHydrateTrait;
use Symfony\Component\Mime\Part\DataPart;

final class BoardCreateAction implements ActionInterface, AuthenticateInterface, ResponseResultInterface
{
    use AuthenticateTrait;
    use BoardHydrateTrait;

    /**
     * @throws FileExistException
     */
    public function __construct(
        private readonly string $projectId,
        private readonly string $name,
        private readonly int $position,
        string $token,
        private readonly ?string $importType = null,
        private readonly ?string $importFile = null,
    ) {
        $this->setToken($token);

        if (null !== $this->importFile && (!file_exists($this->importFile) || !is_readable($this->importFile))) {
            throw new FileExistException("File not exist {$this->importFile}");
        }
    }

    public function url(): string
    {
        return "api/projects/{$this->projectId}/boards";
    }

    public function getOptions(): array
    {
        $formFields = [
            'name' => $this->name,
            'position' => (string) $this->position,
        ];

        if (null !== $this->importType) {
            $formFields['importType'] = $this->importType;
        }

        if (null !== $this->importFile) {
            $formFields['importFile'] = DataPart::fromPath($this->importFile);
        }

        $formData = new FormDataPart($formFields);

        return [
            'headers' => $formData->getPreparedHeaders()->toArray(),
            'body' => $formData->bodyToIterable(),
        ];
    }
}
