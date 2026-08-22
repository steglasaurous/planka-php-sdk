<?php

declare(strict_types=1);

namespace Planka\Bridge\Views\Factory\Card;

use Planka\Bridge\Contracts\Factory\OutputInterface;
use Planka\Bridge\Views\Dto\Card\CardActionItemDto;
use Planka\Bridge\Traits\DateConverterTrait;
use Planka\Bridge\Enum\ActionTypeEnum;

final class CardActionItemDtoFactory implements OutputInterface
{
    use DateConverterTrait;

    public function create(array $data): CardActionItemDto
    {
        return new CardActionItemDto(
            id: $data['id'],
            createdAt: $this->convertToDateTime($data['createdAt'] ?? null),
            updatedAt: $this->convertToDateTime($data['updatedAt'] ?? null),
            type: ActionTypeEnum::tryFrom($data['type'] ?? ''),
            data: $data['data'] ?? [],
            cardId: $data['cardId'],
            boardId: $data['boardId'] ?? null,
            userId: $data['userId'] ?? null,
        );
    }
}
