<?php

namespace Fine\Composer\ModuleInstaller;

use Composer\Package\PackageInterface;
use Composer\Installer\LibraryInstaller;

class Installer extends LibraryInstaller
{

    public function supports($packageType)
    {
        return 'fine-module' === $packageType;
    }

    public function getInstallPath(PackageInterface $package)
    {
        $extra = $package->getExtra();

        if (
            !array_key_exists('fine-module', $extra)
            || !array_key_exists('name', $extra['fine-module'])
            || strlen($extra['fine-module']['name']) == 0
        ) {
            throw new \InvalidArgumentException('Unable to install fine module. '
                                               .'Module name not set in composer.json[extra][fine-module][name]');
        }

        return "module/{$extra['fine-module']['name']}";
    }

    public function install(InstalledRepositoryInterface $repo, PackageInterface $package)
    {
        parent::install($repo, $package);

        $config = require "config/module.php";
        
        $config[$package->getExtra()['fine-module']['name']] = $package->getExtra()['fine-module']['class'];

        file_put_contents("config/module.php", "<?php\n\nreturn " . var_export($config, true) . ";\n");

    }
}
