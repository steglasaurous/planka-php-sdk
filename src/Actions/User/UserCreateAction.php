<?php

declare(strict_types=1);

namespace Planka\Bridge\Actions\User;

use Planka\Bridge\Contracts\Actions\ResponseResultInterface;
use Planka\Bridge\Contracts\Actions\AuthenticateInterface;
use Planka\Bridge\Contracts\Actions\ActionInterface;
use Planka\Bridge\Traits\AuthenticateTrait;
use Planka\Bridge\Traits\UserHydrateTrait;
use Planka\Bridge\Enum\UserRoleEnum;

final class UserCreateAction implements ActionInterface, AuthenticateInterface, ResponseResultInterface
{
    use AuthenticateTrait;
    use UserHydrateTrait;

    public function __construct(
        private readonly string $email,
        private readonly string $name,
        private readonly string $password,
        private readonly UserRoleEnum $role,
        string $token,
        private readonly ?string $username = null,
        private readonly ?string $phone = null,
        private readonly ?string $organization = null,
        private readonly ?string $language = null,
        private readonly ?bool $subscribeToOwnCards = null,
        private readonly ?bool $subscribeToCardWhenCommenting = null,
        private readonly ?bool $turnOffRecentCardHighlighting = null,
    ) {
        $this->setToken($token);
    }

    public function url(): string
    {
        return 'api/users';
    }

    public function getOptions(): array
    {
        $json = [
            'email' => $this->email,
            'name' => $this->name,
            'password' => $this->password,
            'role' => $this->role->value,
        ];

        if (null !== $this->username) {
            $json['username'] = $this->username;
        }

        if (null !== $this->phone) {
            $json['phone'] = $this->phone;
        }

        if (null !== $this->organization) {
            $json['organization'] = $this->organization;
        }

        if (null !== $this->language) {
            $json['language'] = $this->language;
        }

        if (null !== $this->subscribeToOwnCards) {
            $json['subscribeToOwnCards'] = $this->subscribeToOwnCards;
        }

        if (null !== $this->subscribeToCardWhenCommenting) {
            $json['subscribeToCardWhenCommenting'] = $this->subscribeToCardWhenCommenting;
        }

        if (null !== $this->turnOffRecentCardHighlighting) {
            $json['turnOffRecentCardHighlighting'] = $this->turnOffRecentCardHighlighting;
        }

        return [
            'json' => $json,
        ];
    }
}
