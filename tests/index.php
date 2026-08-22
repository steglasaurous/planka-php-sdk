<?php

declare(strict_types=1);

use Planka\Bridge\Config;
use Planka\Bridge\Enum\CardTypeEnum;
use Planka\Bridge\Enum\LabelColorEnum;
use Planka\Bridge\Enum\ListTypeEnum;
use Planka\Bridge\Enum\ProjectTypeEnum;
use Planka\Bridge\PlankaClient;
use Planka\Bridge\Views\Dto\Card\StopWatchDto;

$config = include __DIR__ . '/config.php';

require __DIR__ . '/../vendor/autoload.php';

dump('
===

Testing Planka version 2.2.1

===
');

dump('Start tests');

$config = new Config(
    user: $config['login'],
    password: $config['password'],
    baseUri: $config['uri'],
    port: $config['port'],
);
$client = new PlankaClient($config);

$filePath = __DIR__ . '/image.png';

dump('Configure success');

$info = $client->getInfo();

if ('' === $info->version) {
    dd('Planka server not connected!');
}

dump('Planka version: ' . $info->version);
dump('Try authenticate');

$auth = $client->authenticate();

if (!$auth->success) {
    dd('User credentials not corrected or TOTP/terms required', $auth);
}

dump('Start check routes');

$project = $client->project->create('sdk-test', ProjectTypeEnum::PRIVATE);
$board = $client->board->create($project->id, 'testCard', 1);
$boardGet = $client->board->get($board->item->id);
$boardOther = $client->board->create($project->id, 'archive', 2);

$client->board->update($boardGet->item->id, 'romb');

$list = $client->boardList->create($boardGet->item->id, 'one', 1, ListTypeEnum::ACTIVE);
$listOther = $client->boardList->create($boardOther->item->id, 'archive', 22, ListTypeEnum::ACTIVE);

$card = $client->card->create($list->id, 'card', 1, CardTypeEnum::PROJECT);
$cardGet = $client->card->get($card->id);

$cardGet->name = 'limonad';
$cardGet->position = 2;
$cardGet->stopwatch = new StopWatchDto(null, 2);
$cardGet->isSubscribed = true;
$cardGet->description = 'ok!';
$client->card->update($cardGet);

$client->card->triggerTimer($card, true);
$client->card->triggerTimer($card, false);

$card->boardId = $boardOther->item->id;
$card->listId = $listOther->id;
$card->position = 33;
$client->card->moveCard($card);

$card->boardId = $board->item->id;
$card->listId = $list->id;
$card->position = 1;
$client->card->moveCard($card);

$client->card->addSpentTime($cardGet, 290);
$client->card->clearTime($cardGet);
$client->cardAction->getActions($cardGet->id);

try {
    $attachment = $client->attachment->upload($cardGet->id, 'image.png', $filePath);
    $client->attachment->updateName($attachment->id, 'mimo');
    $client->attachment->delete($attachment->id);
} catch (Throwable $exception) {
    dump('Upload attachment to card error', $exception->getMessage());
}

$taskList = $client->taskList->create($cardGet->id, 1, 'Checklist');
$client->cardTask->create($taskList->id, 1, 'one');
$taskItem = $client->cardTask->create($taskList->id, 2, 'two');
$taskItem->isCompleted = true;
$client->cardTask->update($taskItem);

$boardGet = $client->board->get($boardGet->item->id);

foreach ($boardGet->included->tasks as $task) {
    $task->isCompleted = true;
    $client->cardTask->update($task);
}

$boardGet = $client->board->get($boardGet->item->id);

foreach ($boardGet->included->tasks as $task) {
    $client->cardTask->delete($task->id);
}

$client->taskList->delete($taskList->id);

$boardGet = $client->board->get($boardGet->item->id);
$user = $boardGet->included->users[0];
$client->cardMembership->add($cardGet->id, $user->id);
$client->cardMembership->remove($cardGet->id, $user->id);

$cardGet->dueDate = (new DateTimeImmutable())->modify('+ 1 year');
$client->card->update($cardGet);
$cardGet->dueDate = null;
$client->card->update($cardGet);

$client->notification->list();

$label = $client->label->create($boardGet->item->id, 'test', LabelColorEnum::APRICOT_RED, 1);
$client->label->update($label->id, 'mimo', LabelColorEnum::CORAL_GREEN);
$client->cardLabel->add($cardGet->id, $label->id);
$client->cardLabel->remove($cardGet->id, $label->id);
$client->label->delete($label->id);

$client->card->delete($cardGet->id);
$client->board->delete($boardGet->item->id);
$client->project->delete($project->id);

dump('Smoke test completed');
