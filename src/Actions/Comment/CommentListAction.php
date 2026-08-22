<?php

declare(strict_types=1);

namespace Planka\Bridge\Actions\Comment;

use Planka\Bridge\Views\Factory\Comment\CommentDtoFactory;
use Planka\Bridge\Contracts\Actions\ResponseResultInterface;
use Planka\Bridge\Contracts\Actions\AuthenticateInterface;
use Planka\Bridge\Contracts\Actions\ActionInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;
use Planka\Bridge\Views\Dto\Comment\CommentDto;
use Planka\Bridge\Traits\AuthenticateTrait;

use function Fp\Collection\map;

final class CommentListAction implements ActionInterface, AuthenticateInterface, ResponseResultInterface
{
    use AuthenticateTrait;

    public function __construct(
        private readonly string $cardId,
        string $token,
        private readonly ?string $beforeId = null,
    ) {
        $this->setToken($token);
    }

    public function url(): string
    {
        return "api/cards/{$this->cardId}/comments";
    }

    public function getOptions(): array
    {
        if (null === $this->beforeId) {
            return [];
        }

        return [
            'query' => [
                'beforeId' => $this->beforeId,
            ],
        ];
    }

    /**
     * @return list<CommentDto>
     */
    public function hydrate(ResponseInterface $response): array
    {
        $data = $response->toArray();

        return map($data['items'] ?? [], fn(array $item) => (new CommentDtoFactory())->create($item));
    }
}
