<?php

declare(strict_types=1);

namespace Planka\Bridge\Views\Factory\Label;

use Planka\Bridge\Contracts\Factory\OutputInterface;
use Planka\Bridge\Traits\DateConverterTrait;
use Planka\Bridge\Views\Dto\Label\LabelDto;
use Planka\Bridge\Enum\LabelColorEnum;

final class LabelDtoFactory implements OutputInterface
{
    use DateConverterTrait;

    public function create(array $data): LabelDto
    {
        return new LabelDto(
            id: $data['id'],
            boardId: $data['boardId'],
            createdAt: $this->convertToDateTime($data['createdAt'] ?? null),
            updatedAt: $this->convertToDateTime($data['updatedAt'] ?? null),
            position: (int) ($data['position'] ?? 0),
            name: $data['name'] ?? null,
            color: LabelColorEnum::tryFrom($data['color'] ?? ''),
        );
    }
}
