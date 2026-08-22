<?php

declare(strict_types=1);

namespace Planka\Bridge\Actions\User;

use Planka\Bridge\Contracts\Actions\ResponseResultInterface;
use Planka\Bridge\Contracts\Actions\AuthenticateInterface;
use Planka\Bridge\Contracts\Actions\ActionInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;
use Planka\Bridge\Traits\AuthenticateTrait;

final class UserTrustedDeviceDeleteAction implements ActionInterface, AuthenticateInterface, ResponseResultInterface
{
    use AuthenticateTrait;

    public function __construct(
        private readonly string $userId,
        private readonly string $deviceId,
        string $token,
    ) {
        $this->setToken($token);
    }

    public function url(): string
    {
        return "api/users/{$this->userId}/trusted-devices/{$this->deviceId}";
    }

    public function getOptions(): array
    {
        return [];
    }

    public function hydrate(ResponseInterface $response): array
    {
        return $response->toArray(false);
    }
}
