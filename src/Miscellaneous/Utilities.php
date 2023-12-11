<?php

namespace Rmunate\Utilities\Miscellaneous;

use Rmunate\Utilities\Langs\Langs;
use Rmunate\Utilities\Exceptions\SpellNumberExceptions;

class Utilities
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
        return preg_match('/[+\-]?\d+(\.\d+)?[Ee][+\-]?\d+/', $value) === 1;
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
     * Get the connector for the given locale to use in regular sentences.
     *
     * @param string|null $connector The connector to use.
     * @param string      $locale    The locale.
     * @param string      $partOne   The first part of the sentence.
     * @param string      $partTwo   The second part of the sentence.
     *
     * @return string The sentence with the connector.
     */
    public static function connector(?string $connector, string $locale, string $partOne, string $partTwo)
    {
        if (!is_null($connector)) {
            if ($connector === false || $connector === "") {
                $output = sprintf('%s %s', $partOne, $partTwo);
            } elseif (in_array($connector, [".", ","])) {
                $output = sprintf('%s%s %s', $partOne, trim($connector), $partTwo);
            } else {
                $output = sprintf('%s %s %s', $partOne, trim($connector), $partTwo);
            }
        } else {
            $locale = self::extractPrimaryLocale($locale);
            $connectorPackage = Langs::LOCALES_CONNECTORS[$locale] ?? null;

            if (is_null($connectorPackage) || $connectorPackage === false || $connectorPackage == "") {
                $output = sprintf('%s ? %s', $partOne, $partTwo);
            } else {
                $output = sprintf('%s %s %s', $partOne, $connectorPackage, $partTwo);
            }
        }

        return $output;
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
        if (strlen($string) > 2) {
            $string = substr($string, 0, 2);
        }

        return mb_strtolower($string);
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
            'male'                        => '%spellout-ordinal-masculine',
            'masculine'                   => '%spellout-ordinal-masculine',
            '%spellout-ordinal-masculine' => '%spellout-ordinal-masculine',
            'ordinal-masculine'           => '%spellout-ordinal-masculine',
            'feminine'                    => '%spellout-ordinal-feminine',
            'female'                      => '%spellout-ordinal-feminine',
            '%spellout-ordinal-feminine'  => '%spellout-ordinal-feminine',
            'ordinal-feminine'            => '%spellout-ordinal-feminine',
            'default'                     => '%spellout-ordinal',
            '%spellout-ordinal'           => '%spellout-ordinal',
            'ordinal'                     => '%spellout-ordinal',
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

    /**
     * Checks if a string ends with a specified substring.
     *
     * @param string $haystack The complete string.
     * @param string $needle   The substring to check for at the end.
     *
     * @return bool True if the string ends with the specified substring, false otherwise.
     */
    public static function endsWith($haystack, $needle)
    {
        $length = strlen($needle);

        if ($length == 0) {
            return true;
        }

        return (substr($haystack, -$length) === $needle);
    }

    /**
     * Check if a string is included in an array, and throw an exception if not.
     *
     * @param string $string    The string to check for inclusion.
     * @param array  $includes  The array to check for inclusion.
     * @param string $exception The exception message to throw if the string is not included.
     *
     * @return bool True if the string is included, otherwise an exception is thrown.
     * @throws SpellNumberExceptions Throws an exception if the string is not included in the array.
     */
    public static function includesOrException(string $string, array $includes, string $exception)
    {
        if (!in_array($string, $includes)) {
            throw SpellNumberExceptions::create($exception);
        }

        return true;
    }
}
