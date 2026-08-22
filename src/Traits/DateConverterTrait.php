<?php

declare(strict_types=1);

namespace Planka\Bridge\Traits;

trait DateConverterTrait
{
    final public function convertToDateTime(?string $date): ?\DateTimeImmutable
    {
        if (null === $date || '' === $date) {
            return null;
        }

        $parsed = \DateTimeImmutable::createFromFormat(\DateTimeInterface::RFC3339_EXTENDED, $date);

        if ($parsed instanceof \DateTimeImmutable) {
            return $parsed;
        }

        try {
            return new \DateTimeImmutable($date);
        } catch (\Exception) {
            return null;
        }
    }

    final public function requireDateTime(?string $date): \DateTimeImmutable
    {
        return $this->convertToDateTime($date) ?? new \DateTimeImmutable();
    }
}
