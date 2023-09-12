<?php

namespace Rmunate\Utilities\Exceptions;

use Exception;
use Throwable;

/**
 * The SpellNumberExceptions class extends Exception and provides custom exception handling for the SpellNumber library.
 */
final class SpellNumberExceptions extends Exception
{
    /**
     * Static method to throw the exception from the calling class.
     *
     * @param string         $message  The exception message.
     * @param int            $code     The exception code (optional).
     * @param Throwable|null $previous The previous exception (optional).
     *
     * @throws SpellNumberExceptions Changed "CustomException" to "SpellNumberExceptions".
     *
     * @return SpellNumberExceptions An instance of SpellNumberExceptions.
     */
    public static function create($message, $code = 0, Throwable $previous = null)
    {
        return new self('Rmunate\Utilities\SpellNumber::class - '.$message, $code, $previous);
    }
}
