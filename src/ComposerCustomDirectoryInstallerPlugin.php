<?php

namespace IBroStudio\ComposerCustomDirectoryInstaller;

use Composer\Composer;
use Composer\IO\IOInterface;
use Composer\Plugin\PluginInterface;

class ComposerCustomDirectoryInstallerPlugin implements PluginInterface
{
    public function activate(Composer $composer, IOInterface $io): void
    {
        $installer = new ComposerCustomDirectoryInstaller($io, $composer);

        $composer->getInstallationManager()->addInstaller($installer);
    }

    public function deactivate(Composer $composer, IOInterface $io): void
    {
    }

    public function uninstall(Composer $composer, IOInterface $io): void
    {
    }
}
