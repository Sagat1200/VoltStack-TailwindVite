<?php

declare(strict_types=1);

namespace VoltStack\TailwindVite\Frontend;

use VoltStack\Framework\Application;
use VoltStack\TailwindVite\Contracts\HotReloadDetectorInterface;

final class HotReloadManager implements HotReloadDetectorInterface
{
    private ?bool $active = null;

    public function __construct(
        private readonly Application $app,
    ) {
    }

    public function isActive(): bool
    {
        if ($this->active !== null) {
            return $this->active;
        }

        $host = (string) $this->app->config('frontend.dev_server.host', '127.0.0.1');
        $port = (int) $this->app->config('frontend.dev_server.port', 5173);
        $timeout = max(0.05, ((int) $this->app->config('frontend.dev_server.timeout_ms', 150)) / 1000);

        $connection = @fsockopen($host, $port, $errorCode, $errorMessage, $timeout);

        if (is_resource($connection)) {
            fclose($connection);

            return $this->active = true;
        }

        return $this->active = false;
    }

    public function clientUrl(): string
    {
        return $this->assetUrl('@vite/client');
    }

    public function assetUrl(string $path): string
    {
        return $this->baseUrl() . ltrim($path, '/');
    }

    private function baseUrl(): string
    {
        $scheme = $this->app->config('frontend.dev_server.https', false) ? 'https' : 'http';
        $host = (string) $this->app->config('frontend.dev_server.host', '127.0.0.1');
        $port = (int) $this->app->config('frontend.dev_server.port', 5173);

        return sprintf('%s://%s:%d/', $scheme, $host, $port);
    }
}
