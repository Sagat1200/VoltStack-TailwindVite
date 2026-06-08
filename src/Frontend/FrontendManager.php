<?php

declare(strict_types=1);

namespace VoltStack\TailwindVite\Frontend;

use VoltStack\Framework\Application;
use VoltStack\TailwindVite\Contracts\FrontendManagerInterface;
use VoltStack\TailwindVite\Contracts\HotReloadDetectorInterface;
use VoltStack\TailwindVite\Contracts\ManifestLoaderInterface;

final class FrontendManager implements FrontendManagerInterface
{
    public function __construct(
        private readonly ManifestLoaderInterface $manifestLoader,
        private readonly HotReloadDetectorInterface $hotReload,
        private readonly Application $app,
    ) {}

    public function render(string|array|null $entry = null): string
    {
        if (! (bool) $this->app->config('frontend.enabled', true)) {
            return '';
        }

        $entries = $this->normalizeEntries($entry);

        if ($entries === []) {
            return '';
        }

        if ($this->isDevelopment()) {
            return $this->renderDevelopment($entries);
        }

        return $this->renderProduction($entries);
    }

    public function isDevelopment(): bool
    {
        return $this->hotReload->isActive();
    }

    public function isProduction(): bool
    {
        return ! $this->isDevelopment();
    }

    public function manifest(): array
    {
        return $this->manifestLoader->load();
    }

    /**
     * @param array<int, string> $entries
     */
    private function renderDevelopment(array $entries): string
    {
        $tags = [
            sprintf('<script type="module" src="%s"></script>', e($this->hotReload->clientUrl())),
        ];

        foreach ($entries as $entry) {
            $tags[] = sprintf('<script type="module" src="%s"></script>', e($this->hotReload->assetUrl($entry)));
        }

        return implode(PHP_EOL, $tags);
    }

    /**
     * @param array<int, string> $entries
     */
    private function renderProduction(array $entries): string
    {
        $styles = [];
        $scripts = [];
        $visited = [];

        foreach ($entries as $entry) {
            if (! $this->manifestLoader->has($entry)) {
                continue;
            }

            $this->collectEntryAssets($entry, $styles, $scripts, $visited);
        }

        if ($styles === [] && $scripts === []) {
            return '';
        }

        $tags = [];

        foreach (array_keys($styles) as $href) {
            $tags[] = sprintf('<link rel="stylesheet" href="%s">', e($href));
        }

        foreach (array_keys($scripts) as $src) {
            $tags[] = sprintf('<script type="module" src="%s"></script>', e($src));
        }

        return implode(PHP_EOL, $tags);
    }

    /**
     * @param array<string, true> $styles
     * @param array<string, true> $scripts
     * @param array<string, true> $visited
     */
    private function collectEntryAssets(string $entry, array &$styles, array &$scripts, array &$visited): void
    {
        if (isset($visited[$entry])) {
            return;
        }

        $visited[$entry] = true;
        $payload = $this->manifestLoader->entry($entry);

        foreach ($payload['imports'] ?? [] as $import) {
            if (is_string($import) && $this->manifestLoader->has($import)) {
                $this->collectEntryAssets($import, $styles, $scripts, $visited);
            }
        }

        foreach ($payload['css'] ?? [] as $cssFile) {
            if (is_string($cssFile) && $cssFile !== '') {
                $styles[$this->publicAssetUrl($cssFile)] = true;
            }
        }

        $file = $payload['file'] ?? null;

        if (is_string($file) && $file !== '') {
            $scripts[$this->publicAssetUrl($file)] = true;
        }
    }

    private function publicAssetUrl(string $path): string
    {
        $buildUrl = rtrim((string) $this->app->config('frontend.build_url', '/build'), '/');

        return $buildUrl . '/' . ltrim($path, '/');
    }

    /**
     * @return array<int, string>
     */
    private function normalizeEntries(string|array|null $entry): array
    {
        if (is_string($entry)) {
            $entry = trim($entry);

            return $entry === '' ? [] : [$entry];
        }

        if (is_array($entry)) {
            $normalized = [];

            foreach ($entry as $candidate) {
                if (! is_string($candidate)) {
                    continue;
                }

                $candidate = trim($candidate);

                if ($candidate !== '') {
                    $normalized[] = $candidate;
                }
            }

            return array_values(array_unique($normalized));
        }

        $defaultEntry = trim((string) $this->app->config('frontend.input.js', 'resources/js/app.js'));

        return $defaultEntry === '' ? [] : [$defaultEntry];
    }
}
