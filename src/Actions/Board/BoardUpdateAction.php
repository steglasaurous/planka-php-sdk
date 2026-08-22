<?php

declare(strict_types=1);

namespace Planka\Bridge\Actions\Board;

use Planka\Bridge\Contracts\Actions\ResponseResultInterface;
use Planka\Bridge\Contracts\Actions\AuthenticateInterface;
use Planka\Bridge\Contracts\Actions\ActionInterface;
use Planka\Bridge\Traits\AuthenticateTrait;
use Planka\Bridge\Traits\BoardHydrateTrait;
use Planka\Bridge\Enum\BoardViewEnum;
use Planka\Bridge\Enum\CardTypeEnum;

final class BoardUpdateAction implements ActionInterface, AuthenticateInterface, ResponseResultInterface
{
    use AuthenticateTrait;
    use BoardHydrateTrait;

    public function __construct(
        private readonly string $boardId,
        string $token,
        private readonly ?string $name = null,
        private readonly ?int $position = null,
        private readonly ?BoardViewEnum $defaultView = null,
        private readonly ?CardTypeEnum $defaultCardType = null,
        private readonly ?bool $limitCardTypesToDefaultOne = null,
        private readonly ?bool $alwaysDisplayCardCreator = null,
        private readonly ?bool $displayCardAges = null,
        private readonly ?bool $expandTaskListsByDefault = null,
        private readonly ?bool $isSubscribed = null,
    ) {
        $this->setToken($token);
    }

    public function url(): string
    {
        return "api/boards/{$this->boardId}";
    }

    public function getOptions(): array
    {
        $json = [];

        if (null !== $this->name) {
            $json['name'] = $this->name;
        }

        if (null !== $this->position) {
            $json['position'] = $this->position;
        }

        if (null !== $this->defaultView) {
            $json['defaultView'] = $this->defaultView->value;
        }

        if (null !== $this->defaultCardType) {
            $json['defaultCardType'] = $this->defaultCardType->value;
        }

        if (null !== $this->limitCardTypesToDefaultOne) {
            $json['limitCardTypesToDefaultOne'] = $this->limitCardTypesToDefaultOne;
        }

        if (null !== $this->alwaysDisplayCardCreator) {
            $json['alwaysDisplayCardCreator'] = $this->alwaysDisplayCardCreator;
        }

        if (null !== $this->displayCardAges) {
            $json['displayCardAges'] = $this->displayCardAges;
        }

        if (null !== $this->expandTaskListsByDefault) {
            $json['expandTaskListsByDefault'] = $this->expandTaskListsByDefault;
        }

        if (null !== $this->isSubscribed) {
            $json['isSubscribed'] = $this->isSubscribed;
        }

        return [
            'json' => $json,
        ];
    }
}
