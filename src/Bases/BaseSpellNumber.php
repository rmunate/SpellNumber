<?php

namespace Rmunate\Utilities\Bases;

use NumberFormatter;
use Rmunate\Utilities\Exceptions\SpellNumberExceptions;
use Rmunate\Utilities\Langs\Langs;
use Rmunate\Utilities\Validator\SpellNumberValidator;

/**
 * The BaseSpellNumber abstract class provides a base for converting numeric values to words.
 */
abstract class BaseSpellNumber
{
    /**
     * Creates an instance of the child class with the provided value for conversion.
     *
     * @param mixed  $value  The numeric value to convert to words.
     * @param string $locale The locale to use for conversion. Default is 'es_ES' (Spanish).
     *
     * @throws SpellNumberExceptions When the Intl extension is not available or the value is not valid (integer or double).
     *
     * @return static An instance of the child class.
     */
    public static function value($value)
    {
        $type = SpellNumberValidator::check('mixed', $value)->result();

        return new static($value, $type);
    }

    /**
     * Creates an instance of the child class with the provided integer value for conversion.
     *
     * @param int $value The integer value to convert to words.
     *
     * @throws SpellNumberExceptions When the Intl extension is not available or the value is not a valid integer.
     *
     * @return static An instance of the child class.
     */
    public static function integer($value)
    {
        SpellNumberValidator::check('integer', $value)->result();

        return new static($value, 'integer');
    }

    /**
     * Creates an instance of the child class with the provided float value for conversion.
     *
     * @param float $value The float value to convert to words.
     *
     * @throws SpellNumberExceptions When the Intl extension is not available or the value is not a valid float.
     *
     * @return static An instance of the child class.
     */
    public static function float($value)
    {
        SpellNumberValidator::check('double', $value)->result();

        return new static($value, 'double');
    }

    /**
     * Retrieves a list of all available locales supported by the NumberFormatter class.
     *
     * @return array An array containing all available locales.
     */
    public static function getAllLocales()
    {
        return Langs::LOCALES;
    }
}
