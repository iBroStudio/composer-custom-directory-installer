<?php

namespace IBroStudio\ComposerCustomDirectoryInstaller;

use Composer\Package\PackageInterface;
use IBroStudio\ComposerCustomDirectoryInstaller\Exceptions\MissingConfigException;

class Config
{
    public function __construct(
        public readonly string $directory,
        public readonly ?string $prefix = null,
        public readonly ?string $suffix = null
    ) {}

    /**
     * @throws MissingConfigException
     */
    public static function load(PackageInterface $package): Config
    {
        $extra = $package->getExtra();

        if (! array_key_exists('custom-directory-installer', $extra)) {
            throw new MissingConfigException();
        }

        return new self(...$extra['custom-directory-installer']);
    }
}
