<?php

namespace Fine\Composer\ModuleInstaller;

use Composer\Package\PackageInterface;
use Composer\Installer\LibraryInstaller;

class Installer extends LibraryInstaller
{
    /**
     * {@inheritDoc}
     */
    public function getInstallPath(PackageInterface $package)
    {
        list($vendor, $name) = explode('/', $package->getPrettyName());
        return "module/$name";
    }

    /**
     * {@inheritDoc}
     */
    public function supports($packageType)
    {
        return 'fine-module' === $packageType;
    }
}
