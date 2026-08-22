<?php

declare(strict_types=1);

namespace Planka\Bridge\Views\Factory\Board;

use Planka\Bridge\Contracts\Factory\OutputInterface;
use Planka\Bridge\Views\Dto\Board\BoardItemDto;
use Planka\Bridge\Traits\DateConverterTrait;
use Planka\Bridge\Enum\BoardViewEnum;
use Planka\Bridge\Enum\CardTypeEnum;

final class BoardItemDtoFactory implements OutputInterface
{
    use DateConverterTrait;

    public function create(array $data): BoardItemDto
    {
        return new BoardItemDto(
            id: $data['id'] ?? null,
            projectId: $data['projectId'] ?? null,
            position: isset($data['position']) ? (int) $data['position'] : null,
            name: $data['name'] ?? null,
            defaultView: BoardViewEnum::tryFrom($data['defaultView'] ?? ''),
            defaultCardType: CardTypeEnum::tryFrom($data['defaultCardType'] ?? ''),
            limitCardTypesToDefaultOne: (bool) ($data['limitCardTypesToDefaultOne'] ?? false),
            alwaysDisplayCardCreator: (bool) ($data['alwaysDisplayCardCreator'] ?? false),
            displayCardAges: (bool) ($data['displayCardAges'] ?? false),
            expandTaskListsByDefault: (bool) ($data['expandTaskListsByDefault'] ?? false),
            createdAt: $this->convertToDateTime($data['createdAt'] ?? null),
            updatedAt: $this->convertToDateTime($data['updatedAt'] ?? null),
        );
    }
}
