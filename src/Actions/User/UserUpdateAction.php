<?php

declare(strict_types=1);

namespace Planka\Bridge\Actions\User;

use Planka\Bridge\Contracts\Actions\ResponseResultInterface;
use Planka\Bridge\Contracts\Actions\AuthenticateInterface;
use Planka\Bridge\Contracts\Actions\ActionInterface;
use Planka\Bridge\Traits\AuthenticateTrait;
use Planka\Bridge\Traits\UserHydrateTrait;
use Planka\Bridge\Views\Dto\User\UserDto;

final class UserUpdateAction implements ActionInterface, AuthenticateInterface, ResponseResultInterface
{
    use AuthenticateTrait;
    use UserHydrateTrait;

    public function __construct(private readonly UserDto $user, string $token)
    {
        $this->setToken($token);
    }

    public function url(): string
    {
        return "api/users/{$this->user->id}";
    }

    public function getOptions(): array
    {
        return [
            'json' => [
                'name' => $this->user->name,
                'organization' => $this->user->organization,
                'phone' => $this->user->phone,
                'language' => $this->user->language,
                'role' => $this->user->role->value,
                'subscribeToOwnCards' => $this->user->subscribeToOwnCards,
                'subscribeToCardWhenCommenting' => $this->user->subscribeToCardWhenCommenting,
                'turnOffRecentCardHighlighting' => $this->user->turnOffRecentCardHighlighting,
                'enableFavoritesByDefault' => $this->user->enableFavoritesByDefault,
                'defaultEditorMode' => $this->user->defaultEditorMode?->value,
                'defaultHomeView' => $this->user->defaultHomeView?->value,
                'defaultProjectsOrder' => $this->user->defaultProjectsOrder?->value,
                'autoLogoutMode' => $this->user->autoLogoutMode?->value,
                'isDeactivated' => $this->user->isDeactivated,
            ],
        ];
    }
}
