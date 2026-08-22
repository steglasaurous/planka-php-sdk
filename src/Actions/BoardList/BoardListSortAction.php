<?php

declare(strict_types=1);

namespace Planka\Bridge\Actions\BoardList;

use Planka\Bridge\Contracts\Actions\ResponseResultInterface;
use Planka\Bridge\Contracts\Actions\AuthenticateInterface;
use Planka\Bridge\Contracts\Actions\ActionInterface;
use Planka\Bridge\Traits\BoardListHydrateTrait;
use Planka\Bridge\Enum\ListSortFieldEnum;
use Planka\Bridge\Traits\AuthenticateTrait;
use Planka\Bridge\Enum\SortOrderEnum;

final class BoardListSortAction implements ActionInterface, AuthenticateInterface, ResponseResultInterface
{
    use AuthenticateTrait;
    use BoardListHydrateTrait;

    public function __construct(
        private readonly string $listId,
        private readonly ListSortFieldEnum $fieldName,
        string $token,
        private readonly ?SortOrderEnum $order = null,
    ) {
        $this->setToken($token);
    }

    public function url(): string
    {
        return "api/lists/{$this->listId}/sort";
    }

    public function getOptions(): array
    {
        $json = [
            'fieldName' => $this->fieldName->value,
        ];

        if (null !== $this->order) {
            $json['order'] = $this->order->value;
        }

        return ['json' => $json];
    }
}
