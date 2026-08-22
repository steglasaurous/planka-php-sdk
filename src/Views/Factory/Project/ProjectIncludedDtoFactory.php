<?php

declare(strict_types=1);

namespace Planka\Bridge\Views\Factory\Project;

use Planka\Bridge\Views\Factory\NotificationService\NotificationServiceDtoFactory;
use Planka\Bridge\Views\Factory\CustomField\BaseCustomFieldGroupDtoFactory;
use Planka\Bridge\Views\Factory\Background\BackgroundImageDtoFactory;
use Planka\Bridge\Views\Factory\CustomField\CustomFieldDtoFactory;
use Planka\Bridge\Views\Factory\Board\BoardMembershipDtoFactory;
use Planka\Bridge\Views\Factory\Board\BoardItemDtoFactory;
use Planka\Bridge\Views\Dto\Project\ProjectIncludedDto;
use Planka\Bridge\Contracts\Factory\OutputInterface;
use Planka\Bridge\Views\Factory\User\UserDtoFactory;

use function Fp\Collection\map;

final class ProjectIncludedDtoFactory implements OutputInterface
{
    public function create(array $data): ProjectIncludedDto
    {
        return new ProjectIncludedDto(
            users: map($data['users'] ?? [], fn(array $item) => (new UserDtoFactory())->create($item)),
            projectManagers: map($data['projectManagers'] ?? [], fn(array $item) => (new ProjectManagerDtoFactory())->create($item)),
            boards: map($data['boards'] ?? [], fn(array $item) => (new BoardItemDtoFactory())->create($item)),
            boardMemberships: map($data['boardMemberships'] ?? [], fn(array $item) => (new BoardMembershipDtoFactory())->create($item)),
            backgroundImages: map($data['backgroundImages'] ?? [], fn(array $item) => (new BackgroundImageDtoFactory())->create($item)),
            baseCustomFieldGroups: map($data['baseCustomFieldGroups'] ?? [], fn(array $item) => (new BaseCustomFieldGroupDtoFactory())->create($item)),
            customFields: map($data['customFields'] ?? [], fn(array $item) => (new CustomFieldDtoFactory())->create($item)),
            notificationServices: map($data['notificationServices'] ?? [], fn(array $item) => (new NotificationServiceDtoFactory())->create($item)),
        );
    }
}
