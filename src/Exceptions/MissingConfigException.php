<?php

namespace IBroStudio\ComposerCustomDirectoryInstaller\Exceptions;

use Exception;
use Throwable;

class MissingConfigException extends Exception
{
    public function __construct(
        string $message = 'custom-directory-installer config is missing in extra section from composer.json',
        int $code = 0,
        ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
