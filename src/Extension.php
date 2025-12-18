<?php

declare(strict_types=1);

namespace Bolt\BoltForms;

use Bolt\Extension\BaseExtension;
use Symfony\Component\Filesystem\Filesystem;

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

    public function dump(mixed ...$moreVars): void
    {
        if (! $this->getService('kernel')->isDebug() || ! $this->getConfig()->get('debug')['enabled']) {
            return;
        }

        dump(...$moreVars);
    }

    public function install(): void
    {
        /** @var string $projectDir */
        $projectDir = $this->getContainer()->getParameter('kernel.project_dir');

        $filesystem = new Filesystem();
        $filesystem->mkdir($projectDir . '/config/extensions/bolt-boltforms/');
    }
}
