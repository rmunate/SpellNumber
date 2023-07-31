<?php

namespace Rmunate\Utilities\Exceptions;

use Exception;
use Throwable;

class SpellNumberExceptions extends Exception
{
    /**
     * Método estático para lanzar la excepción desde la clase donde se llame.
     *
     * @param string $message El mensaje de la excepción.
     * @param int $code El código de la excepción (opcional).
     * @param Throwable|null $previous La excepción anterior (opcional).
     * @throws SpellNumberExceptions Cambio "CustomException" a "SpellNumberExceptions"
     */
    public static function create($message, $code = 0, Throwable $previous = null)
    {
        return new self($message, $code, $previous);
    }
}
