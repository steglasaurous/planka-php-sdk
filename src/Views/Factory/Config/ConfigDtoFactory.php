<?php

declare(strict_types=1);

namespace Planka\Bridge\Views\Factory\Config;

use Planka\Bridge\Contracts\Factory\OutputInterface;
use Planka\Bridge\Views\Dto\Config\ConfigDto;
use Planka\Bridge\Traits\DateConverterTrait;

final class ConfigDtoFactory implements OutputInterface
{
    use DateConverterTrait;

    public function create(array $data): ConfigDto
    {
        return new ConfigDto(
            id: $data['id'] ?? '1',
            smtpHost: $data['smtpHost'] ?? null,
            smtpPort: isset($data['smtpPort']) ? (int) $data['smtpPort'] : null,
            smtpName: $data['smtpName'] ?? null,
            smtpSecure: isset($data['smtpSecure']) ? (bool) $data['smtpSecure'] : null,
            smtpTlsRejectUnauthorized: isset($data['smtpTlsRejectUnauthorized'])
                ? (bool) $data['smtpTlsRejectUnauthorized']
                : null,
            smtpUser: $data['smtpUser'] ?? null,
            smtpPassword: $data['smtpPassword'] ?? null,
            smtpFrom: $data['smtpFrom'] ?? null,
            createdAt: $this->convertToDateTime($data['createdAt'] ?? null),
            updatedAt: $this->convertToDateTime($data['updatedAt'] ?? null),
        );
    }
}
