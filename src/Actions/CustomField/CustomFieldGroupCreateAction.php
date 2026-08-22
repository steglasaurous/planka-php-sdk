<?php

declare(strict_types=1);

namespace Planka\Bridge\Actions\CustomField;

use Planka\Bridge\Contracts\Actions\ResponseResultInterface;
use Planka\Bridge\Contracts\Actions\AuthenticateInterface;
use Planka\Bridge\Traits\CustomFieldGroupHydrateTrait;
use Planka\Bridge\Contracts\Actions\ActionInterface;
use Planka\Bridge\Traits\AuthenticateTrait;

final class CustomFieldGroupCreateAction implements ActionInterface, AuthenticateInterface, ResponseResultInterface
{
    use AuthenticateTrait;
    use CustomFieldGroupHydrateTrait;

    public function __construct(
        private readonly string $parentId,
        private readonly bool $forCard,
        private readonly int $position,
        string $token,
        private readonly ?string $baseCustomFieldGroupId = null,
        private readonly ?string $name = null,
    ) {
        $this->setToken($token);
    }

    public function url(): string
    {
        return $this->forCard
            ? "api/cards/{$this->parentId}/custom-field-groups"
            : "api/boards/{$this->parentId}/custom-field-groups";
    }

    public function getOptions(): array
    {
        $json = ['position' => $this->position];

        if (null !== $this->baseCustomFieldGroupId) {
            $json['baseCustomFieldGroupId'] = $this->baseCustomFieldGroupId;
        }

        if (null !== $this->name) {
            $json['name'] = $this->name;
        }

        return ['json' => $json];
    }
}
