<?php

namespace IBroStudio\ComposerCustomDirectoryInstaller;

use Composer\Package\PackageInterface;

class Config
{
    public function __construct(
        public readonly string $directory,
        public readonly ?string $prefix,
        public readonly ?string $suffix
    ) {
    }

    public static function load(PackageInterface $package): Config
    {
        $extra = $package->getExtra();

        if (! array_key_exists('custom-directory-installer', $extra)) {
            throw new \Exception('custom-directory-installer config is missing in extra section from composer.json');
        }

        return new self(...$extra['custom-directory-installer']);
    }
}
