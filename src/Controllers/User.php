<?php

declare(strict_types=1);

namespace Planka\Bridge\Controllers;

use Planka\Bridge\Actions\User\UserTrustedDeviceDeleteAction;
use Planka\Bridge\Actions\User\UserTotpRecoveryCodesAction;
use Planka\Bridge\Actions\User\UserTrustedDevicesAction;
use Planka\Bridge\Actions\User\UserUpdatePasswordAction;
use Planka\Bridge\Actions\User\UserUpdateUsernameAction;
use Planka\Bridge\Actions\User\UserCreateApiKeyAction;
use Planka\Bridge\Actions\User\UserUpdateAvatarAction;
use Planka\Bridge\Actions\User\UserTotpDisableAction;
use Planka\Bridge\Actions\User\UserUpdateEmailAction;
use Planka\Bridge\Actions\User\UserTotpEnableAction;
use Planka\Bridge\Actions\User\UserTotpSetupAction;
use Planka\Bridge\Actions\User\UserCreateAction;
use Planka\Bridge\Actions\User\UserDeleteAction;
use Planka\Bridge\Actions\User\UserUpdateAction;
use Planka\Bridge\Exceptions\FileExistException;
use Planka\Bridge\Actions\User\UserListAction;
use Planka\Bridge\Actions\User\UserViewAction;
use Planka\Bridge\TransportClients\Client;
use Planka\Bridge\Views\Dto\User\UserDto;
use Planka\Bridge\Enum\UserRoleEnum;
use Planka\Bridge\Config;

final class User
{
    public function __construct(
        private readonly Config $config,
        private readonly Client $client,
    ) {}

    /**
     * 'GET /api/users'.
     *
     * @return UserDto[]
     */
    public function list(): array
    {
        return $this->client->get(new UserListAction($this->config->getAuthToken()));
    }

    /** 'POST /api/users' */
    public function create(
        string $email,
        string $name,
        string $password,
        UserRoleEnum $role,
        ?string $username = null,
        ?string $phone = null,
        ?string $organization = null,
        ?string $language = null,
    ): UserDto {
        return $this->client->post(new UserCreateAction(
            email: $email,
            name: $name,
            password: $password,
            role: $role,
            token: $this->config->getAuthToken(),
            username: $username,
            phone: $phone,
            organization: $organization,
            language: $language,
        ));
    }

    /** 'GET /api/users/:id' */
    public function get(string $id): UserDto
    {
        return $this->client->get(new UserViewAction(id: $id, token: $this->config->getAuthToken()));
    }

    /** 'PATCH /api/users/:id' */
    public function update(UserDto $dto): UserDto
    {
        return $this->client->patch(new UserUpdateAction(user: $dto, token: $this->config->getAuthToken()));
    }

    /** 'PATCH /api/users/:id/email' */
    public function updateEmail(UserDto $dto): UserDto
    {
        return $this->client->patch(new UserUpdateEmailAction(user: $dto, token: $this->config->getAuthToken()));
    }

    /** 'PATCH /api/users/:id/password' */
    public function updatePassword(string $id, string $current, string $new): UserDto
    {
        return $this->client->patch(new UserUpdatePasswordAction(
            userId: $id,
            current: $current,
            new: $new,
            token: $this->config->getAuthToken(),
        ));
    }

    /** 'PATCH /api/users/:id/username' */
    public function updateUsername(UserDto $dto): UserDto
    {
        return $this->client->patch(new UserUpdateUsernameAction(user: $dto, token: $this->config->getAuthToken()));
    }

    /**
     * 'POST /api/users/:id/avatar'.
     *
     * @throws FileExistException
     */
    public function updateAvatar(UserDto $dto, string $file): UserDto
    {
        return $this->client->post(new UserUpdateAvatarAction(
            user: $dto,
            file: $file,
            token: $this->config->getAuthToken(),
        ));
    }

    /** 'DELETE /api/users/:id' */
    public function delete(UserDto $dto): UserDto
    {
        return $this->client->delete(new UserDeleteAction(user: $dto, token: $this->config->getAuthToken()));
    }

    /** 'POST /api/users/:id/api-key' */
    public function createApiKey(string $userId): UserDto
    {
        return $this->client->post(new UserCreateApiKeyAction(
            userId: $userId,
            token: $this->config->getAuthToken(),
        ));
    }

    /**
     * 'POST /api/users/:id/totp/setup'.
     *
     * @return array{secret?: string, provisioningUri?: string}
     */
    public function setupTotp(string $userId, string $currentPassword): array
    {
        return $this->client->post(new UserTotpSetupAction(
            userId: $userId,
            currentPassword: $currentPassword,
            token: $this->config->getAuthToken(),
        ));
    }

    /** 'POST /api/users/:id/totp/enable' */
    public function enableTotp(string $userId, string $currentPassword, string $code): UserDto
    {
        return $this->client->post(new UserTotpEnableAction(
            userId: $userId,
            currentPassword: $currentPassword,
            code: $code,
            token: $this->config->getAuthToken(),
        ));
    }

    /** 'DELETE /api/users/:id/totp' */
    public function disableTotp(string $userId, ?string $currentPassword = null, ?string $code = null): UserDto
    {
        return $this->client->delete(new UserTotpDisableAction(
            userId: $userId,
            token: $this->config->getAuthToken(),
            currentPassword: $currentPassword,
            code: $code,
        ));
    }

    /**
     * 'POST /api/users/:id/totp/recovery-codes'.
     *
     * @return list<string>
     */
    public function regenerateTotpRecoveryCodes(string $userId, string $currentPassword, string $code): array
    {
        return $this->client->post(new UserTotpRecoveryCodesAction(
            userId: $userId,
            currentPassword: $currentPassword,
            code: $code,
            token: $this->config->getAuthToken(),
        ));
    }

    /** 'GET /api/users/:id/trusted-devices' */
    public function listTrustedDevices(string $userId): array
    {
        return $this->client->get(new UserTrustedDevicesAction(
            userId: $userId,
            token: $this->config->getAuthToken(),
        ));
    }

    /** 'DELETE /api/users/:id/trusted-devices/:deviceId' */
    public function deleteTrustedDevice(string $userId, string $deviceId): array
    {
        return $this->client->delete(new UserTrustedDeviceDeleteAction(
            userId: $userId,
            deviceId: $deviceId,
            token: $this->config->getAuthToken(),
        ));
    }
}
