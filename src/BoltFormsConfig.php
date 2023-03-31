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
        
        // Share global_aliases with other configs
        $defaultConfig;
        $global_aliases;
        
        try {
            $defaultConfig  = file_get_contents($boltFormsRoot.'.yaml');
        }
        catch (ParseException $e) {
            throw new ParseException(sprintf('Default BoltForm Config Not Found'));
        }
        
        $global_aliases = $this->getFormGlobals($defaultConfig);        
        
        $finder = new Finder();
        $finder->files()->in($extrasConfigPath)->name('*.yaml');
        
        // Exit if no sub_files str
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
    
    private function getFormGlobals(string $defaultFormContents): string
    {
        $start = strpos($defaultFormContents, 'global_aliases');
        
        if ($start === false) return '';
        
        $end;
        $commented_out;
        
        //Check if commented out
        if ($start === 0):
            $commented_out = false;
        else:
            // Check to see if a disabled through commenting (previous 5 char)
            $rewind_check_start_pos = ($start > 5)? $start - 5 : 0;
            $scan_str = substr($defaultFormContents,$rewind_check_start_pos, $start);
            
            $comment_found = strpos($scan_str, '#'.-1); //Note: actually a position, not a bool, reverse searched
            $commented_out = ($comment_found !== false && $comment_found < strpos($scan_str, "\n".-1)); //ie: # found and no inbetween \n
        endif;
        
        if ($commented_out) return '';
        
        // This is used to find the first instance of a line which starts with neither a whitespace or comment (ie the end of the global aliases, if starting just after the g (start + 1))
        preg_match("/^[^\s\#]/m", $defaultFormContents."", $matches, PREG_OFFSET_CAPTURE, $start+1);
        if (sizeof($matches) == 0) return '';
        
        $end = $matches[0][1];
        $rt_str = substr($defaultFormContents,$start,$end);
        return $rt_str;      
    }
}
