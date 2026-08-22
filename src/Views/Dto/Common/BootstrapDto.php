<?php

declare(strict_types=1);

namespace Planka\Bridge\Views\Dto\Common;

use Planka\Bridge\Contracts\Dto\OutputDtoInterface;

class BootstrapDto implements OutputDtoInterface
{
    /**
     * @param list<string>|null $termsLanguages
     */
    public function __construct(
        public readonly string $version,
        public readonly ?int $activeUsersLimit,
        public readonly ?string $customerPanelUrl,
        public readonly ?array $termsLanguages,
    ) {}
}
