<?php

declare(strict_types=1);

namespace VoltStack\TailwindVite\Tests\Feature;

use PHPUnit\Framework\TestCase;
use Quantum\Console\Input;
use Quantum\Console\Output;
use VoltStack\TailwindVite\Commands\FrontendInstallCommand;

final class FrontendInstallCommandTest extends TestCase
{
    private string $basePath;

    protected function setUp(): void
    {
        parent::setUp();

        $this->basePath = sys_get_temp_dir() . DIRECTORY_SEPARATOR . 'voltstack-tailwind-vite-install-' . uniqid('', true);
        mkdir($this->basePath, 0777, true);
    }

    protected function tearDown(): void
    {
        $this->deleteDirectory($this->basePath);

        parent::tearDown();
    }

    public function test_it_publishes_the_frontend_scaffold_files(): void
    {
        $command = new FrontendInstallCommand($this->basePath);
        $output = new Output();

        $exitCode = $command->handle(
            Input::fromArgv(['volt', 'frontend:install']),
            $output,
        );

        self::assertSame(0, $exitCode);
        self::assertFileExists($this->basePath . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'tailwind-vite.php');
        self::assertFileExists($this->basePath . DIRECTORY_SEPARATOR . 'vite.config.js');
        self::assertFileExists($this->basePath . DIRECTORY_SEPARATOR . 'resources' . DIRECTORY_SEPARATOR . 'css' . DIRECTORY_SEPARATOR . 'app.css');
        self::assertFileExists($this->basePath . DIRECTORY_SEPARATOR . 'resources' . DIRECTORY_SEPARATOR . 'js' . DIRECTORY_SEPARATOR . 'app.js');
        self::assertStringContainsString('Frontend Tailwind + Vite instalado correctamente.', $output->stdout());
    }

    private function deleteDirectory(string $directory): void
    {
        if (! is_dir($directory)) {
            return;
        }

        $items = scandir($directory);

        if ($items === false) {
            return;
        }

        foreach ($items as $item) {
            if ($item === '.' || $item === '..') {
                continue;
            }

            $path = $directory . DIRECTORY_SEPARATOR . $item;

            if (is_dir($path)) {
                $this->deleteDirectory($path);
                continue;
            }

            unlink($path);
        }

        rmdir($directory);
    }
}
