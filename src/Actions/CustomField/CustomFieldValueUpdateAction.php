<?php

declare(strict_types=1);

namespace Planka\Bridge\Actions\CustomField;

use Planka\Bridge\Contracts\Actions\ResponseResultInterface;
use Planka\Bridge\Contracts\Actions\AuthenticateInterface;
use Planka\Bridge\Traits\CustomFieldValueHydrateTrait;
use Planka\Bridge\Contracts\Actions\ActionInterface;
use Planka\Bridge\Traits\AuthenticateTrait;

final class CustomFieldValueUpdateAction implements ActionInterface, AuthenticateInterface, ResponseResultInterface
{
    use AuthenticateTrait;
    use CustomFieldValueHydrateTrait;

    public function __construct(
        private readonly string $cardId,
        private readonly string $customFieldGroupId,
        private readonly string $customFieldId,
        private readonly mixed $content,
        string $token,
    ) {
        $this->setToken($token);
    }

    public function url(): string
    {
        return "api/cards/{$this->cardId}/custom-field-values/customFieldGroupId:{$this->customFieldGroupId}:customFieldId:{$this->customFieldId}";
    }

    public function getOptions(): array
    {
        return ['json' => ['content' => $this->content]];
    }
}
