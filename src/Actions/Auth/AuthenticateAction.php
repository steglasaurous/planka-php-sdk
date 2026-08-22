<?php

declare(strict_types=1);

namespace Planka\Bridge\Actions\Auth;

use Planka\Bridge\Contracts\Actions\ActionInterface;

final class AuthenticateAction implements ActionInterface
{
    public function __construct(
        private readonly string $username,
        private readonly string $password,
        private readonly bool $withHttpOnlyToken = false,
    ) {}

    public function url(): string
    {
        return 'api/access-tokens';
    }

    public function getOptions(): array
    {
        return [
            'json' => [
                'emailOrUsername' => $this->username,
                'password' => $this->password,
                'withHttpOnlyToken' => $this->withHttpOnlyToken,
            ],
        ];
    }
}
