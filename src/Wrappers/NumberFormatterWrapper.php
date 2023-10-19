<?php

namespace Rmunate\Utilities\Wrappers;

use NumberFormatter;
use Rmunate\Utilities\Langs\Langs;

/**
 * The NumberFormatterWrapper class provides a simple wrapper around PHP's NumberFormatter class
 * to format numbers as spelled-out strings.
 */
final class NumberFormatterWrapper
{
    /**
     * Format a given numeric value as a spelled-out string.
     *
     * @param float|int   $value  The numeric value to format.
     * @param string|null $locale The locale used for formatting the number. Optional.
     *
     * @return string|null The spelled-out representation of the number, or null on failure.
     */
    public static function format(float|int $value, string $locale = null)
    {
        // If no locale is provided, use the default locale from the environment.
        $locale = $locale ?: Langs::getLocaleLaravel();

        // Create a new NumberFormatter instance with the specified locale for spelling out numbers.
        $numberFormatter = new NumberFormatter($locale, NumberFormatter::SPELLOUT);

        // Format the given numeric value as a spelled-out string.
        $value = $numberFormatter->format($value);

        return str_replace("\u{AD}", '', $value);
    }
}
