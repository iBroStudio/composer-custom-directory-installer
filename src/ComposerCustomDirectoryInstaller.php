<?php

namespace IBroStudio\ComposerCustomDirectoryInstaller;

use Composer\Installer\LibraryInstaller;
use Composer\Package\PackageInterface;

class ComposerCustomDirectoryInstaller extends LibraryInstaller
{
    private Config $config;

    public function supports(string $packageType): bool
    {
        return $packageType === 'custom-library';
    }

    /**
     * @throws \Exception
     */
    public function getInstallPath(PackageInterface $package): string
    {
        $this->config = Config::load($package);

        return $this->getBase().DIRECTORY_SEPARATOR.$this->getDirectory($package->getPrettyName());
    }

    public function getBase(): string
    {
        return $this->config->directory;
    }

    public function getDirectory(string $name): string
    {
        return str_replace(
            [
                $this->config->prefix,
                $this->config->suffix,
                'laravel-',
                'filament-',
            ],
            '',
            substr((string) strstr($name, '/'), 1)
        );
    }
}
