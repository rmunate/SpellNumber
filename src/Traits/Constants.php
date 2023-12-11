<?php

namespace Rmunate\Utilities\Traits;

trait Constants
{
    // Indicator for using a specific locale
    public const SPECIFIC_LOCALE = true;

    // Ordinal constants
    public const ORDINAL_DEFAULT = '%spellout-ordinal';
    public const ORDINAL_FEMALE = '%spellout-ordinal-feminine';
    public const ORDINAL_MALE = '%spellout-ordinal-masculine';

    // Conversion method constants
    public const TO_LETTERS = '%value-to-letters';
    public const TO_ORDINAL = '%value-to-ordinal';
    public const TO_MONEY = '%value-to-money';
    public const TO_CLOCK = '%value-to-clock';
    public const TO_SCIENTIFIC = '%value-to-scientific';
    public const TO_PERCENT = '%value-to-percent';
    public const TO_CURRENCY = '%value-to-currency';
    public const TO_SUMMARY = '%value-to-summary';
    public const TO_ROMAN_NUMERAL = '%value-to-roman-numeral';

    // Date format constants
    public const DATE_SHORT = '%date-format-short';
    public const DATE_MEDIUM = '%date-format-medium';
    public const DATE_LONG = '%date-format-long';
    public const DATE_FULL = '%date-format-full';
}
