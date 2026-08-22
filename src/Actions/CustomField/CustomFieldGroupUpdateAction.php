<?php

declare(strict_types=1);

namespace Planka\Bridge\Actions\CustomField;

use Planka\Bridge\Contracts\Actions\ResponseResultInterface;
use Planka\Bridge\Contracts\Actions\AuthenticateInterface;
use Planka\Bridge\Traits\CustomFieldGroupHydrateTrait;
use Planka\Bridge\Contracts\Actions\ActionInterface;
use Planka\Bridge\Traits\AuthenticateTrait;

final class CustomFieldGroupUpdateAction implements ActionInterface, AuthenticateInterface, ResponseResultInterface
{
    use AuthenticateTrait;
    use CustomFieldGroupHydrateTrait;

    public function __construct(
        private readonly string $id,
        string $token,
        private readonly ?int $position = null,
        private readonly ?string $name = null,
    ) {
        $this->setToken($token);
    }

    public function url(): string
    {
        return "api/custom-field-groups/{$this->id}";
    }

    public function getOptions(): array
    {
        $json = [];

        if (null !== $this->position) {
            $json['position'] = $this->position;
        }

        if (null !== $this->name) {
            $json['name'] = $this->name;
        }

        return ['json' => $json];
    }
}
