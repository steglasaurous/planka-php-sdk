<?php

declare(strict_types=1);

namespace Planka\Bridge\Actions\CustomField;

use Planka\Bridge\Contracts\Actions\ResponseResultInterface;
use Planka\Bridge\Contracts\Actions\AuthenticateInterface;
use Planka\Bridge\Traits\BaseCustomFieldGroupHydrateTrait;
use Planka\Bridge\Contracts\Actions\ActionInterface;
use Planka\Bridge\Traits\AuthenticateTrait;

final class BaseCustomFieldGroupCreateAction implements ActionInterface, AuthenticateInterface, ResponseResultInterface
{
    use AuthenticateTrait;
    use BaseCustomFieldGroupHydrateTrait;

    public function __construct(
        private readonly string $projectId,
        private readonly string $name,
        string $token,
    ) {
        $this->setToken($token);
    }

    public function url(): string
    {
        return "api/projects/{$this->projectId}/base-custom-field-groups";
    }

    public function getOptions(): array
    {
        return ['json' => ['name' => $this->name]];
    }
}
