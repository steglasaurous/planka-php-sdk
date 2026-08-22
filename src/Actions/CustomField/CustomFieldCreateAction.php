<?php

declare(strict_types=1);

namespace Planka\Bridge\Actions\CustomField;

use Planka\Bridge\Contracts\Actions\ResponseResultInterface;
use Planka\Bridge\Contracts\Actions\AuthenticateInterface;
use Planka\Bridge\Contracts\Actions\ActionInterface;
use Planka\Bridge\Traits\CustomFieldHydrateTrait;
use Planka\Bridge\Traits\AuthenticateTrait;

final class CustomFieldCreateAction implements ActionInterface, AuthenticateInterface, ResponseResultInterface
{
    use AuthenticateTrait;
    use CustomFieldHydrateTrait;

    public function __construct(
        private readonly string $groupId,
        private readonly bool $inBaseGroup,
        private readonly int $position,
        private readonly string $name,
        string $token,
        private readonly ?bool $showOnFrontOfCard = null,
    ) {
        $this->setToken($token);
    }

    public function url(): string
    {
        return $this->inBaseGroup
            ? "api/base-custom-field-groups/{$this->groupId}/custom-fields"
            : "api/custom-field-groups/{$this->groupId}/custom-fields";
    }

    public function getOptions(): array
    {
        $json = [
            'position' => $this->position,
            'name' => $this->name,
        ];

        if (null !== $this->showOnFrontOfCard) {
            $json['showOnFrontOfCard'] = $this->showOnFrontOfCard;
        }

        return ['json' => $json];
    }
}
