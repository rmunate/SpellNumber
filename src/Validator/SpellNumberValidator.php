<?php

declare(strict_types=1);

namespace Rmunate\Utilities\Validator;

use Rmunate\Utilities\Exceptions\SpellNumberExceptions;

/**
 * Validate and split numbers without converting decimal strings to binary floats.
 *
 * @internal
 */
final class SpellNumberValidator
{
    /**
     * Normalize a number while preserving its original type and fractional digits.
     *
     * @return array{whole: int, fraction: ?int, negativeZero: bool, type: 'integer'|'double'}
     *
     * @throws SpellNumberExceptions When the value, requested type, or environment is invalid.
     */
    public static function parse(mixed $value, string $type): array
    {
        if (!extension_loaded('intl')) {
            throw SpellNumberExceptions::create('The PHP Intl extension is required.');
        }

        if (!in_array($type, ['mixed', 'integer', 'double'], true)) {
            throw SpellNumberExceptions::create('The requested number type is invalid.');
        }

        if ($type === 'integer' && !is_int($value)) {
            throw SpellNumberExceptions::create('The integer() factory requires a PHP int.');
        }

        if (is_float($value) && !is_finite($value)) {
            throw SpellNumberExceptions::create('The provided value must be finite.');
        }

        if (!is_int($value) && !is_float($value) && !is_string($value)) {
            throw SpellNumberExceptions::create('The provided value must be an integer, a float, or a decimal string.');
        }

        $number = is_float($value)
            ? json_encode($value, JSON_THROW_ON_ERROR)
            : trim((string) $value, " \t\n\r\v\f");

        if (!preg_match('/\A([+-]?)([0-9]*)(?:\.([0-9]*))?\z/', $number, $parts)
            || ($parts[2] === '' && ($parts[3] ?? '') === '')
        ) {
            throw SpellNumberExceptions::create('Use a decimal number with a dot and without grouping separators or scientific notation.');
        }

        $negative = $parts[1] === '-';
        $whole = self::integerPart($parts[2], $negative);
        $digits = $parts[3] ?? '';

        // A single fractional digit represents tenths (e.g. .5 is 50 hundredths).
        $fraction = $digits === '' ? null : self::integerPart(str_pad($digits, 2, '0'));

        return [
            'whole'        => $whole,
            'fraction'     => $fraction,
            'negativeZero' => $negative && $whole === 0 && $fraction !== null && $fraction !== 0,
            'type'         => $type === 'double' || is_float($value) || isset($parts[3]) ? 'double' : 'integer',
        ];
    }

    /**
     * Cast digits only after checking that they fit in a native PHP integer.
     *
     * @throws SpellNumberExceptions When the integer or fractional component is out of range.
     */
    private static function integerPart(string $digits, bool $negative = false): int
    {
        $digits = ltrim($digits, '0');
        $value = filter_var(($negative ? '-' : '').($digits === '' ? '0' : $digits), FILTER_VALIDATE_INT);

        if ($value === false) {
            throw SpellNumberExceptions::create('The integer or fractional component is outside the PHP integer range.');
        }

        return $value;
    }
}
