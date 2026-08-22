<?php

declare(strict_types=1);

namespace Planka\Bridge\Actions\BoardList;

use Planka\Bridge\Contracts\Actions\ResponseResultInterface;
use Planka\Bridge\Contracts\Actions\AuthenticateInterface;
use Planka\Bridge\Contracts\Actions\ActionInterface;
use Planka\Bridge\Traits\BoardListHydrateTrait;
use Planka\Bridge\Traits\AuthenticateTrait;
use Planka\Bridge\Enum\ListTypeEnum;

final class BoardListCreateAction implements ActionInterface, AuthenticateInterface, ResponseResultInterface
{
    use AuthenticateTrait;
    use BoardListHydrateTrait;

    public function __construct(
        private readonly string $boardId,
        private readonly string $name,
        private readonly int $position,
        private readonly ListTypeEnum $type,
        string $token,
    ) {
        $this->setToken($token);
    }

    public function url(): string
    {
        return "api/boards/{$this->boardId}/lists";
    }

    public function getOptions(): array
    {
        return [
            'json' => [
                'name' => $this->name,
                'position' => $this->position,
                'type' => $this->type->value,
            ],
        ];
    }
}
