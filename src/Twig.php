<?php

declare(strict_types=1);

namespace Bolt\BoltForms;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class Twig extends AbstractExtension
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
            new TwigFunction('rot13', [$this, 'rot13'], $safe),
        ];
    }

    /**
     * Register Twig filters.
     */
    public function getFilters(): array
    {
        $safe = [
            'is_safe' => ['html'],
        ];

        return [
            new TwigFilter('rot13', [$this, 'rot13'], $safe),
        ];
    }

    public function rot13($string): string
    {
        return str_rot13($string);
    }
}
