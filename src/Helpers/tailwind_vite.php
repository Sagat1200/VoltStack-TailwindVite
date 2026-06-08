<?php

declare(strict_types=1);

use VoltStack\TailwindVite\Contracts\FrontendManagerInterface;

if (! function_exists('tailwind_vite')) {
    function tailwind_vite(): FrontendManagerInterface
    {
        /** @var FrontendManagerInterface $manager */
        $manager = app(FrontendManagerInterface::class);

        return $manager;
    }
}
