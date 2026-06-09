<?php

declare(strict_types=1);

namespace VoltStack\TailwindVite\Tests\Unit;

use PHPUnit\Framework\TestCase;
use Quantum\Config\ConfigRepository;
use VoltStack\Framework\Application;
use VoltStack\TailwindVite\Frontend\ManifestManager;

final class ManifestManagerTest extends TestCase
{
    private string $basePath;

    protected function setUp(): void
    {
        parent::setUp();

        $this->basePath = sys_get_temp_dir() . DIRECTORY_SEPARATOR . 'voltstack-tailwind-vite-manifest-' . uniqid('', true);
        mkdir($this->basePath . DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR . 'build' . DIRECTORY_SEPARATOR . '.vite', 0777, true);
    }

    protected function tearDown(): void
    {
        $manifestPath = $this->basePath . DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR . 'build' . DIRECTORY_SEPARATOR . '.vite' . DIRECTORY_SEPARATOR . 'manifest.json';
        $viteDirectory = dirname($manifestPath);
        $buildDirectory = dirname($viteDirectory);
        $publicDirectory = dirname($buildDirectory);

        if (is_file($manifestPath)) {
            unlink($manifestPath);
        }

        if (is_dir($viteDirectory)) {
            rmdir($viteDirectory);
        }

        if (is_dir($buildDirectory)) {
            rmdir($buildDirectory);
        }

        if (is_dir($publicDirectory)) {
            rmdir($publicDirectory);
        }

        if (is_dir($this->basePath)) {
            rmdir($this->basePath);
        }

        parent::tearDown();
    }

    public function test_it_loads_a_vite_manifest_from_the_configured_path(): void
    {
        file_put_contents(
            $this->basePath . DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR . 'build' . DIRECTORY_SEPARATOR . '.vite' . DIRECTORY_SEPARATOR . 'manifest.json',
            json_encode([
                'resources/js/app.js' => [
                    'file' => 'assets/app.123.js',
                    'css' => ['assets/app.123.css'],
                    'isEntry' => true,
                ],
            ], JSON_THROW_ON_ERROR)
        );

        $app = new Application($this->basePath);
        $app->make(ConfigRepository::class)->set('tailwind-vite.manifest', 'public/build/.vite/manifest.json');
        $manager = new ManifestManager($app);

        self::assertTrue($manager->has('resources/js/app.js'));
        self::assertSame('assets/app.123.js', $manager->entry('resources/js/app.js')['file']);
    }
}
