<?php

namespace Rmunate\Utilities\Traits;

use Rmunate\Utilities\Miscellaneous\Words;
use Rmunate\Utilities\Wrappers\NumberFormatterWrapper;
use Rmunate\Utilities\Exceptions\SpellNumberExceptions;

trait Processor
{
    /**
     * Convert the integer numeric value to its ordinal textual representation.
     *
     * @param string $attr Additional attribute (if any).
     * @return string The textual representation of the ordinal value.
     *
     * @throws SpellNumberExceptions If a double value is provided instead of an integer.
     */
    private function integerToOrdinal($attr)
    {
        // If the value is of type double, throw an exception.
        if ($this->type == 'double') {
            throw SpellNumberExceptions::create('To convert to ordinal numbers, an integer value is required as input');
        }

        // Return the output value for INT.
        $formatter = NumberFormatterWrapper::format($this->value, $this->locale, true, $attr);

        // Apply replacements from the same package.
        $formatter = Words::replaceLocale($formatter, $this->locale, self::TO_ORDINAL);

        // Apply replacements loaded in the configuration file.
        $formatter = Words::replaceFromConfig($formatter, $this->locale);

        // Apply user-supplied replacements.
        $formatter = Words::replaceCustom($formatter, $this->replacements);

        return $formatter;
    }
    
}
