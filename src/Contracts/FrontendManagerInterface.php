<?php

declare(strict_types=1);

namespace VoltStack\TailwindVite\Contracts;

interface FrontendManagerInterface
{
    public function render(string|array|null $entry = null): string;

    public function isDevelopment(): bool;

    public function isProduction(): bool;

    /**
     * @return array<string, mixed>
     */
    public function manifest(): array;
}
