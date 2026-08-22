<?php

declare(strict_types=1);

namespace Planka\Bridge\Views\Factory\User;

use Planka\Bridge\Contracts\Factory\OutputInterface;
use Planka\Bridge\Enum\AutoLogoutModeEnum;
use Planka\Bridge\Enum\ProjectsOrderEnum;
use Planka\Bridge\Traits\DateConverterTrait;
use Planka\Bridge\Views\Dto\User\UserDto;
use Planka\Bridge\Enum\EditorModeEnum;
use Planka\Bridge\Enum\HomeViewEnum;
use Planka\Bridge\Enum\UserRoleEnum;

final class UserDtoFactory implements OutputInterface
{
    use DateConverterTrait;

    public function create(array $data): UserDto
    {
        return new UserDto(
            id: $data['id'],
            createdAt: $this->convertToDateTime($data['createdAt'] ?? null),
            updatedAt: $this->convertToDateTime($data['updatedAt'] ?? null),
            email: $data['email'] ?? null,
            role: UserRoleEnum::from($data['role']),
            name: $data['name'] ?? null,
            username: $data['username'] ?? null,
            phone: $data['phone'] ?? null,
            organization: $data['organization'] ?? null,
            language: $data['language'] ?? null,
            avatar: (new AvatarDtoFactory())->create($data['avatar'] ?? null),
            gravatarUrl: $data['gravatarUrl'] ?? null,
            apiKeyPrefix: $data['apiKeyPrefix'] ?? null,
            subscribeToOwnCards: (bool) ($data['subscribeToOwnCards'] ?? false),
            subscribeToCardWhenCommenting: (bool) ($data['subscribeToCardWhenCommenting'] ?? true),
            turnOffRecentCardHighlighting: (bool) ($data['turnOffRecentCardHighlighting'] ?? false),
            enableFavoritesByDefault: (bool) ($data['enableFavoritesByDefault'] ?? true),
            defaultEditorMode: EditorModeEnum::tryFrom($data['defaultEditorMode'] ?? ''),
            defaultHomeView: HomeViewEnum::tryFrom($data['defaultHomeView'] ?? ''),
            defaultProjectsOrder: ProjectsOrderEnum::tryFrom($data['defaultProjectsOrder'] ?? ''),
            autoLogoutMode: AutoLogoutModeEnum::tryFrom($data['autoLogoutMode'] ?? ''),
            isTotpEnabled: (bool) ($data['isTotpEnabled'] ?? false),
            totpEnabledAt: $this->convertToDateTime($data['totpEnabledAt'] ?? null),
            totpRecoveryCodesRemaining: isset($data['totpRecoveryCodesRemaining'])
                ? (int) $data['totpRecoveryCodesRemaining']
                : null,
            isDeactivated: (bool) ($data['isDeactivated'] ?? false),
            isDefaultAdmin: (bool) ($data['isDefaultAdmin'] ?? false),
            lockedFieldNames: $data['lockedFieldNames'] ?? [],
            _rawResponse: $data,
        );
    }
}
