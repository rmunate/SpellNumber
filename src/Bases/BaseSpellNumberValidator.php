<?php

namespace Rmunate\Utilities\Bases;

abstract class BaseSpellNumberValidator
{
    /**
     * Create a new instance of the SpellNumberValidator class for the specified data type.
     *
     * @param string $type  The data type to validate.
     * @param mixed  $value The value to validate.
     *
     * @return SpellNumberValidator
     */
    public static function check(string $type, $value)
    {
        return new static($type, $value);
    }
}
