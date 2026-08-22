# Subscribe to a card

In Planka 2.2.1, subscription is a card field (`isSubscribed`), not a membership.
Use card memberships only to assign users to a card.

```php
<?php

declare(strict_types=1);

use Planka\Bridge\Config;
use Planka\Bridge\PlankaClient;

$config = include __DIR__ . '/../tests/config.php';

require __DIR__ . '/../vendor/autoload.php';

$config = new Config(
    user: $config['login'],
    password: $config['password'],
    baseUri: $config['uri'],
    port: $config['port']
);
$client = new PlankaClient($config);

$info = $client->getInfo();
if ('' === $info->version) {
    die('Planka server not connected!');
}

$result = $client->authenticate();
if (!$result->success) {
    die('User credentials not corrected!');
}

$list = $client->project->list();
$project = $list->items[0];
$board = null;

foreach ($list->included->boards as $item) {
    if ($item->projectId === $project->id) {
        $board = $item;
        break;
    }
}

$boardInfo = $client->board->get($board->id);

foreach ($boardInfo->included->cards as $item) {
    $client->card->subscribe($item->id, true);
}

foreach ($boardInfo->included->cards as $item) {
    $client->card->unsubscribe($item->id);
}
```
