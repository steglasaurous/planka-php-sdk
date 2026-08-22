<?php

declare(strict_types=1);

namespace Planka\Bridge\Views\Dto\Common;

use Planka\Bridge\Contracts\Dto\OutputDtoInterface;

class TermsDto implements OutputDtoInterface
{
    public function __construct(
        public readonly string $language,
        public readonly string $content,
        public readonly string $signature,
    ) {}
}
