<?php

declare(strict_types=1);

namespace Planka\Bridge\Actions\Project;

use Planka\Bridge\Contracts\Actions\ResponseResultInterface;
use Planka\Bridge\Contracts\Actions\AuthenticateInterface;
use Planka\Bridge\Contracts\Actions\ActionInterface;
use Planka\Bridge\Views\Dto\Project\ProjectDto;
use Planka\Bridge\Traits\ProjectHydrateTrait;
use Planka\Bridge\Traits\AuthenticateTrait;

final class ProjectUpdateAction implements ActionInterface, AuthenticateInterface, ResponseResultInterface
{
    use AuthenticateTrait;
    use ProjectHydrateTrait;

    public function __construct(private readonly ProjectDto $project, string $token)
    {
        $this->setToken($token);
    }

    public function url(): string
    {
        return "api/projects/{$this->project->id}";
    }

    public function getOptions(): array
    {
        return [
            'json' => [
                'name' => $this->project->name,
                'description' => $this->project->description,
                'backgroundType' => $this->project->backgroundType?->value,
                'backgroundGradient' => $this->project->backgroundGradient?->value,
                'backgroundImageId' => $this->project->backgroundImageId,
                'isHidden' => $this->project->isHidden,
                'isFavorite' => $this->project->isFavorite,
                'ownerProjectManagerId' => $this->project->ownerProjectManagerId,
            ],
        ];
    }
}
