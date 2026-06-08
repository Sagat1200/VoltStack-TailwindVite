<?php

declare(strict_types=1);

namespace VoltStack\TailwindVite\Directives;

use Quantum\View\Directives\Contracts\DirectiveContract;

final class FrontendDirective implements DirectiveContract
{
    public function compile(?string $expression = null): string
    {
        $expression = trim((string) $expression);

        if ($expression === '') {
            return '<?php echo tailwind_vite()->render(); ?>';
        }

        return sprintf('<?php echo tailwind_vite()->render(%s); ?>', $expression);
    }
}
