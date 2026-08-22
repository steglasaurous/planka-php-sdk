### Example - Delete empty board

```php
<?php

use Planka\Bridge\Config;
use Planka\Bridge\PlankaClient;
use Planka\Bridge\Views\Dto\Board\BoardItemDto;

require __DIR__ . '/vendor/autoload.php';

$config = new Config(
    user: 'login',
    password: '***************',
    baseUri: 'http://192.168.1.101',
    port: 3000
);

$planka = new PlankaClient($config);

$result = $planka->authenticate();

if (!$result->success) {
    throw new RuntimeException('Authentication failed or requires TOTP/terms');
}

$dto = $planka->project->list();
$boards = $dto->included->boards;

/** @var BoardItemDto $item */
foreach ($boards as $item) {
    $board = $planka->board->get($item->id);

    if (empty($board->included->cards)) {
        $planka->board->delete($item->id);
    }
}
```
