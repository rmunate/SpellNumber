<?php

namespace Rmunate\Utilities\Miscellaneous;

use NumberFormatter;

final class SpellOut extends NumberFormatter
{
    public static function type()
    {
        return new self();
    }

    public function integer()
    {
        return parent::TYPE_DEFAULT;
    }

    public function double()
    {
        return parent::TYPE_DOUBLE;
    }

    public function __construct($locale, $style, $pattern = null)
    {
        parent::__construct($locale, $style, $pattern);
    }
}
