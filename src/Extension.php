<?php

declare(strict_types=1);

namespace Bolt\BoltForms;

use Bolt\Extension\BaseExtension;
use Symfony\Component\Routing\Route;

class Extension extends BaseExtension
{
    public function getName(): string
    {
        return 'Boltforms';
    }

    public function initialize(): void
    {
        $this->addTwigNamespace('boltforms');
    }

}
