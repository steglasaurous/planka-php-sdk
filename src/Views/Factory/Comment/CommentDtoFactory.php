<?php

declare(strict_types=1);

namespace Planka\Bridge\Views\Factory\Comment;

use Planka\Bridge\Contracts\Factory\OutputInterface;
use Planka\Bridge\Views\Dto\Comment\CommentDto;
use Planka\Bridge\Traits\DateConverterTrait;

final class CommentDtoFactory implements OutputInterface
{
    use DateConverterTrait;

    public function create(array $data): CommentDto
    {
        return new CommentDto(
            id: $data['id'],
            createdAt: $this->convertToDateTime($data['createdAt'] ?? null),
            updatedAt: $this->convertToDateTime($data['updatedAt'] ?? null),
            cardId: $data['cardId'],
            userId: $data['userId'] ?? null,
            text: $data['text'] ?? ($data['data']['text'] ?? ''),
        );
    }
}
