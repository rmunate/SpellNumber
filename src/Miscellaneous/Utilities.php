<?php

namespace Rmunate\Utilities\Miscellaneous;

/**
 * The Utilities class provides various utility methods for numeric operations.
 */
final class Utilities
{
    /**
     * Sanitizes a numeric value by replacing commas with dots and removing spaces.
     *
     * @param mixed $value The numeric value to sanitize.
     * @return float|string The sanitized numeric value as a float.
     */
    public static function floatSanitize($value)
    {
        // Replacing commas with dots and removing spaces from the value.
        return (double) str_replace(
            [',', ' '],
            ['.', ''],
            $value
        );
    }

    /**
     * Sanitizes a numeric value by attempting to convert it to an integer.
     * If direct conversion fails, it tries to convert the value to a float and then to an integer.
     *
     * @param mixed $value The numeric value to sanitize.
     * @return int The sanitized integer value.
     */
    public static function integerSanitize($value)
    {
        // Attempt to convert directly to an integer using intval()
        $intValue = intval($value);
        
        // If the direct conversion to an integer fails, try converting to float and then to an integer
        if ($intValue === 0 && !is_numeric($value)) {
            $floatValue = filter_var($value, FILTER_VALIDATE_FLOAT);
            if ($floatValue !== false) {
                $intValue = (int) $floatValue;
            }
        }

        return $intValue;
    }

    /**
     * Checks if a value is a valid numeric value (integer or float).
     *
     * @param mixed $value The value to check.
     * @return bool True if the value is a valid numeric value, false otherwise.
     */
    public static function isValidNumber($value)
    {
        return is_numeric($value);
    }

    /**
     * Checks if a value is a valid integer.
     *
     * @param mixed $value The value to check.
     * @return bool True if the value is a valid integer, false otherwise.
     */
    public static function isValidInteger($value)
    {
        return is_int($value);
    }

    /**
     * Checks if a value is a valid float (double).
     *
     * @param mixed $value The value to check.
     * @return bool True if the value is a valid float, false otherwise.
     */
    public static function isValidDouble($value)
    {
        return is_float($value);
    }

    /**
     * Validates the availability of a PHP extension by name.
     *
     * @param string $name The name of the extension to validate.
     * @return bool True if the extension is loaded, false otherwise.
     */
    public static function validateExtension(string $name)
    {
        return extension_loaded($name);
    }
}
