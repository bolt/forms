<?php

declare(strict_types=1);

namespace Bolt\BoltForms;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class TwigExtension extends AbstractExtension
{
    /**
     * Register Twig functions.
     */
    public function getFunctions(): array
    {
        $safe = [
            'is_safe' => ['html'],
        ];

        return [
            new TwigFunction('boltform', [FormRuntime::class, 'run'], $safe),
        ];
    }
}
