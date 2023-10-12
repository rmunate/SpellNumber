<?php

namespace Rmunate\Utilities\Miscellaneous;

use Rmunate\Utilities\Langs\Langs;

/**
 * The Utilities class provides various utility methods for common operations.
 */
final class Utilities
{
    /**
     * Check if a specific PHP extension is loaded.
     *
     * @param string $name The name of the PHP extension to check.
     *
     * @return bool True if the extension is loaded, false otherwise.
     */
    public static function validateExtension(string $name)
    {
        return extension_loaded($name);
    }

    /**
     * Check if the given value is numeric.
     *
     * @param mixed $value The value to check.
     *
     * @return bool True if the value is numeric, false otherwise.
     */
    public static function isValidNumber($value)
    {
        return is_numeric($value);
    }

    /**
     * Check if the given value is a string.
     *
     * @param mixed $value The value to check.
     *
     * @return bool True if the value is a string, false otherwise.
     */
    public static function isValidString($value)
    {
        return is_string($value);
    }

    /**
     * Check if the given value is an integer.
     *
     * @param mixed $value The value to check.
     *
     * @return bool True if the value is an integer, false otherwise.
     */
    public static function isValidInteger($value)
    {
        return is_int($value);
    }

    /**
     * Check if the given value is a float (double).
     *
     * @param mixed $value The value to check.
     *
     * @return bool True if the value is a float, false otherwise.
     */
    public static function isValidDouble($value)
    {
        return is_float($value);
    }

    /**
     * Check if the given value does not exceed the maximum allowed value.
     *
     * @param mixed $value The value to check.
     *
     * @return bool True if the value does not exceed the maximum, false otherwise.
     */
    public static function isNotExceedMax($value)
    {
        //Validate scientific notation.
        if (preg_match('/[+\-E]/i', strval($value)) > 0) {
            return false;
        }

        // Implementation for checking if the value does not exceed the maximum is provided here.
        if (self::isValidString($value) || self::isValidDouble($value)) {
            $parts = explode('.', $value);
            $integerPart = intval($parts[0]);
            $decimalPart = intval($parts[1] ?? 0);

            $validateInteger = is_numeric($integerPart) && filter_var($integerPart, FILTER_VALIDATE_INT) !== false;
            $validateDecimal = is_numeric($decimalPart) && filter_var($decimalPart, FILTER_VALIDATE_INT) !== false;

            return $validateInteger && $validateDecimal;
        }

        return is_numeric($value) && filter_var($value, FILTER_VALIDATE_INT) !== false;
    }

    /**
     * Check if the given locale is valid and supported.
     *
     * @param string $locale The locale code to check.
     *
     * @return bool True if the locale is valid and supported, false otherwise.
     */
    public static function isValidLocale($locale)
    {
        return in_array($locale, Langs::LOCALES);
    }

    /**
     * Get the connector for the given locale to use in regular sentences.
     *
     * @param string $locale The locale code to get the connector for.
     *
     * @return string The connector for the given locale.
     */
    public static function connector($locale)
    {
        $connector = Langs::LOCALES_CONNECTORS;

        return $connector[$locale];
    }

    /**
     * Get the connector for the given locale to use in sentences related to money.
     *
     * @param string $locale The locale code to get the money connector for.
     *
     * @return string The money connector for the given locale.
     */
    public static function connectorMoney($locale)
    {
        $connector = Langs::LOCALES_CONNECTORS_MONEY;

        return $connector[$locale];
    }
}
