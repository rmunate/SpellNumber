<?php

namespace Rmunate\Utilities\Bases;

use Rmunate\Utilities\Miscellaneous\Utilities;
use Rmunate\Utilities\Exceptions\SpellNumberExceptions;

/**
 * The BaseSpellNumber abstract class provides a base for converting numeric values to words.
 */
abstract class BaseSpellNumber
{
    /**
     * Creates an instance of the child class with the provided value for conversion.
     *
     * @param mixed $value The numeric value to convert to words.
     * @param string $locale The locale to use for conversion. Default is 'es_ES' (Spanish).
     * @return static An instance of the child class.
     * @throws SpellNumberExceptions When the Intl extension is not available or the value is not valid (integer or double).
     */
    public static function create($value)
    {
        // Check if the intl extension is installed.
        if (!Utilities::validateExtension('intl')) {
            throw SpellNumberExceptions::create(
                'BaseSpellNumber::create(?) - The Intl extension is not installed or not available.'
            );
        }

        // Validate that it is a valid number (integer or double).
        if (!Utilities::isValidNumber($value)) {
            throw SpellNumberExceptions::create(
                'BaseSpellNumber::create(?) - The supplied value is not valid. It must be of type integer or float (double).'
            );
        }

        // Determine the type (integer or double).
        $type = Utilities::isValidInteger($value) ? 'integer' : 'double';

        // Return new instance.
        return new static($value, $type);
    }

    /**
     * Creates an instance of the child class with the provided integer value for conversion.
     *
     * @param int $value The integer value to convert to words.
     * @return static An instance of the child class.
     * @throws SpellNumberExceptions When the Intl extension is not available or the value is not a valid integer.
     */
    public static function integer($value)
    {
        // Check if the intl extension is installed.
        if (!Utilities::validateExtension('intl')) {
            throw SpellNumberExceptions::create(
                'BaseSpellNumber::integer(?) - The Intl extension is not installed or not available.'
            );
        }

        // Validate that it is a valid integer.
        if (!Utilities::isValidInteger($value)) {
            throw SpellNumberExceptions::create(
                'BaseSpellNumber::integer(?) - The supplied value is not valid. It must be of type integer.'
            );
        }

        // Return new instance.
        return new static($value, 'integer');
    }

    /**
     * Creates an instance of the child class with the provided float value for conversion.
     *
     * @param float $value The float value to convert to words.
     * @return static An instance of the child class.
     * @throws SpellNumberExceptions When the Intl extension is not available or the value is not a valid float.
     */
    public static function float($value)
    {
        // Check if the intl extension is installed.
        if (!Utilities::validateExtension('intl')) {
            throw SpellNumberExceptions::create(
                'BaseSpellNumber::float(?) - The Intl extension is not installed or not available.'
            );
        }

        // Validate that it is a valid float.
        if (!Utilities::isValidDouble($value)) {
            throw SpellNumberExceptions::create(
                'BaseSpellNumber::float(?) - The supplied value is not valid. It must be of type float (double).'
            );
        }

        // Return new instance.
        return new static($value, 'double');
    }
    
}
