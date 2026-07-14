<?php

declare(strict_types=1);

namespace VoltStack\TailwindVite\Frontend;

use RuntimeException;
use VoltStack\Framework\Application;
use VoltStack\TailwindVite\Contracts\ManifestLoaderInterface;

final class ManifestManager implements ManifestLoaderInterface
{
    /**
     * @var array<string, mixed>|null
     */
    private ?array $manifest = null;

    private ?string $manifestPath = null;

    private ?int $manifestMTime = null;

    public function __construct(
        private readonly Application $app,
    ) {}

    public function load(): array
    {
        $manifestPath = $this->app->basePath((string) $this->app->config('tailwind-vite.manifest', 'public/build/.vite/manifest.json'));
        clearstatcache(true, $manifestPath);
        $manifestMTime = is_file($manifestPath) ? filemtime($manifestPath) : null;

        if (
            $this->manifest !== null
            && $this->manifestPath === $manifestPath
            && $this->manifestMTime === $manifestMTime
        ) {
            return $this->manifest;
        }

        $this->manifestPath = $manifestPath;
        $this->manifestMTime = $manifestMTime;

        if ($manifestMTime === null) {
            return $this->manifest = [];
        }

        $contents = file_get_contents($manifestPath);

        if ($contents === false) {
            throw new RuntimeException(sprintf('Unable to read the Vite manifest at [%s].', $manifestPath));
        }

        $decoded = json_decode($contents, true);

        if (! is_array($decoded)) {
            throw new RuntimeException(sprintf('The Vite manifest at [%s] does not contain valid JSON.', $manifestPath));
        }

        return $this->manifest = $decoded;
    }

    public function has(string $entry): bool
    {
        return array_key_exists($entry, $this->load());
    }

    public function entry(string $entry): array
    {
        $manifest = $this->load();

        if (! isset($manifest[$entry]) || ! is_array($manifest[$entry])) {
            throw new RuntimeException(sprintf('The Vite manifest entry [%s] could not be found.', $entry));
        }

        return $manifest[$entry];
    }
}