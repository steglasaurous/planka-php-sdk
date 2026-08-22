<?php

declare(strict_types=1);

namespace Planka\Bridge\Actions\Project;

use Planka\Bridge\Contracts\Actions\ResponseResultInterface;
use Planka\Bridge\Contracts\Actions\AuthenticateInterface;
use Planka\Bridge\Contracts\Actions\ActionInterface;
use Planka\Bridge\Traits\ProjectHydrateTrait;
use Planka\Bridge\Traits\AuthenticateTrait;
use Planka\Bridge\Enum\ProjectTypeEnum;

final class ProjectCreateAction implements ActionInterface, AuthenticateInterface, ResponseResultInterface
{
    use AuthenticateTrait;
    use ProjectHydrateTrait;

    public function __construct(
        private readonly string $name,
        private readonly ProjectTypeEnum $type,
        string $token,
        private readonly ?string $description = null,
    ) {
        $this->setToken($token);
    }

    public function url(): string
    {
        return 'api/projects';
    }

    public function getOptions(): array
    {
        $json = [
            'name' => $this->name,
            'type' => $this->type->value,
        ];

        if (null !== $this->description) {
            $json['description'] = $this->description;
        }

        return [
            'json' => $json,
        ];
    }
}
