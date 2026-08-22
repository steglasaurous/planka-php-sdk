<?php

declare(strict_types=1);

namespace Planka\Bridge\Actions\Common;

use Planka\Bridge\Contracts\Actions\ResponseResultInterface;
use Planka\Bridge\Contracts\Actions\ActionInterface;
use Planka\Bridge\Views\Dto\Common\BootstrapDto;
use Symfony\Contracts\HttpClient\ResponseInterface;

final class GetInfoAction implements ActionInterface, ResponseResultInterface
{
    public function url(): string
    {
        return 'api/bootstrap';
    }

    public function getOptions(): array
    {
        return [];
    }

    public function hydrate(ResponseInterface $response): BootstrapDto
    {
        $data = $response->toArray();

        return new BootstrapDto(
            version: $data['version'] ?? '',
            activeUsersLimit: isset($data['activeUsersLimit']) ? (int) $data['activeUsersLimit'] : null,
            customerPanelUrl: $data['customerPanelUrl'] ?? null,
            termsLanguages: $data['termsLanguages'] ?? null,
        );
    }
}
