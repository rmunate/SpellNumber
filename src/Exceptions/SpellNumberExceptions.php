<?php

declare(strict_types=1);

namespace Rmunate\Utilities\Exceptions;

use Exception;
use Throwable;

/**
 * An invalid conversion, unsupported locale, or failure reported by PHP Intl.
 */
final class SpellNumberExceptions extends Exception
{
    /**
     * Create a conversion exception with the package documentation link.
     */
    public static function create(string $message, int $code = 0, ?Throwable $previous = null): self
    {
        return new self(
            'Rmunate\Utilities\SpellNumber - '.$message.' See https://rmunate.github.io/SpellNumber/',
            $code,
            $previous
        );
    }
}
