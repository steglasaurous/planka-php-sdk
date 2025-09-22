<?php

declare(strict_types=1);

namespace Planka\Bridge\Views\Dto\User;

use Planka\Bridge\Contracts\Dto\OutputDtoInterface;

class UserDto implements OutputDtoInterface
{
    public function __construct(
        public readonly string $id,
        public readonly \DateTimeImmutable $createdAt,
        public readonly ?\DateTimeImmutable $updatedAt,
        public ?string $email,
        public string $role,
        public ?string $name,
        public ?string $username,
        public ?string $phone,
        public ?string $organization,
        public ?string $language,
        public bool $subscribeToOwnCards,
        public bool $subscribeToCardWhenCommenting,
        public bool $turnOffRecentCardHighlighting,
        public bool $enableFavoritesByDefault,
        public string $defaultEditorMode,
        public string $defaultProjectsOrder,
        public bool $isSsoUser,
        public bool $isDeactivated,
        // avatar - it's a particular structure, need to spec that out
        public bool $isDefaultAdmin
    ) {}
}
