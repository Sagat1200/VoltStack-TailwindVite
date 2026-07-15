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
        if (! (bool) $this->app->config('tailwind-vite.enabled', true)) {
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
            sprintf(
                '<script type="module" src="%s" data-volt-head-key="%s"></script>',
                e($this->hotReload->clientUrl()),
                e('vite-client'),
            ),
        ];

        foreach ($entries as $entry) {
            $tags[] = sprintf(
                '<script type="module" src="%s" data-volt-head-key="%s"></script>',
                e($this->hotReload->assetUrl($entry)),
                e($this->headKey('dev-script', $entry)),
            );
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
        $modulePreloads = [];
        $visited = [];

        foreach ($entries as $entry) {
            if (! $this->manifestLoader->has($entry)) {
                continue;
            }

            $this->collectEntryAssets($entry, $styles, $scripts, $modulePreloads, $visited, true);
        }

        if ($styles === [] && $scripts === [] && $modulePreloads === []) {
            return '';
        }

        $tags = [];

        foreach (array_keys($modulePreloads) as $href) {
            $tags[] = sprintf(
                '<link rel="modulepreload" href="%s" crossorigin data-volt-head-key="%s">',
                e($href),
                e($this->headKey('modulepreload', $href)),
            );
        }

        foreach (array_keys($styles) as $href) {
            $tags[] = sprintf(
                '<link rel="stylesheet" href="%s" data-volt-head-key="%s">',
                e($href),
                e($this->headKey('style', $href)),
            );
        }

        foreach (array_keys($scripts) as $src) {
            $tags[] = sprintf(
                '<script type="module" src="%s" data-volt-head-key="%s"></script>',
                e($src),
                e($this->headKey('script', $src)),
            );
        }

        return implode(PHP_EOL, $tags);
    }

    /**
     * @param array<string, true> $styles
     * @param array<string, true> $scripts
     * @param array<string, true> $modulePreloads
     * @param array<string, true> $visited
     */
    private function collectEntryAssets(string $entry, array &$styles, array &$scripts, array &$modulePreloads, array &$visited, bool $isRoot): void
    {
        if (isset($visited[$entry])) {
            if ($isRoot) {
                $payload = $this->manifestLoader->entry($entry);

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

            return;
        }

        $visited[$entry] = true;
        $payload = $this->manifestLoader->entry($entry);

        foreach ($payload['imports'] ?? [] as $import) {
            if (is_string($import) && $this->manifestLoader->has($import)) {
                $this->collectEntryAssets($import, $styles, $scripts, $modulePreloads, $visited, false);
            }
        }

        foreach ($payload['css'] ?? [] as $cssFile) {
            if (is_string($cssFile) && $cssFile !== '') {
                $styles[$this->publicAssetUrl($cssFile)] = true;
            }
        }

        $file = $payload['file'] ?? null;

        if (is_string($file) && $file !== '') {
            $url = $this->publicAssetUrl($file);

            if ($isRoot) {
                $scripts[$url] = true;
            } else {
                $modulePreloads[$url] = true;
            }
        }
    }

    private function publicAssetUrl(string $path): string
    {
        $buildUrl = rtrim((string) $this->app->config('tailwind-vite.build_url', '/build'), '/');

        return $buildUrl . '/' . ltrim($path, '/');
    }

    private function headKey(string $prefix, string $value): string
    {
        return $prefix . ':' . sha1($value);
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

        $defaultEntry = trim((string) $this->app->config('tailwind-vite.input.js', 'resources/js/app.js'));

        return $defaultEntry === '' ? [] : [$defaultEntry];
    }
}