<?php

declare(strict_types=1);

namespace VoltStack\TailwindVite\Providers;

use Quantum\Config\ConfigRepository;
use Quantum\View\Directives\DirectiveRegistry;
use VoltStack\Framework\ServiceProvider;
use VoltStack\TailwindVite\Commands\FrontendInstallCommand;
use VoltStack\TailwindVite\Contracts\FrontendManagerInterface;
use VoltStack\TailwindVite\Contracts\HotReloadDetectorInterface;
use VoltStack\TailwindVite\Contracts\ManifestLoaderInterface;
use VoltStack\TailwindVite\Directives\FrontendDirective;
use VoltStack\TailwindVite\Frontend\FrontendManager;
use VoltStack\TailwindVite\Frontend\HotReloadManager;
use VoltStack\TailwindVite\Frontend\ManifestManager;

final class TailwindViteServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeDefaultConfiguration();

        $this->app->singleton(ManifestLoaderInterface::class, fn() => new ManifestManager($this->app));
        $this->app->singleton(HotReloadDetectorInterface::class, fn() => new HotReloadManager($this->app));
        $this->app->singleton(FrontendManagerInterface::class, fn() => new FrontendManager(
            $this->app->make(ManifestLoaderInterface::class),
            $this->app->make(HotReloadDetectorInterface::class),
            $this->app,
        ));
    }

    public function boot(): void
    {
        $registry = $this->app->make(DirectiveRegistry::class);

        if (! $registry->has('tailwind-vite')) {
            $registry->register('tailwind-vite', new FrontendDirective());
        }
    }

    public function commands(): array
    {
        return [
            FrontendInstallCommand::class,
        ];
    }

    private function mergeDefaultConfiguration(): void
    {
        /** @var ConfigRepository $config */
        $config = $this->app->make(ConfigRepository::class);
        $existing = $config->get('tailwind-vite', []);
        $legacy = $config->get('frontend', []);

        if (! is_array($existing)) {
            $existing = [];
        }

        if (! is_array($legacy)) {
            $legacy = [];
        }

        $merged = array_replace_recursive($this->defaultConfiguration(), $legacy, $existing);

        $config->set('tailwind-vite', $merged);
        $config->set('frontend', $merged);
    }

    /**
     * @return array<string, mixed>
     */
    private function defaultConfiguration(): array
    {
        return [
            'enabled' => true,
            'dev_server' => [
                'host' => '127.0.0.1',
                'port' => 5173,
                'https' => false,
                'timeout_ms' => 150,
            ],
            'input' => [
                'js' => 'resources/js/app.js',
                'css' => 'resources/css/app.css',
            ],
            'build_directory' => 'public/build',
            'build_url' => '/build',
            'manifest' => 'public/build/.vite/manifest.json',
        ];
    }
}
