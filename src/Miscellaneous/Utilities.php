<?php

namespace Rmunate\Utilities\Miscellaneous;

use Rmunate\Utilities\Langs\Langs;

final class Utilities
{
    /**
     * Validate if a value is in scientific notation.
     *
     * @param string $value The value to be validated.
     *
     * @return bool True if the value is in scientific notation, false otherwise.
     */
    public static function isScientificConnotation($value)
    {
        if (preg_match('/[+\-]?\d+(\.\d+)?[Ee][+\-]?\d+/', $value)) {
            return true;
        }

        return false;
    }

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
        $timezones = array_keys(Langs::LOCALES_AVAILABLE);

        return in_array($locale, $timezones);
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
        $locale = self::extractPrimaryLocale($locale);

        return $connector[$locale] ?? '?';
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
        $locale = self::extractPrimaryLocale($locale);

        return $connector[$locale] ?? '?';
    }

    /**
     * Set the numeric value where the trailing zero is removed.
     *
     * @param mixed $value
     *
     * @return mixed
     */
    public static function decimal($value)
    {
        $result = match ($value) {
            '01'    => 1,
            '1'     => 10,
            '02'    => 2,
            '2'     => 20,
            '03'    => 3,
            '3'     => 30,
            '04'    => 4,
            '4'     => 40,
            '05'    => 5,
            '5'     => 50,
            '06'    => 6,
            '6'     => 60,
            '07'    => 7,
            '7'     => 70,
            '08'    => 8,
            '8'     => 80,
            '09'    => 9,
            '9'     => 90,
            default => $value,
        };

        return $result;
    }

    /**
     * Extracts the main value of the "Locale" example "es_MX" extracts "es".
     *
     * @param mixed $string
     *
     * @return string
     */
    public static function extractPrimaryLocale($string)
    {
        return mb_strtolower(substr($string, 0, 2));
    }

    /**
     * Determine the ordinal text mode based on the provided value.
     *
     * @param string|null $value The value indicating the ordinal text mode.
     *
     * @return string The corresponding rule for ordinal text formatting.
     */
    public static function textOrdinalMode(?string $value)
    {
        return match ($value) {
            'default'                     => '%spellout-ordinal',
            'male'                        => '%spellout-ordinal-masculine',
            'female'                      => '%spellout-ordinal-feminine',
            'masculine'                   => '%spellout-ordinal-masculine',
            'feminine'                    => '%spellout-ordinal-feminine',
            '%spellout-ordinal'           => '%spellout-ordinal',
            '%spellout-ordinal-masculine' => '%spellout-ordinal-masculine',
            '%spellout-ordinal-feminine'  => '%spellout-ordinal-feminine',
            'ordinal'                     => '%spellout-ordinal',
            'ordinal-masculine'           => '%spellout-ordinal-masculine',
            'ordinal-feminine'            => '%spellout-ordinal-feminine',
            default                       => '%spellout-ordinal',
        };
    }

    /**
     * Determine the human-readable ordinal text mode based on the provided value.
     *
     * @param string|null $value The value indicating the ordinal text mode.
     *
     * @return string The corresponding human-readable ordinal text mode.
     */
    public static function textOrdinalModeHuman(?string $value)
    {
        return match ($value) {
            '%spellout-ordinal-masculine' => 'male',
            '%spellout-ordinal-feminine'  => 'female',
            '%spellout-ordinal'           => 'default',
        };
    }
}
