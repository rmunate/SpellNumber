<?php

namespace Rmunate\Utilities\Traits;

use NumberFormatter;
use Rmunate\Utilities\Miscellaneous\Utilities;
use Rmunate\Utilities\Wrappers\NumberFormatterWrapper;
use Rmunate\Utilities\Miscellaneous\Words;

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
        Utilities::includesOrException(
            $this->type,
            ["double"],
            'To convert to ordinal numbers, an integer value is required as input.'
        );

        // Return the output value for INT.
        $formatter = new NumberFormatter($this->locale, NumberFormatter::SPELLOUT);
        $formatter->setTextAttribute(NumberFormatter::DEFAULT_RULESET, $attr);
        $value = $formatter->format($this->value);
        
        $value = Words::replaceLocale($value, $this->locale, "TO_ORDINAL");
        $value = Words::replaceFromConfig($value, $this->locale);
        $value = Words::replaceCustom($value, $this->replacements);

        return $formatter;
    }

    /**
     * Convert the integer numeric value to its textual representation.
     *
     * @return string The textual representation of the integer numeric value.
     */
    private function integerToLetters()
    {
        Utilities::includesOrException(
            $this->type,
            ["integer", "double"],
            'To convert to letters numbers, an integer value is required as input.'
        );

        // Text format
        $formatter = NumberFormatterWrapper::format($this->value, $this->locale);

        $numberFormatter = new NumberFormatter($this->locale, NumberFormatter::SPELLOUT);
        $formatter = $numberFormatter->format($this->value);

        $formatter = Words::replaceLocale($formatter, $this->locale, "TO_LETTERS");
        $formatter = Words::replaceFromConfig($formatter, $this->locale);
        $formatter = Words::replaceCustom($formatter, $this->replacements);

        return $formatter;
    }

    /**
     * Convert the double numeric value to its textual representation.
     *
     * @return string The textual representation of the double numeric value.
     */
    private function doubleToLetters()
    {
        // Ensure the second value after the decimal point is not 0
        $parts = explode('.', $this->value);
        if (!array_key_exists(1, $parts)) {
            return $this->integerToLetters();
        }

        // Adjust the decimal value
        $parts[1] = Utilities::decimal($parts[1]);

        // Translate the values separately
        $letters1 = NumberFormatterWrapper::format($parts[0], $this->locale);
        $letters2 = NumberFormatterWrapper::format($parts[1], $this->locale);

        // Define the connector for the output
        $output = Utilities::connector($this->connector, $this->locale, $letters1, $letters2);

        // Replacements from the same package
        $output = Words::replaceLocale($output, $this->locale, self::TO_LETTERS);

        // Replacements from the configuration
        $output = Words::replaceFromConfig($output, $this->locale);

        // User-supplied replacements
        $output = Words::replaceCustom($output, $this->replacements);

        return $output;
    }
    
}
