<?php

declare(strict_types=1);

namespace Planka\Bridge\Controllers;

use Planka\Bridge\Actions\Comment\CommentCreateAction;
use Planka\Bridge\Actions\Comment\CommentDeleteAction;
use Planka\Bridge\Actions\Comment\CommentUpdateAction;
use Planka\Bridge\Actions\Comment\CommentListAction;
use Planka\Bridge\Views\Dto\Comment\CommentDto;
use Planka\Bridge\TransportClients\Client;
use Planka\Bridge\Config;

final class Comment
{
    public function __construct(
        private readonly Config $config,
        private readonly Client $client,
    ) {}

    /**
     * 'GET /api/cards/:cardId/comments'.
     *
     * @return list<CommentDto>
     */
    public function list(string $cardId, ?string $beforeId = null): array
    {
        return $this->client->get(new CommentListAction(
            cardId: $cardId,
            token: $this->config->getAuthToken(),
            beforeId: $beforeId,
        ));
    }

    /** 'POST /api/cards/:cardId/comments' */
    public function add(string $cardId, string $text): CommentDto
    {
        return $this->client->post(new CommentCreateAction(
            cardId: $cardId,
            text: $text,
            token: $this->config->getAuthToken(),
        ));
    }

    /** 'PATCH /api/comments/:id' */
    public function update(string $commentId, string $text): CommentDto
    {
        return $this->client->patch(new CommentUpdateAction(
            commentId: $commentId,
            text: $text,
            token: $this->config->getAuthToken(),
        ));
    }

    /** 'DELETE /api/comments/:id' */
    public function remove(string $commentId): CommentDto
    {
        return $this->client->delete(new CommentDeleteAction(
            commentId: $commentId,
            token: $this->config->getAuthToken(),
        ));
    }
}
