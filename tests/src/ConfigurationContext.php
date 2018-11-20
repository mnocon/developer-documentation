<?php
/**
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
namespace EzSystems\DeveloperDocumentation\Test;


use Behat\Behat\Context\Context;
use Symfony\Component\Yaml\Yaml;

class ConfigurationContext implements Context
{
    private $configurationFilePath;

    public function __construct()
    {
        $this->configurationFilePath = 'app/config/config.yml';
    }

    /**
     * @Given I add imports to
     */
    public function addImportToPlatformYaml()
    {
        $platformConfig = Yaml::parse(file_get_contents($this->configurationFilePath));
        foreach ($platformConfig['imports'] as $import) {
            if ($import['resource'] == $importedFileName) {
                $importAlreadyExists = true;
            }
        }
        if (!isset($importAlreadyExists)) {
            $platformConfig['imports'][] = ['resource' => $importedFileName];
            file_put_contents(
                self::$platformConfigurationFilePath,
                Yaml::dump($platformConfig, 5, 4)
            );
        }
    }
}