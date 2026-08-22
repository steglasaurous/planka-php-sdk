<?php

declare(strict_types=1);

namespace Planka\Bridge\Views\Dto\User;

use Planka\Bridge\Contracts\Dto\OutputDtoInterface;
use Planka\Bridge\Enum\AutoLogoutModeEnum;
use Planka\Bridge\Enum\ProjectsOrderEnum;
use Planka\Bridge\Enum\EditorModeEnum;
use Planka\Bridge\Enum\HomeViewEnum;
use Planka\Bridge\Enum\UserRoleEnum;

class UserDto implements OutputDtoInterface
{
    /**
     * @param list<string> $lockedFieldNames
     */
    public function __construct(
        public readonly string $id,
        public readonly ?\DateTimeImmutable $createdAt,
        public readonly ?\DateTimeImmutable $updatedAt,
        public ?string $email,
        public UserRoleEnum $role,
        public ?string $name,
        public ?string $username,
        public ?string $phone,
        public ?string $organization,
        public ?string $language,
        public ?AvatarDto $avatar,
        public ?string $gravatarUrl,
        public ?string $apiKeyPrefix,
        public bool $subscribeToOwnCards,
        public bool $subscribeToCardWhenCommenting,
        public bool $turnOffRecentCardHighlighting,
        public bool $enableFavoritesByDefault,
        public ?EditorModeEnum $defaultEditorMode,
        public ?HomeViewEnum $defaultHomeView,
        public ?ProjectsOrderEnum $defaultProjectsOrder,
        public ?AutoLogoutModeEnum $autoLogoutMode,
        public bool $isTotpEnabled,
        public readonly ?\DateTimeImmutable $totpEnabledAt,
        public ?int $totpRecoveryCodesRemaining,
        public bool $isDeactivated,
        public bool $isDefaultAdmin,
        public array $lockedFieldNames,
        public readonly array $_rawResponse = [],
    ) {}
}
