<?php

declare(strict_types=1);

namespace Rmunate\Utilities\Wrappers;

use IntlException;
use Locale;
use NumberFormatter;
use Rmunate\Utilities\Exceptions\SpellNumberExceptions;
use Rmunate\Utilities\Langs\Langs;
use Rmunate\Utilities\SpellNumber;

/**
 * Spell out native integers with ICU and surface unsupported rules or results.
 *
 * @internal
 */
final class NumberFormatterWrapper
{
    /** The ICU spellout formatter for the requested locale. */
    private NumberFormatter $formatter;

    /**
     * Initialize a spellout formatter without accepting cross-language ICU fallback.
     *
     * @throws SpellNumberExceptions When ICU does not support spellout for the requested language.
     */
    public function __construct(private string $locale)
    {
        $this->formatter = $this->createFormatter(NumberFormatter::SPELLOUT);
        $actualLocale = $this->formatter->getLocale(Locale::ACTUAL_LOCALE);

        if ($actualLocale === false || Langs::primary($actualLocale) !== Langs::primary($locale)) {
            throw SpellNumberExceptions::create("ICU does not provide spellout rules for the locale '{$locale}'.");
        }
    }

    /**
     * Format a cardinal number, preserving the sign of a negative fractional value below one.
     */
    public function cardinal(int $value, bool $negativeZero = false): string
    {
        $words = $this->spell($value);

        if (!$negativeZero) {
            return $words;
        }

        // ICU drops the sign of -0. Use its negative pattern with the word for zero instead.
        $one = $this->spell(1);
        $negativeOne = $this->spell(-1);
        $position = strpos($negativeOne, $one);

        if ($position === false || $negativeOne === $one) {
            throw SpellNumberExceptions::create("ICU could not express a negative fractional value for '{$this->locale}'.");
        }

        return substr_replace($negativeOne, $words, $position, strlen($one));
    }

    /**
     * Format an ordinal using an available default or gendered ICU spellout rule.
     *
     * @throws SpellNumberExceptions When no compatible ordinal rule can spell the value.
     */
    public function ordinal(int $value, string $rule): string
    {
        $candidates = $rule === SpellNumber::ORDINAL_DEFAULT
            ? [$rule, SpellNumber::ORDINAL_MALE, SpellNumber::ORDINAL_FEMALE]
            : [$rule, SpellNumber::ORDINAL_DEFAULT];

        try {
            $available = explode(';', $this->formatter->getTextAttribute(NumberFormatter::PUBLIC_RULESETS));

            foreach ($candidates as $candidate) {
                if (!in_array($candidate, $available, true)) {
                    continue;
                }

                if ($this->formatter->setTextAttribute(NumberFormatter::DEFAULT_RULESET, $candidate)) {
                    $words = $this->spell($value);

                    if ($value < 0 && $value !== PHP_INT_MIN && $words === $this->spell(-$value)) {
                        throw SpellNumberExceptions::create("ICU cannot express negative ordinals for '{$this->locale}'.");
                    }

                    return $words;
                }
            }
        } catch (IntlException $exception) {
            throw SpellNumberExceptions::create("ICU could not set an ordinal rule for '{$this->locale}'.", 0, $exception);
        }

        throw SpellNumberExceptions::create("No compatible ordinal spellout rule for '{$this->locale}' and '{$rule}'.");
    }

    /**
     * Read the ICU decimal separator for a locale without a preset connector.
     *
     * @throws SpellNumberExceptions When the separator cannot be read.
     */
    public function decimalSeparator(): string
    {
        try {
            $separator = $this->createFormatter(NumberFormatter::DECIMAL)->getSymbol(NumberFormatter::DECIMAL_SEPARATOR_SYMBOL);
        } catch (IntlException $exception) {
            throw SpellNumberExceptions::create("ICU could not read the decimal separator for '{$this->locale}'.", 0, $exception);
        }

        if ($separator === false || $separator === '') {
            throw SpellNumberExceptions::create("ICU could not read the decimal separator for '{$this->locale}'.");
        }

        return $separator;
    }

    /**
     * Read the ICU spelling without coercing to a float or accepting a numeric fallback.
     *
     * @throws SpellNumberExceptions When ICU cannot spell out the value.
     */
    private function spell(int $value): string
    {
        try {
            $words = $this->formatter->format($value, NumberFormatter::TYPE_INT64);
        } catch (IntlException $exception) {
            throw SpellNumberExceptions::create("ICU could not spell out {$value} for '{$this->locale}'.", 0, $exception);
        }

        if ($words === false || $words === '' || preg_match('/\p{Nd}/u', $words) === 1) {
            throw SpellNumberExceptions::create("ICU could not spell out {$value} for '{$this->locale}'.");
        }

        return str_replace(["\u{AD}", "\u{200B}"], '', $words);
    }

    /**
     * Create an ICU formatter while keeping errors under the package's exception type.
     */
    private function createFormatter(int $style): NumberFormatter
    {
        try {
            return new NumberFormatter($this->locale, $style);
        } catch (IntlException $exception) {
            throw SpellNumberExceptions::create("ICU could not initialize locale '{$this->locale}'.", 0, $exception);
        }
    }
}
