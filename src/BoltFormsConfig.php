<?php


namespace Bolt\BoltForms;


use Bolt\Configuration\Config;
use Bolt\Extension\ExtensionRegistry;
use Tightenco\Collect\Support\Collection;

class BoltFormsConfig
{
    /** @var Collection */
    private $config;

    public function __construct(
        ExtensionRegistry $registry,
        Config $boltConfig
    ) {
        $this->registry = $registry;
        $this->boltConfig = $boltConfig;
    }

    public function getConfig(): Collection
    {
        if ($this->config) {
            return $this->config;
        }

        // We get the defaults as baseline, and merge (override) with all the
        // configured Settings
        $this->config = $this->getDefaults()->replaceRecursive($this->getExtension()->getConfig());

        return $this->config;
    }

    private function getExtension()
    {
        return $this->extension = $this->registry->getExtension(Extension::class);
    }

    private function getDefaults(): Collection
    {
        return new Collection([
            'csrf' => false,
            'foo' => 'bar',
        ]);
    }
}