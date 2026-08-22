<?php

declare(strict_types=1);

namespace Planka\Bridge\Controllers;

use Planka\Bridge\Actions\Config\ConfigTestSmtpAction;
use Planka\Bridge\Actions\Config\ConfigUpdateAction;
use Planka\Bridge\Actions\Config\ConfigViewAction;
use Planka\Bridge\Views\Dto\Config\ConfigDto;
use Planka\Bridge\TransportClients\Client;
use Planka\Bridge\Config;

final class AppConfig
{
    public function __construct(
        private readonly Config $config,
        private readonly Client $client,
    ) {}

    /** 'GET /api/config' */
    public function get(): ConfigDto
    {
        return $this->client->get(new ConfigViewAction(token: $this->config->getAuthToken()));
    }

    /** 'PATCH /api/config' */
    public function update(ConfigDto $configDto): ConfigDto
    {
        return $this->client->patch(new ConfigUpdateAction(
            configDto: $configDto,
            token: $this->config->getAuthToken(),
        ));
    }

    /** 'POST /api/config/test-smtp' */
    public function testSmtp(): ConfigDto
    {
        return $this->client->post(new ConfigTestSmtpAction(token: $this->config->getAuthToken()));
    }
}
