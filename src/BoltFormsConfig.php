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
        $mainConfigPath = $this->getExtension()->getConfigFilenames()['main'];
        $boltFormsRoot = explode('.yaml', $mainConfigPath)[0];
        $extrasConfigPath = $boltFormsRoot . DIRECTORY_SEPARATOR;
        
        $global_aliases = file_get_contents($boltFormsRoot.'-global.yaml');
        
        if (is_null($global_aliases) ) {$global_aliases = '';}
        $finder = new Finder();
    
        $finder->files()->in($extrasConfigPath)->name('*.yaml');
    
        if (! $finder->hasResults()) {
            return [];
        }
        $result = [];
    
        foreach ($finder as $file) {
            $formName = basename($file->getBasename(), '.yaml');
            $ymlContents = '';
            
            if (is_file($file->getRealPath()) && is_readable($file->getRealPath())){
                $ymlContents = file_get_contents($file->getRealPath());
            }
            try {
                $result[$formName] = Yaml::parse($global_aliases . $ymlContents);
            } catch (ParseException $e) {
                $e;
                throw new ParseException(sprintf('Error detected on form %s: %s', $formName, $e->getMessage()));
            }
            
            unset($result[$formName]['global_aliases']);
        }
    
        return $result;
    }
}
