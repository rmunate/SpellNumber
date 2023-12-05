<?php

namespace Rmunate\Utilities\Traits;

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
        return constant(get_called_class().'::'.$name);
    }
}
