<?php

namespace Rmunate\Utilities\Bases;

abstract class BaseSpellNumberValidator
{
    /**
     * Create a new instance of the BaseValidator class for the specified data type.
     *
     * @param string $type The data type to validate.
     *
     * @return BaseValidator
     */
    public static function check(string $type, $value)
    {
        return new static($type, $value);
    }
}
