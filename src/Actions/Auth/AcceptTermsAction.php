<?php

declare(strict_types=1);

namespace Planka\Bridge\Actions\Auth;

use Planka\Bridge\Contracts\Actions\ActionInterface;

final class AcceptTermsAction implements ActionInterface
{
    public function __construct(
        private readonly string $pendingToken,
        private readonly string $signature,
        private readonly ?string $initialLanguage = null,
    ) {}

    public function url(): string
    {
        return 'api/access-tokens/accept-terms';
    }

    public function getOptions(): array
    {
        $json = [
            'pendingToken' => $this->pendingToken,
            'signature' => $this->signature,
        ];

        if (null !== $this->initialLanguage) {
            $json['initialLanguage'] = $this->initialLanguage;
        }

        return [
            'json' => $json,
        ];
    }
}
