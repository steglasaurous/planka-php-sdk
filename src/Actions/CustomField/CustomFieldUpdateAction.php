<?php

declare(strict_types=1);

namespace Planka\Bridge\Actions\CustomField;

use Planka\Bridge\Contracts\Actions\ResponseResultInterface;
use Planka\Bridge\Contracts\Actions\AuthenticateInterface;
use Planka\Bridge\Contracts\Actions\ActionInterface;
use Planka\Bridge\Traits\CustomFieldHydrateTrait;
use Planka\Bridge\Traits\AuthenticateTrait;

final class CustomFieldUpdateAction implements ActionInterface, AuthenticateInterface, ResponseResultInterface
{
    use AuthenticateTrait;
    use CustomFieldHydrateTrait;

    public function __construct(
        private readonly string $id,
        string $token,
        private readonly ?int $position = null,
        private readonly ?string $name = null,
        private readonly ?bool $showOnFrontOfCard = null,
    ) {
        $this->setToken($token);
    }

    public function url(): string
    {
        return "api/custom-fields/{$this->id}";
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

        if (null !== $this->showOnFrontOfCard) {
            $json['showOnFrontOfCard'] = $this->showOnFrontOfCard;
        }

        return ['json' => $json];
    }
}
