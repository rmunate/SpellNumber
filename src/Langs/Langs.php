<?php

declare(strict_types=1);

namespace Rmunate\Utilities\Langs;

use Locale;

/**
 * Preset languages and the words used to join whole and fractional parts.
 *
 * @internal
 */
final class Langs
{
    /**
     * Names of the languages with package-provided formatting defaults.
     *
     * @var array<string, string>
     */
    public const LOCALES_AVAILABLE = [
        'de' => 'German',
        'en' => 'English',
        'es' => 'Spanish',
        'fa' => 'Farsi',
        'fr' => 'French',
        'hi' => 'Hindi',
        'it' => 'Italian',
        'pl' => 'Polish',
        'pt' => 'Portuguese',
        'ro' => 'Romanian',
        'vi' => 'Vietnamese',
    ];

    /**
     * Localized connectors for both decimal words and money.
     *
     * @var array<string, string>
     */
    public const LOCALES_CONNECTORS = [
        'de' => 'und',
        'en' => 'and',
        'es' => 'con',
        'fa' => 'ممیز',
        'fr' => 'et',
        'hi' => 'और',
        'it' => 'con',
        'pl' => 'i',
        'pt' => 'com',
        'ro' => 'cu',
        'vi' => 'và',
    ];

    /**
     * Extract the full primary language subtag from an ICU locale identifier.
     */
    public static function primary(string $locale): string
    {
        return $locale === '' ? '' : (Locale::getPrimaryLanguage($locale) ?? '');
    }
}
