<?php

declare(strict_types=1);

namespace VoltStack\TailwindVite\Commands;

use Quantum\Console\Command;
use Quantum\Console\Input;
use Quantum\Console\Output;
use RuntimeException;

final class FrontendInstallCommand extends Command
{
    public function name(): string
    {
        return 'frontend:install';
    }

    public function description(): string
    {
        return 'Publica la configuracion base de Tailwind CSS y Vite para VoltStack.';
    }

    public function usage(): string
    {
        return 'frontend:install [--force]';
    }

    public function category(): string
    {
        return 'Frontend';
    }

    public function optionsHelp(): array
    {
        return [
            '--force' => 'Sobrescribe archivos existentes generados por el instalador.',
        ];
    }

    public function handle(Input $input, Output $output): int
    {
        $force = $input->hasOption('force');
        $published = [];
        $skipped = [];

        foreach ($this->publishableFiles() as $target => $stub) {
            $result = $this->publish($target, $stub, $force);

            if ($result === 'published') {
                $published[] = $target;
                continue;
            }

            $skipped[] = $target;
        }

        $this->ensureDirectory($this->basePath . DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR . 'build');

        $output->writeln('Frontend Tailwind + Vite instalado correctamente.');

        if ($published !== []) {
            $output->writeln();
            $output->writeln('Archivos publicados:');

            foreach ($published as $file) {
                $output->writeln(sprintf('  - %s', $file));
            }
        }

        if ($skipped !== []) {
            $output->writeln();
            $output->writeln('Archivos omitidos:');

            foreach ($skipped as $file) {
                $output->writeln(sprintf('  - %s', $file));
            }
        }

        $output->writeln();
        $output->writeln('Siguientes pasos:');
        $output->writeln('  1. npm install');
        $output->writeln('  2. npm run dev');
        $output->writeln('  3. Agrega @frontend dentro de tu layout principal.');

        return 0;
    }

    /**
     * @return array<string, string>
     */
    private function publishableFiles(): array
    {
        return [
            'config/frontend.php' => 'frontend.stub.php',
            'package.json' => 'package.stub.json',
            'vite.config.js' => 'vite.config.stub.js',
            'postcss.config.js' => 'postcss.config.stub.js',
            'tailwind.config.js' => 'tailwind.config.stub.js',
            'resources/css/app.css' => 'app.stub.css',
            'resources/js/app.js' => 'app.stub.js',
        ];
    }

    private function publish(string $target, string $stub, bool $force): string
    {
        $targetPath = $this->basePath . DIRECTORY_SEPARATOR . str_replace('/', DIRECTORY_SEPARATOR, $target);

        if (is_file($targetPath) && ! $force) {
            return 'skipped';
        }

        $this->ensureDirectory(dirname($targetPath));

        $contents = $this->stub($stub);

        if (file_put_contents($targetPath, $contents) === false) {
            throw new RuntimeException(sprintf('No se pudo escribir el archivo [%s].', $targetPath));
        }

        return 'published';
    }

    private function ensureDirectory(string $directory): void
    {
        if (! is_dir($directory) && ! mkdir($directory, 0777, true) && ! is_dir($directory)) {
            throw new RuntimeException(sprintf('No se pudo crear el directorio [%s].', $directory));
        }
    }

    private function stub(string $name): string
    {
        $path = dirname(__DIR__, 2) . DIRECTORY_SEPARATOR . 'stubs' . DIRECTORY_SEPARATOR . $name;

        if (! is_file($path)) {
            throw new RuntimeException(sprintf('El stub [%s] no existe.', $path));
        }

        $contents = file_get_contents($path);

        if ($contents === false) {
            throw new RuntimeException(sprintf('No se pudo leer el stub [%s].', $path));
        }

        return $contents;
    }
}
