<?php

use Composer\Composer;
use Composer\Downloader\DownloadManager;
use Composer\IO\IOInterface;
use IBroStudio\ComposerCustomDirectoryInstaller\ComposerCustomDirectoryInstaller;
use IBroStudio\ComposerCustomDirectoryInstaller\Exceptions\MissingConfigException;

beforeEach(function () {
    $this->io = Mockery::mock(IOInterface::class);
    $this->composer = Mockery::mock(Composer::class);
    $downloadManager = Mockery::mock(DownloadManager::class);
    $config = Mockery::mock(\Composer\Config::class);

    $this->composer->allows([
        'getPackage' => $this->composer,
        'getDownloadManager' => $downloadManager,
        'getConfig' => $config,
        'get' => $this->composer,
    ])->shouldReceive('getExtra')->byDefault();

    $config->allows([
        'get' => '',
    ]);

    $this->test = new ComposerCustomDirectoryInstaller(
        $this->io, $this->composer
    );
});

it('supports custom-library type only', function () {
    expect($this->test->supports('module'))->toBeFalse();
    expect($this->test->supports('custom-library'))->toBeTrue();
});

it('throws exception if config is missing', function () {
    $package = getMockPackage('vendor/name-module');
    $package->shouldReceive('getExtra')
        ->getMock();
    echo $this->test->getInstallPath($package);
})->throws(MissingConfigException::class);

it('can return custom install path', function () {
    $package = getMockPackage('vendor/name-module');
    $package->shouldReceive('getExtra')
        ->andReturn(['custom-directory-installer' => ['directory' => 'packages']])
        ->getMock();
    expect($this->test->getInstallPath($package))->toBe('packages/name-module');
});

it('can filter in-built prefixes', function (string $prefix) {
    $package = getMockPackage("vendor/{$prefix}-name-module");
    $package->shouldReceive('getExtra')
        ->andReturn(['custom-directory-installer' => ['directory' => 'packages']])
        ->getMock();
    expect($this->test->getInstallPath($package))->toBe('packages/name-module');
})->with(['laravel', 'filament']);

it('can filter custom prefix and suffix', function () {
    $package = getMockPackage('vendor/platform-name-module');
    $package->shouldReceive('getExtra')
        ->andReturn([
            'custom-directory-installer' => [
                'directory' => 'packages',
                'prefix' => 'platform-',
                'suffix' => '-module',
            ],
        ])
        ->getMock();
    expect($this->test->getInstallPath($package))->toBe('packages/name');
});
