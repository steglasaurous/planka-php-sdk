<?php

declare(strict_types=1);

namespace Planka\Bridge\Views\Dto\Card;

use Planka\Bridge\Views\Dto\CustomField\CustomFieldGroupDto;
use Planka\Bridge\Views\Dto\CustomField\CustomFieldValueDto;
use Planka\Bridge\Views\Dto\Attachment\AttachmentDto;
use Planka\Bridge\Views\Dto\TaskList\TaskListDto;

class CardIncludedDto
{
    /**
     * @param list<CardMembershipDto>   $cardMemberships
     * @param list<CardLabelDto>        $cardLabels
     * @param list<TaskListDto>         $taskLists
     * @param list<CardTaskDto>         $tasks
     * @param list<AttachmentDto>       $attachments
     * @param list<CustomFieldGroupDto> $customFieldGroups
     * @param list<CustomFieldValueDto> $customFieldValues
     */
    public function __construct(
        public array $cardMemberships,
        public array $cardLabels,
        public array $taskLists,
        public array $tasks,
        public array $attachments,
        public array $customFieldGroups = [],
        public array $customFieldValues = [],
    ) {}
}
