<?php

declare(strict_types=1);

namespace Planka\Bridge\Views\Factory\Board;

use Planka\Bridge\Contracts\Factory\OutputInterface;
use Planka\Bridge\Views\Dto\Board\BoardListDto;
use Planka\Bridge\Traits\DateConverterTrait;
use Planka\Bridge\Enum\ListColorEnum;
use Planka\Bridge\Enum\ListTypeEnum;

final class BoardListDtoFactory implements OutputInterface
{
    use DateConverterTrait;

    public function create(array $data): BoardListDto
    {
        return new BoardListDto(
            id: $data['id'],
            boardId: $data['boardId'],
            createdAt: $this->convertToDateTime($data['createdAt'] ?? null),
            updatedAt: $this->convertToDateTime($data['updatedAt'] ?? null),
            position: isset($data['position']) ? (int) $data['position'] : null,
            name: $data['name'] ?? null,
            type: ListTypeEnum::tryFrom($data['type'] ?? '') ?? ListTypeEnum::ACTIVE,
            color: ListColorEnum::tryFrom($data['color'] ?? ''),
        );
    }
}
