<?php

declare(strict_types=1);

namespace Planka\Bridge\Views\Factory\Board;

use Planka\Bridge\Views\Factory\NotificationService\NotificationServiceDtoFactory;
use Planka\Bridge\Views\Factory\CustomField\CustomFieldValueDtoFactory;
use Planka\Bridge\Views\Factory\CustomField\CustomFieldGroupDtoFactory;
use Planka\Bridge\Views\Factory\CustomField\CustomFieldDtoFactory;
use Planka\Bridge\Views\Factory\Attachment\AttachmentDtoFactory;
use Planka\Bridge\Views\Factory\Card\CardMembershipDtoFactory;
use Planka\Bridge\Views\Factory\Project\ProjectDtoFactory;
use Planka\Bridge\Views\Factory\TaskList\TaskListDtoFactory;
use Planka\Bridge\Views\Factory\Card\CardLabelDtoFactory;
use Planka\Bridge\Views\Factory\Card\CardTaskDtoFactory;
use Planka\Bridge\Views\Factory\Label\LabelDtoFactory;
use Planka\Bridge\Views\Factory\Card\CardDtoFactory;
use Planka\Bridge\Views\Factory\List\ListDtoFactory;
use Planka\Bridge\Views\Factory\User\UserDtoFactory;
use Planka\Bridge\Contracts\Factory\OutputInterface;
use Planka\Bridge\Views\Dto\Board\BoardIncludedDto;

use function Fp\Collection\map;

final class BoardIncludedDtoFactory implements OutputInterface
{
    public function create(?array $data): ?BoardIncludedDto
    {
        if (null === $data) {
            return null;
        }

        return new BoardIncludedDto(
            users: map($data['users'] ?? [], fn(array $item) => (new UserDtoFactory())->create($item)),
            boardMemberships: map($data['boardMemberships'] ?? [], fn(array $item) => (new BoardMembershipDtoFactory())->create($item)),
            labels: map($data['labels'] ?? [], fn(array $item) => (new LabelDtoFactory())->create($item)),
            lists: map($data['lists'] ?? [], fn(array $item) => (new ListDtoFactory())->create($item)),
            cards: map($data['cards'] ?? [], fn(array $item) => (new CardDtoFactory())->create(['item' => $item])),
            cardMemberships: map($data['cardMemberships'] ?? [], fn(array $item) => (new CardMembershipDtoFactory())->create($item)),
            cardLabels: map($data['cardLabels'] ?? [], fn(array $item) => (new CardLabelDtoFactory())->create($item)),
            taskLists: map($data['taskLists'] ?? [], fn(array $item) => (new TaskListDtoFactory())->create($item)),
            tasks: map($data['tasks'] ?? [], fn(array $item) => (new CardTaskDtoFactory())->create($item)),
            attachments: map($data['attachments'] ?? [], fn(array $item) => (new AttachmentDtoFactory())->create($item)),
            projects: map($data['projects'] ?? [], fn(array $item) => (new ProjectDtoFactory())->create($item)),
            customFieldGroups: map($data['customFieldGroups'] ?? [], fn(array $item) => (new CustomFieldGroupDtoFactory())->create($item)),
            customFields: map($data['customFields'] ?? [], fn(array $item) => (new CustomFieldDtoFactory())->create($item)),
            customFieldValues: map($data['customFieldValues'] ?? [], fn(array $item) => (new CustomFieldValueDtoFactory())->create($item)),
            notificationServices: map($data['notificationServices'] ?? [], fn(array $item) => (new NotificationServiceDtoFactory())->create($item)),
        );
    }
}
