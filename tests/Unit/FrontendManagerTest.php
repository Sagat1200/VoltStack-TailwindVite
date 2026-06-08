<?php

declare(strict_types=1);

namespace VoltStack\TailwindVite\Tests\Unit;

use PHPUnit\Framework\TestCase;
use Quantum\Config\ConfigRepository;
use VoltStack\Framework\Application;
use VoltStack\TailwindVite\Contracts\HotReloadDetectorInterface;
use VoltStack\TailwindVite\Contracts\ManifestLoaderInterface;
use VoltStack\TailwindVite\Frontend\FrontendManager;

final class FrontendManagerTest extends TestCase
{
    public function test_it_renders_hot_reload_tags_in_development(): void
    {
        $app = new Application(sys_get_temp_dir());
        $app->make(ConfigRepository::class)->set('frontend.input.js', 'resources/js/app.js');

        $manager = new FrontendManager(
            new FrontendManagerManifestStub([]),
            new FrontendManagerHotReloadStub(true),
            $app,
        );

        $html = $manager->render();

        self::assertStringContainsString('@vite/client', $html);
        self::assertStringContainsString('resources/js/app.js', $html);
    }

    public function test_it_renders_manifest_assets_in_production(): void
    {
        $app = new Application(sys_get_temp_dir());
        $config = $app->make(ConfigRepository::class);
        $config->set('frontend.input.js', 'resources/js/app.js');
        $config->set('frontend.build_url', '/build');

        $manager = new FrontendManager(
            new FrontendManagerManifestStub([
                'resources/js/app.js' => [
                    'file' => 'assets/app.123.js',
                    'css' => ['assets/app.123.css'],
                    'isEntry' => true,
                ],
            ]),
            new FrontendManagerHotReloadStub(false),
            $app,
        );

        $html = $manager->render();

        self::assertStringContainsString('/build/assets/app.123.css', $html);
        self::assertStringContainsString('/build/assets/app.123.js', $html);
    }
}

final class FrontendManagerManifestStub implements ManifestLoaderInterface
{
    /**
     * @param array<string, array<string, mixed>> $manifest
     */
    public function __construct(
        private readonly array $manifest,
    ) {
    }

    public function load(): array
    {
        return $this->manifest;
    }

    public function has(string $entry): bool
    {
        return isset($this->manifest[$entry]);
    }

    public function entry(string $entry): array
    {
        return $this->manifest[$entry];
    }
}

final class FrontendManagerHotReloadStub implements HotReloadDetectorInterface
{
    public function __construct(
        private readonly bool $active,
    ) {
    }

    public function isActive(): bool
    {
        return $this->active;
    }

    public function clientUrl(): string
    {
        return 'http://127.0.0.1:5173/@vite/client';
    }

    public function assetUrl(string $path): string
    {
        return 'http://127.0.0.1:5173/' . ltrim($path, '/');
    }
}
