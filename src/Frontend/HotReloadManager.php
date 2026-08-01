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
    ) {}

    public function isActive(): bool
    {
        if ($this->active !== null) {
            return $this->active;
        }

        if (
            defined('PHPUNIT_COMPOSER_INSTALL') ||
            defined('PHPUNIT_VERSION') ||
            $this->app->environment() === 'testing'
        ) {
            return $this->active = false;
        }

        $host = (string) $this->app->config('tailwind-vite.dev_server.host', '127.0.0.1');
        $port = (int) $this->app->config('tailwind-vite.dev_server.port', 5173);
        $timeout = max(0.05, ((int) $this->app->config('tailwind-vite.dev_server.timeout_ms', 150)) / 1000);

        $connection = @fsockopen($host, $port, $errorCode, $errorMessage, $timeout);

        if (is_resource($connection)) {
            fclose($connection);

            $context = stream_context_create([
                'http' => [
                    'method' => 'GET',
                    'timeout' => $timeout,
                    'ignore_errors' => true,
                    'header' => "Accept: */*\r\n",
                ],
                'ssl' => [
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                ],
            ]);

            $client = @file_get_contents($this->clientUrl(), false, $context);

            if (is_string($client) && str_contains($client, 'createHotContext')) {
                return $this->active = true;
            }

            return $this->active = false;
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
        $scheme = $this->app->config('tailwind-vite.dev_server.https', false) ? 'https' : 'http';
        $host = (string) $this->app->config('tailwind-vite.dev_server.host', '127.0.0.1');
        $port = (int) $this->app->config('tailwind-vite.dev_server.port', 5173);

        return sprintf('%s://%s:%d/', $scheme, $host, $port);
    }
}
