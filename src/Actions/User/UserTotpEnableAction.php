<?php

declare(strict_types=1);

namespace Planka\Bridge\Actions\User;

use Planka\Bridge\Contracts\Actions\ResponseResultInterface;
use Planka\Bridge\Contracts\Actions\AuthenticateInterface;
use Planka\Bridge\Contracts\Actions\ActionInterface;
use Planka\Bridge\Traits\AuthenticateTrait;
use Planka\Bridge\Traits\UserHydrateTrait;

final class UserTotpEnableAction implements ActionInterface, AuthenticateInterface, ResponseResultInterface
{
    use AuthenticateTrait;
    use UserHydrateTrait;

    public function __construct(
        private readonly string $userId,
        private readonly string $currentPassword,
        private readonly string $code,
        string $token,
    ) {
        $this->setToken($token);
    }

    public function url(): string
    {
        return "api/users/{$this->userId}/totp/enable";
    }

    public function getOptions(): array
    {
        return [
            'json' => [
                'currentPassword' => $this->currentPassword,
                'code' => $this->code,
            ],
        ];
    }
}
