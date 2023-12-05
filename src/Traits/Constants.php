<?php

namespace Rmunate\Utilities\Traits;

trait Constants
{
    // Indicator for using specific locale
    public const SPECIFIC_LOCALE = true;

    // Ordinal constants
    public const ORDINAL_DEFAULT = '%spellout-ordinal';
    public const ORDINAL_FEMALE = '%spellout-ordinal-feminine';
    public const ORDINAL_MALE = '%spellout-ordinal-masculine';

    // Conversion method constants
    public const TO_LETTERS = 'TO_LETTERS';
    public const TO_ORDINAL = 'TO_ORDINAL';
    public const TO_MONEY = 'TO_MONEY';
    public const TO_CLOCK = 'TO_CLOCK';  // Corrected typo 'TO_CLOK' to 'TO_CLOCK'
    public const TO_SCIENTIFIC = 'TO_SCIENTIFIC';
    public const TO_PERCENT = 'TO_PERCENT';
    public const TO_CURRENCY = 'TO_CURRENCY';
    public const TO_SUMMARY = 'TO_SUMMARY';
    public const TO_ROMAN_NUMERAL = 'TO_ROMAN_NUMERAL';

    // Date format constants
    public const DATE_SHORT = 'MMMM d, yyyy';
    public const DATE_MEDIUM = 'EEE, MMM d, yyyy';
    public const DATE_LONG = 'EEE, d MMM yyyy';
    public const DATE_FULL = null;  // Assuming DATE_FULL should be nullable for custom usage
}
