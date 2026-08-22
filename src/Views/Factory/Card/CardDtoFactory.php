<?php

declare(strict_types=1);

namespace Planka\Bridge\Views\Factory\Card;

use Planka\Bridge\Views\Factory\CustomField\CustomFieldValueDtoFactory;
use Planka\Bridge\Views\Factory\CustomField\CustomFieldGroupDtoFactory;
use Planka\Bridge\Views\Factory\Attachment\AttachmentDtoFactory;
use Planka\Bridge\Views\Factory\TaskList\TaskListDtoFactory;
use Planka\Bridge\Contracts\Factory\OutputInterface;
use Planka\Bridge\Views\Dto\Card\CardIncludedDto;
use Planka\Bridge\Traits\DateConverterTrait;
use Planka\Bridge\Views\Dto\Card\CardDto;
use Planka\Bridge\Enum\CardTypeEnum;

use function Fp\Collection\map;

final class CardDtoFactory implements OutputInterface
{
    use DateConverterTrait;

    public function create(array $data): CardDto
    {
        $item = $data['item'] ?? $data;

        return new CardDto(
            id: $item['id'],
            createdAt: $this->convertToDateTime($item['createdAt'] ?? null),
            updatedAt: $this->convertToDateTime($item['updatedAt'] ?? null),
            type: CardTypeEnum::tryFrom($item['type'] ?? '') ?? CardTypeEnum::PROJECT,
            position: (int) ($item['position'] ?? 0),
            name: $item['name'] ?? '',
            description: $item['description'] ?? null,
            dueDate: $this->convertToDateTime($item['dueDate'] ?? null),
            isDueCompleted: isset($item['isDueCompleted']) ? (bool) $item['isDueCompleted'] : null,
            stopwatch: (new StopWatchDtoFactory())->create($item['stopwatch'] ?? null),
            commentsTotal: (int) ($item['commentsTotal'] ?? 0),
            isClosed: (bool) ($item['isClosed'] ?? false),
            listChangedAt: $this->convertToDateTime($item['listChangedAt'] ?? null),
            boardId: $item['boardId'],
            listId: $item['listId'] ?? '',
            creatorUserId: $item['creatorUserId'] ?? null,
            prevListId: $item['prevListId'] ?? null,
            coverAttachmentId: $item['coverAttachmentId'] ?? null,
            isSubscribed: (bool) ($item['isSubscribed'] ?? false),
            included: $this->getIncluded($data),
        );
    }

    private function getIncluded(array $data): CardIncludedDto
    {
        $included = $data['included'] ?? [];

        return new CardIncludedDto(
            cardMemberships: map($included['cardMemberships'] ?? [], fn(array $item) => (new CardMembershipDtoFactory())->create($item)),
            cardLabels: map($included['cardLabels'] ?? [], fn(array $item) => (new CardLabelDtoFactory())->create($item)),
            taskLists: map($included['taskLists'] ?? [], fn(array $item) => (new TaskListDtoFactory())->create($item)),
            tasks: map($included['tasks'] ?? [], fn(array $item) => (new CardTaskDtoFactory())->create($item)),
            attachments: map($included['attachments'] ?? [], fn(array $item) => (new AttachmentDtoFactory())->create($item)),
            customFieldGroups: map($included['customFieldGroups'] ?? [], fn(array $item) => (new CustomFieldGroupDtoFactory())->create($item)),
            customFieldValues: map($included['customFieldValues'] ?? [], fn(array $item) => (new CustomFieldValueDtoFactory())->create($item)),
        );
    }
}
