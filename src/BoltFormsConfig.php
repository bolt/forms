<?php

declare(strict_types=1);

namespace Bolt\BoltForms;

use Bolt\Configuration\Config;
use Bolt\Extension\ExtensionInterface;
use Bolt\Extension\ExtensionRegistry;
use Tightenco\Collect\Support\Collection;

class BoltFormsConfig
{
    /** @var ExtensionRegistry */
    private $registry;

    /** @var Config */
    private $boltConfig;

    /** @var Collection */
    private $config = null;

    /** @var ExtensionInterface */
    private $extension = null;

    public function __construct(ExtensionRegistry $registry, Config $boltConfig)
    {
        $this->registry = $registry;
        $this->boltConfig = $boltConfig;
    }

    public function getConfig(): Collection
    {
        if ($this->config === null) {
            // We get the defaults as baseline, and merge (override) with all the
            // configured Settings
            $this->config = $this->getDefaults()->replaceRecursive($this->getExtension()->getConfig());
        }

        return $this->config;
    }

    public function getBoltConfig(): Config
    {
        return $this->boltConfig;
    }

    private function getExtension(): ?ExtensionInterface
    {
        if ($this->extension === null) {
            $this->extension = $this->registry->getExtension(Extension::class);
        }

        return $this->extension;
    }

    private function getDefaults(): Collection
    {
        return new Collection([
            'csrf' => false,
            'foo' => 'bar',
        ]);
    }
}
