<?php

declare(strict_types=1);

namespace Bolt\BoltForms;

use Bolt\Configuration\Config;
use Bolt\Extension\ExtensionInterface;
use Bolt\Extension\ExtensionRegistry;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Yaml\Yaml;
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

            /** @var Extension $extension */
            $extension = $this->getExtension();
            $this->config = $this->getDefaults()->replaceRecursive($this->getAdditionalFormConfigs())->replaceRecursive($extension->getConfig());
        }

        return $this->config;
    }

    public function getBoltConfig(): Config
    {
        return $this->boltConfig;
    }

    public function getExtension(): ?ExtensionInterface
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

    private function getAdditionalFormConfigs(): array
    {
        $configPath = explode('.yaml', $this->getExtension()->getConfigFilenames()['main'])[0] . DIRECTORY_SEPARATOR;

        if (!is_dir($configPath)) {
            return [];
        }

        $finder = new Finder();

        $finder->files()->in($configPath)->name('*.yaml');

        if (! $finder->hasResults()) {
            return [];
        }

        $result = [];

        foreach ($finder as $file) {
            $formName = basename($file->getBasename(), '.yaml');

            $result[$formName] = Yaml::parseFile($file->getRealPath());
        }

        return $result;
    }
}
