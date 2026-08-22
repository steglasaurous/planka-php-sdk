<?php

declare(strict_types=1);

namespace Planka\Bridge\Actions\CustomField;

use Planka\Bridge\Contracts\Actions\ResponseResultInterface;
use Planka\Bridge\Contracts\Actions\AuthenticateInterface;
use Planka\Bridge\Contracts\Actions\ActionInterface;
use Planka\Bridge\Traits\CustomFieldHydrateTrait;
use Planka\Bridge\Traits\AuthenticateTrait;

final class CustomFieldDeleteAction implements ActionInterface, AuthenticateInterface, ResponseResultInterface
{
    use AuthenticateTrait;
    use CustomFieldHydrateTrait;

    public function __construct(private readonly string $id, string $token)
    {
        $this->setToken($token);
    }

    public function url(): string
    {
        return "api/custom-fields/{$this->id}";
    }

    public function getOptions(): array
    {
        return [];
    }
}
