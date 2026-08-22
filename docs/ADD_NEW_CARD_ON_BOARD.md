# Create a card on a board

Cards require a `type` (`project` or `story`). Checklist items now belong to a task list on the card.

```php
<?php

use Planka\Bridge\Config;
use Planka\Bridge\Enum\CardTypeEnum;
use Planka\Bridge\Enum\ListTypeEnum;
use Planka\Bridge\Enum\ProjectTypeEnum;
use Planka\Bridge\PlankaClient;

require __DIR__ . '/vendor/autoload.php';

$config = new Config(
    user: 'login',
    password: '***************',
    baseUri: 'http://192.168.1.101',
    port: 3000
);

$planka = new PlankaClient($config);
$planka->authenticate();

$project = $planka->project->create('Demo', ProjectTypeEnum::PRIVATE);
$board = $planka->board->create($project->id, 'Board', 65536);
$list = $planka->boardList->create($board->item->id, 'To Do', 65536, ListTypeEnum::ACTIVE);

$card = $planka->card->create(
    listId: $list->id,
    name: 'Write docs',
    position: 65536,
    type: CardTypeEnum::PROJECT,
    description: 'Document the 2.2.1 client'
);

$taskList = $planka->taskList->create($card->id, 65536, 'Checklist');
$planka->cardTask->create($taskList->id, 65536, 'Draft the README');
```
