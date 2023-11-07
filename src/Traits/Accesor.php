<?php

namespace Rmunate\Utilities\Traits;

/**
 * Trait Accesor.
 *
 * This trait provides a method to access constants of a class that uses it.
 */
trait Accesor
{
    /**
     * Access a constant of the class using the trait.
     *
     * @param string $name The name of the constant to access.
     *
     * @return mixed The value of the constant.
     */
    public static function constant(string $name)
    {
        // Use the constant() function to access the constant.
        return constant(get_called_class().'::'.$name);
    }
}
