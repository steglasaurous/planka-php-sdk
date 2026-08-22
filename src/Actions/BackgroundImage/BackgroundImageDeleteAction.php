<?php

declare(strict_types=1);

namespace Planka\Bridge\Actions\BackgroundImage;

use Planka\Bridge\Contracts\Actions\ResponseResultInterface;
use Planka\Bridge\Contracts\Actions\AuthenticateInterface;
use Planka\Bridge\Traits\BackgroundImageHydrateTrait;
use Planka\Bridge\Contracts\Actions\ActionInterface;
use Planka\Bridge\Traits\AuthenticateTrait;

final class BackgroundImageDeleteAction implements ActionInterface, AuthenticateInterface, ResponseResultInterface
{
    use AuthenticateTrait;
    use BackgroundImageHydrateTrait;

    public function __construct(private readonly string $id, string $token)
    {
        $this->setToken($token);
    }

    public function url(): string
    {
        return "api/background-images/{$this->id}";
    }

    public function getOptions(): array
    {
        return [];
    }
}
