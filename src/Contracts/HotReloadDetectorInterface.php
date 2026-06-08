<?php

declare(strict_types=1);

namespace VoltStack\TailwindVite\Contracts;

interface HotReloadDetectorInterface
{
    public function isActive(): bool;

    public function clientUrl(): string;

    public function assetUrl(string $path): string;
}
