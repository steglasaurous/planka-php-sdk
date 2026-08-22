<?php

declare(strict_types=1);

namespace Planka\Bridge\Actions\Card;

use Planka\Bridge\Contracts\Actions\ResponseResultInterface;
use Planka\Bridge\Contracts\Actions\AuthenticateInterface;
use Planka\Bridge\Contracts\Actions\ActionInterface;
use Planka\Bridge\Views\Factory\Card\CardDtoFactory;
use Symfony\Contracts\HttpClient\ResponseInterface;
use Planka\Bridge\Traits\AuthenticateTrait;
use Planka\Bridge\Views\Dto\Card\CardDto;

use function Fp\Collection\map;

final class CardListAction implements ActionInterface, AuthenticateInterface, ResponseResultInterface
{
    use AuthenticateTrait;

    /**
     * @param list<string>|null $userIds
     * @param list<string>|null $labelIds
     */
    public function __construct(
        private readonly string $listId,
        string $token,
        private readonly ?string $beforeId = null,
        private readonly ?string $beforeListChangedAt = null,
        private readonly ?string $search = null,
        private readonly ?array $userIds = null,
        private readonly ?array $labelIds = null,
    ) {
        $this->setToken($token);
    }

    public function url(): string
    {
        return "api/lists/{$this->listId}/cards";
    }

    public function getOptions(): array
    {
        $query = [];

        if (null !== $this->beforeId) {
            $query['before[id]'] = $this->beforeId;
        }

        if (null !== $this->beforeListChangedAt) {
            $query['before[listChangedAt]'] = $this->beforeListChangedAt;
        }

        if (null !== $this->search) {
            $query['search'] = $this->search;
        }

        if (null !== $this->userIds) {
            $query['userIds'] = implode(',', $this->userIds);
        }

        if (null !== $this->labelIds) {
            $query['labelIds'] = implode(',', $this->labelIds);
        }

        return [] === $query ? [] : ['query' => $query];
    }

    /**
     * @return list<CardDto>
     */
    public function hydrate(ResponseInterface $response): array
    {
        $data = $response->toArray();

        return map($data['items'] ?? [], fn(array $item) => (new CardDtoFactory())->create(['item' => $item]));
    }
}
