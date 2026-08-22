<?php

declare(strict_types=1);

namespace Planka\Bridge\Actions\Config;

use Planka\Bridge\Contracts\Actions\ResponseResultInterface;
use Planka\Bridge\Contracts\Actions\AuthenticateInterface;
use Planka\Bridge\Contracts\Actions\ActionInterface;
use Planka\Bridge\Views\Dto\Config\ConfigDto;
use Planka\Bridge\Traits\AuthenticateTrait;
use Planka\Bridge\Traits\ConfigHydrateTrait;

final class ConfigUpdateAction implements ActionInterface, AuthenticateInterface, ResponseResultInterface
{
    use AuthenticateTrait;
    use ConfigHydrateTrait;

    public function __construct(private readonly ConfigDto $configDto, string $token)
    {
        $this->setToken($token);
    }

    public function url(): string
    {
        return 'api/config';
    }

    public function getOptions(): array
    {
        return [
            'json' => [
                'smtpHost' => $this->configDto->smtpHost,
                'smtpPort' => $this->configDto->smtpPort,
                'smtpName' => $this->configDto->smtpName,
                'smtpSecure' => $this->configDto->smtpSecure,
                'smtpTlsRejectUnauthorized' => $this->configDto->smtpTlsRejectUnauthorized,
                'smtpUser' => $this->configDto->smtpUser,
                'smtpPassword' => $this->configDto->smtpPassword,
                'smtpFrom' => $this->configDto->smtpFrom,
            ],
        ];
    }
}
