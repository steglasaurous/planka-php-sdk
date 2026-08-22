<?php

declare(strict_types=1);

namespace Planka\Bridge\Views\Dto\Project;

use Planka\Bridge\Views\Dto\NotificationService\NotificationServiceDto;
use Planka\Bridge\Views\Dto\CustomField\BaseCustomFieldGroupDto;
use Planka\Bridge\Views\Factory\Project\ProjectManagerDto;
use Planka\Bridge\Views\Dto\Background\BackgroundImageDto;
use Planka\Bridge\Views\Dto\CustomField\CustomFieldDto;
use Planka\Bridge\Views\Dto\Board\BoardMembershipDto;
use Planka\Bridge\Views\Dto\Board\BoardItemDto;
use Planka\Bridge\Views\Dto\User\UserDto;

class ProjectIncludedDto
{
    /**
     * @param list<UserDto>                 $users
     * @param list<ProjectManagerDto>       $projectManagers
     * @param list<BoardItemDto>            $boards
     * @param list<BoardMembershipDto>      $boardMemberships
     * @param list<BackgroundImageDto>      $backgroundImages
     * @param list<BaseCustomFieldGroupDto> $baseCustomFieldGroups
     * @param list<CustomFieldDto>          $customFields
     * @param list<NotificationServiceDto>  $notificationServices
     */
    public function __construct(
        public array $users,
        public array $projectManagers,
        public array $boards,
        public array $boardMemberships,
        public array $backgroundImages = [],
        public array $baseCustomFieldGroups = [],
        public array $customFields = [],
        public array $notificationServices = [],
    ) {}
}
