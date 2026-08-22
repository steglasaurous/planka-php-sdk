<?php

declare(strict_types=1);

namespace Planka\Bridge\Actions\Config;

use Planka\Bridge\Contracts\Actions\ResponseResultInterface;
use Planka\Bridge\Contracts\Actions\AuthenticateInterface;
use Planka\Bridge\Contracts\Actions\ActionInterface;
use Planka\Bridge\Traits\AuthenticateTrait;
use Planka\Bridge\Traits\ConfigHydrateTrait;

final class ConfigViewAction implements ActionInterface, AuthenticateInterface, ResponseResultInterface
{
    use AuthenticateTrait;
    use ConfigHydrateTrait;

    public function __construct(string $token)
    {
        $this->setToken($token);
    }

    public function url(): string
    {
        return 'api/config';
    }

    public function getOptions(): array
    {
        return [];
    }
}
