<?php

declare(strict_types=1);

namespace Planka\Bridge\Controllers;

use Planka\Bridge\Actions\CustomField\BaseCustomFieldGroupCreateAction;
use Planka\Bridge\Actions\CustomField\BaseCustomFieldGroupDeleteAction;
use Planka\Bridge\Actions\CustomField\BaseCustomFieldGroupUpdateAction;
use Planka\Bridge\Actions\CustomField\CustomFieldValueDeleteAction;
use Planka\Bridge\Actions\CustomField\CustomFieldValueUpdateAction;
use Planka\Bridge\Actions\CustomField\CustomFieldGroupCreateAction;
use Planka\Bridge\Actions\CustomField\CustomFieldGroupDeleteAction;
use Planka\Bridge\Actions\CustomField\CustomFieldGroupUpdateAction;
use Planka\Bridge\Actions\CustomField\CustomFieldGroupViewAction;
use Planka\Bridge\Views\Dto\CustomField\BaseCustomFieldGroupDto;
use Planka\Bridge\Actions\CustomField\CustomFieldCreateAction;
use Planka\Bridge\Actions\CustomField\CustomFieldDeleteAction;
use Planka\Bridge\Actions\CustomField\CustomFieldUpdateAction;
use Planka\Bridge\Views\Dto\CustomField\CustomFieldGroupDto;
use Planka\Bridge\Views\Dto\CustomField\CustomFieldValueDto;
use Planka\Bridge\Views\Dto\CustomField\CustomFieldDto;
use Planka\Bridge\TransportClients\Client;
use Planka\Bridge\Config;

final class CustomField
{
    public function __construct(
        private readonly Config $config,
        private readonly Client $client,
    ) {}

    /** 'POST /api/projects/:projectId/base-custom-field-groups' */
    public function createBaseGroup(string $projectId, string $name): BaseCustomFieldGroupDto
    {
        return $this->client->post(new BaseCustomFieldGroupCreateAction(
            projectId: $projectId,
            name: $name,
            token: $this->config->getAuthToken(),
        ));
    }

    /** 'PATCH /api/base-custom-field-groups/:id' */
    public function updateBaseGroup(string $id, string $name): BaseCustomFieldGroupDto
    {
        return $this->client->patch(new BaseCustomFieldGroupUpdateAction(
            id: $id,
            name: $name,
            token: $this->config->getAuthToken(),
        ));
    }

    /** 'DELETE /api/base-custom-field-groups/:id' */
    public function deleteBaseGroup(string $id): BaseCustomFieldGroupDto
    {
        return $this->client->delete(new BaseCustomFieldGroupDeleteAction(
            id: $id,
            token: $this->config->getAuthToken(),
        ));
    }

    /** 'POST /api/boards/:boardId/custom-field-groups' */
    public function createBoardGroup(
        string $boardId,
        int $position,
        ?string $baseCustomFieldGroupId = null,
        ?string $name = null,
    ): CustomFieldGroupDto {
        return $this->client->post(new CustomFieldGroupCreateAction(
            parentId: $boardId,
            forCard: false,
            position: $position,
            token: $this->config->getAuthToken(),
            baseCustomFieldGroupId: $baseCustomFieldGroupId,
            name: $name,
        ));
    }

    /** 'POST /api/cards/:cardId/custom-field-groups' */
    public function createCardGroup(
        string $cardId,
        int $position,
        ?string $baseCustomFieldGroupId = null,
        ?string $name = null,
    ): CustomFieldGroupDto {
        return $this->client->post(new CustomFieldGroupCreateAction(
            parentId: $cardId,
            forCard: true,
            position: $position,
            token: $this->config->getAuthToken(),
            baseCustomFieldGroupId: $baseCustomFieldGroupId,
            name: $name,
        ));
    }

    /** 'GET /api/custom-field-groups/:id' */
    public function getGroup(string $id): CustomFieldGroupDto
    {
        return $this->client->get(new CustomFieldGroupViewAction(id: $id, token: $this->config->getAuthToken()));
    }

    /** 'PATCH /api/custom-field-groups/:id' */
    public function updateGroup(string $id, ?int $position = null, ?string $name = null): CustomFieldGroupDto
    {
        return $this->client->patch(new CustomFieldGroupUpdateAction(
            id: $id,
            token: $this->config->getAuthToken(),
            position: $position,
            name: $name,
        ));
    }

    /** 'DELETE /api/custom-field-groups/:id' */
    public function deleteGroup(string $id): CustomFieldGroupDto
    {
        return $this->client->delete(new CustomFieldGroupDeleteAction(id: $id, token: $this->config->getAuthToken()));
    }

    /** 'POST /api/base-custom-field-groups/:id/custom-fields' */
    public function createInBaseGroup(
        string $baseGroupId,
        int $position,
        string $name,
        ?bool $showOnFrontOfCard = null,
    ): CustomFieldDto {
        return $this->client->post(new CustomFieldCreateAction(
            groupId: $baseGroupId,
            inBaseGroup: true,
            position: $position,
            name: $name,
            token: $this->config->getAuthToken(),
            showOnFrontOfCard: $showOnFrontOfCard,
        ));
    }

    /** 'POST /api/custom-field-groups/:id/custom-fields' */
    public function createInGroup(
        string $groupId,
        int $position,
        string $name,
        ?bool $showOnFrontOfCard = null,
    ): CustomFieldDto {
        return $this->client->post(new CustomFieldCreateAction(
            groupId: $groupId,
            inBaseGroup: false,
            position: $position,
            name: $name,
            token: $this->config->getAuthToken(),
            showOnFrontOfCard: $showOnFrontOfCard,
        ));
    }

    /** 'PATCH /api/custom-fields/:id' */
    public function update(string $id, ?int $position = null, ?string $name = null, ?bool $showOnFrontOfCard = null): CustomFieldDto
    {
        return $this->client->patch(new CustomFieldUpdateAction(
            id: $id,
            token: $this->config->getAuthToken(),
            position: $position,
            name: $name,
            showOnFrontOfCard: $showOnFrontOfCard,
        ));
    }

    /** 'DELETE /api/custom-fields/:id' */
    public function delete(string $id): CustomFieldDto
    {
        return $this->client->delete(new CustomFieldDeleteAction(id: $id, token: $this->config->getAuthToken()));
    }

    /** 'PATCH /api/cards/:cardId/custom-field-values/...' */
    public function updateValue(
        string $cardId,
        string $customFieldGroupId,
        string $customFieldId,
        mixed $content,
    ): CustomFieldValueDto {
        return $this->client->patch(new CustomFieldValueUpdateAction(
            cardId: $cardId,
            customFieldGroupId: $customFieldGroupId,
            customFieldId: $customFieldId,
            content: $content,
            token: $this->config->getAuthToken(),
        ));
    }

    /** 'DELETE /api/cards/:cardId/custom-field-value/...' */
    public function deleteValue(
        string $cardId,
        string $customFieldGroupId,
        string $customFieldId,
    ): CustomFieldValueDto {
        return $this->client->delete(new CustomFieldValueDeleteAction(
            cardId: $cardId,
            customFieldGroupId: $customFieldGroupId,
            customFieldId: $customFieldId,
            token: $this->config->getAuthToken(),
        ));
    }
}
