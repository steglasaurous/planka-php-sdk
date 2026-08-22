<?php

declare(strict_types=1);

namespace Planka\Bridge\Actions\BoardList;

use Planka\Bridge\Contracts\Actions\ResponseResultInterface;
use Planka\Bridge\Contracts\Actions\AuthenticateInterface;
use Planka\Bridge\Contracts\Actions\ActionInterface;
use Planka\Bridge\Traits\BoardListHydrateTrait;
use Planka\Bridge\Traits\AuthenticateTrait;
use Planka\Bridge\Enum\ListColorEnum;
use Planka\Bridge\Enum\ListTypeEnum;

final class BoardListUpdateAction implements ActionInterface, AuthenticateInterface, ResponseResultInterface
{
    use AuthenticateTrait;
    use BoardListHydrateTrait;

    public function __construct(
        private readonly string $listId,
        string $token,
        private readonly ?string $name = null,
        private readonly ?string $boardId = null,
        private readonly ?ListTypeEnum $type = null,
        private readonly ?int $position = null,
        private readonly ?ListColorEnum $color = null,
    ) {
        $this->setToken($token);
    }

    public function url(): string
    {
        return "api/lists/{$this->listId}";
    }

    public function getOptions(): array
    {
        $json = [];

        if (null !== $this->name) {
            $json['name'] = $this->name;
        }

        if (null !== $this->boardId) {
            $json['boardId'] = $this->boardId;
        }

        if (null !== $this->type) {
            $json['type'] = $this->type->value;
        }

        if (null !== $this->position) {
            $json['position'] = $this->position;
        }

        if (null !== $this->color) {
            $json['color'] = $this->color->value;
        }

        return [
            'json' => $json,
        ];
    }
}
