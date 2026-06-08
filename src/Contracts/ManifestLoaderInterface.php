<?php

declare(strict_types=1);

namespace VoltStack\TailwindVite\Contracts;

interface ManifestLoaderInterface
{
    /**
     * @return array<string, mixed>
     */
    public function load(): array;

    public function has(string $entry): bool;

    /**
     * @return array<string, mixed>
     */
    public function entry(string $entry): array;
}
