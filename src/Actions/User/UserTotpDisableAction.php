<?php

declare(strict_types=1);

namespace Planka\Bridge\Actions\User;

use Planka\Bridge\Contracts\Actions\ResponseResultInterface;
use Planka\Bridge\Contracts\Actions\AuthenticateInterface;
use Planka\Bridge\Contracts\Actions\ActionInterface;
use Planka\Bridge\Traits\AuthenticateTrait;
use Planka\Bridge\Traits\UserHydrateTrait;

final class UserTotpDisableAction implements ActionInterface, AuthenticateInterface, ResponseResultInterface
{
    use AuthenticateTrait;
    use UserHydrateTrait;

    public function __construct(
        private readonly string $userId,
        string $token,
        private readonly ?string $currentPassword = null,
        private readonly ?string $code = null,
    ) {
        $this->setToken($token);
    }

    public function url(): string
    {
        return "api/users/{$this->userId}/totp";
    }

    public function getOptions(): array
    {
        $json = [];

        if (null !== $this->currentPassword) {
            $json['currentPassword'] = $this->currentPassword;
        }

        if (null !== $this->code) {
            $json['code'] = $this->code;
        }

        return ['json' => $json];
    }
}
