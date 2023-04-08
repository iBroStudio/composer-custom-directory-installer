<?php

namespace IBroStudio\ComposerCustomDirectoryInstaller;

use Composer\Installer\LibraryInstaller;
use Composer\Package\PackageInterface;

class ComposerCustomDirectoryInstaller extends LibraryInstaller
{
    private array $config = [];

    public function supports($packageType): bool
    {
        return $packageType === 'custom-library';
    }

    /**
     * @throws \Exception
     */
    public function getInstallPath(PackageInterface $package): string
    {
        $this->setConfigFrom($package);

        return $this->getBase() . DIRECTORY_SEPARATOR . $this->getDirectory($package->getPrettyName());
    }

    /**
     * @throws \Exception
     */
    private function setConfigFrom(PackageInterface $package): void
    {
        $extra = $package->getExtra();

        if (! array_key_exists('custom-directory-installer', $extra)) {
            throw new \Exception('custom-directory-installer config is missing in extra section from composer.json');
        }

        $this->config = $extra['custom-directory-installer'];
    }

    public function getBase(): string
    {
        return $this->config['directory'];
    }

    public function getDirectory(string $name): string
    {
        return str_replace(
            [$this->prefix(), $this->suffix()],
            '',
            substr(strstr($name, '/'), 1)
        );
    }

    private function prefix(): ?string
    {
        if (array_key_exists('name', $this->config)
            && array_key_exists('prefix', $this->config['name'])) {
            return $this->config['name']['prefix'];
        }

        return null;
    }

    private function suffix(): ?string
    {
        if (array_key_exists('name', $this->config)
            && array_key_exists('suffix', $this->config['name'])) {
            return $this->config['name']['suffix'];
        }

        return null;
    }
}