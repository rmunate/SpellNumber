<?php

namespace Rmunate\Utilities\Validator\Traits;

use Rmunate\Utilities\Exceptions\SpellNumberExceptions;
use Rmunate\Utilities\Miscellaneous\Utilities;

trait CommonValidate
{
    /**
     * Validate if a value is in scientific notation.
     *
     * @return bool True if the value is in scientific notation, false otherwise.
     */
    private function validateScientificConnotation()
    {
        if (Utilities::isScientificConnotation($this->value)) {
            throw SpellNumberExceptions::create('The entered value exceeds the processable limits of the current version of PHP and has become a Scientific Connotation.');
        }

        return true;
    }

    /**
     * Validate that the "Intl" extension is loaded.
     *
     * @throws SpellNumberExceptions If the "Intl" extension is not installed or not available.
     */
    private function validateExtension()
    {
        if (!Utilities::validateExtension('Intl')) {
            throw SpellNumberExceptions::create('The INTL extension is not installed or not available. (https://www.php.net/manual/es/intl.installation.php)');
        }

        return true;
    }

    /**
     * Validate if the value is numeric.
     *
     * @throws SpellNumberExceptions If the supplied value is not valid (not integer or float).
     */
    private function validateNumeric()
    {
        if (!Utilities::isValidNumber($this->value)) {
            throw SpellNumberExceptions::create('The provided value is not valid. It must be of type integer or float (double). Additionally, scientific overtones generated when the maximum number available in the current version of PHP is exceeded cannot be processed.');
        }

        return true;
    }

    /**
     * Validate if the value is an integer.
     *
     * @throws SpellNumberExceptions If the supplied value is not a valid integer.
     */
    private function validateInteger()
    {
        if (!Utilities::isValidInteger($this->value)) {
            throw SpellNumberExceptions::create('The supplied value is not valid. It must be of type integer.');
        }

        return true;
    }

    /**
     * Validate if the value is a string.
     *
     * @throws SpellNumberExceptions If the supplied value is not a valid string.
     */
    private function validateString()
    {
        if (!Utilities::isValidString($this->value)) {
            throw SpellNumberExceptions::create('The supplied value is not valid. It must be of type String.');
        }

        return true;
    }

    /**
     * Validate if the value does not exceed the maximum allowed value.
     *
     * @throws SpellNumberExceptions If the entered value exceeds the maximum allowed value.
     */
    private function validateMaximum()
    {
        if (!Utilities::isNotExceedMax($this->value)) {
            throw SpellNumberExceptions::create('The value entered is too large and has been converted to scientific notation which prevents processing.');
        }

        return true;
    }

    /**
     * Validate the type of the value.
     *
     * @return string Returns "integer" if the value is a valid integer, otherwise "double".
     */
    private function validateType()
    {
        return Utilities::isValidInteger($this->value) ? 'integer' : 'double';
    }
}
