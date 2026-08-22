<?php

declare(strict_types=1);

namespace Planka\Bridge\Controllers;

use Planka\Bridge\Actions\Project\ProjectUpdateBackgroundImageAction;
use Planka\Bridge\Actions\BackgroundImage\BackgroundImageDeleteAction;
use Planka\Bridge\Views\Dto\Background\BackgroundImageDto;
use Planka\Bridge\Exceptions\FileExistException;
use Planka\Bridge\TransportClients\Client;
use Planka\Bridge\Config;

final class BackgroundImage
{
    public function __construct(
        private readonly Config $config,
        private readonly Client $client,
    ) {}

    /**
     * 'POST /api/projects/:projectId/background-images'.
     *
     * @throws FileExistException
     */
    public function create(string $projectId, string $file): BackgroundImageDto
    {
        return $this->client->post(new ProjectUpdateBackgroundImageAction(
            projectId: $projectId,
            file: $file,
            token: $this->config->getAuthToken(),
        ));
    }

    /** 'DELETE /api/background-images/:id' */
    public function delete(string $id): BackgroundImageDto
    {
        return $this->client->delete(new BackgroundImageDeleteAction(
            id: $id,
            token: $this->config->getAuthToken(),
        ));
    }
}
