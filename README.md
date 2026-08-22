# PHP PLANKA REST API

Wrapper over the REST API of [Planka](https://github.com/plankanban/planka).

Tested on Planka version:

- 2.2.1

This is a breaking 2.x release of the SDK. Paths, required fields, and DTO shapes follow the OpenAPI spec in `swagger.json`.

## Install

`composer require decole/planka-php-sdk`

## How to use

```php
<?php

use Planka\Bridge\Config;
use Planka\Bridge\PlankaClient;

require __DIR__ . '/vendor/autoload.php';

$config = new Config(
    user: 'login',
    password: '***************',
    baseUri: 'http://192.168.1.101', // https://your.domain.com
    port: 3000                       // 443
    // apiKey: 'optional-api-key'    // alternatively authenticate with X-Api-Key
);

$planka = new PlankaClient($config);

$result = $planka->authenticate();

if (!$result->success) {
    if ($result->requiresTotp()) {
        $result = $planka->verifyTotp($result->pendingToken, '123456');
    }

    if ($result->requiresTerms()) {
        $terms = $planka->getTerms();
        $result = $planka->acceptTerms($result->pendingToken, $terms->signature);
    }
}

$projects = $planka->project->list();
```

You are always working as a specific user. Projects and boards that user cannot see are hidden by access rights.

Controllers live in `src/Controllers/`. Responses are typed DTOs.

## Authentication

- JWT login: `POST /api/access-tokens` via `$planka->authenticate()`
- TOTP follow-up: `$planka->verifyTotp($pendingToken, $code)`
- Terms follow-up: `$planka->acceptTerms($pendingToken, $signature)`
- API key: pass `apiKey` to `Config` to send an `X-Api-Key` header

## Breaking changes from SDK 1.x

- Project create requires `type` (`private` | `shared`)
- List create requires `type` (`active` | `closed`)
- User create requires `role` (`admin` | `projectOwner` | `boardUser`)
- Tasks belong to task lists: create a task list, then a task
- Comments use `/comments` instead of `/comment-actions`
- Memberships use `/board-memberships` and `/card-memberships`
- Card/board subscription is `PATCH` with `isSubscribed`, not a membership
- JSON request bodies (except multipart uploads)

## Examples

- [Delete empty board](docs/DELETE_EMPTY_BOARD.md)
- [Create a card on a board](docs/ADD_NEW_CARD_ON_BOARD.md)
- [Subscribe to a card](docs/SUBSCRIBE_MEMBERSHIP_TO_CARD.md)

You can smoke-test the client with `/tests/index.php`. Copy [config.example.php](tests/config.example.php) to `config.php`.

## Found problems

Using `Symfony\Component\HttpClient\NativeHttpClient` you can send passwords with special characters `()\|/"'`.
`CurlHttpClient` may escape those characters and Planka will reject the password.

## For develop

Psalm analyze: `./vendor/bin/psalm --no-cache --no-file-cache`

Or if you use linux, use `make psalm`

## API source

The 2.2.1 OpenAPI document is checked in as [swagger.json](swagger.json).
