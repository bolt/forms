<?php

declare(strict_types=1);

namespace Bolt\BoltForms;

use Bolt\Extension\BaseExtension;

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

    public function dump(...$moreVars): void
    {
        if (! $this->getService('kernel')->isDebug() || ! $this->getConfig()->get('debug')['enabled']) {
            return;
        }

        dump(...$moreVars);
    }
}
