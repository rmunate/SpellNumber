<?php

declare(strict_types=1);

namespace Rmunate\Utilities\Miscellaneous;

/**
 * Apply the package's monetary grammar and configurable output replacements.
 *
 * @internal
 */
final class Words
{
    /**
     * Built-in singular forms; custom labels are otherwise kept as supplied.
     *
     * @var array<string, array<string, string>>
     */
    private const SINGULAR_LABELS = [
        'en' => [
            'dollars' => 'dollar',
            'cents'   => 'cent',
        ],
        'es' => [
            'balboas'   => 'balboa',
            'bolivares' => 'bolívar',
            'bolívares' => 'bolívar',
            'centavos'  => 'centavo',
            'centimos'  => 'céntimo',
            'céntimos'  => 'céntimo',
            'colones'   => 'colón',
            'colónes'   => 'colón',
            'cordobas'  => 'córdoba',
            'córdobas'  => 'córdoba',
            'dolares'   => 'dólar',
            'dólares'   => 'dólar',
            'euros'     => 'euro',
            'lempiras'  => 'lempira',
            'pesos'     => 'peso',
            'quetzales' => 'quetzal',
            'soles'     => 'sol',
        ],
    ];

    /**
     * Joiners inserted only when the spelled number ends in a large scale noun.
     *
     * @var array<string, array{string, string}>
     */
    private const MONEY_JOINERS = [
        'es' => ['/(?:illón|illones)\z/u', 'de'],
        'fr' => ['/(?:illions?|illiards?)\z/u', 'de'],
        'it' => ['/(?:ilione|ilioni|iliardo|iliardi)\z/u', 'di'],
        'pt' => ['/(?:ilhão|ilhões)\z/u', 'de'],
        'ro' => ['/(?:ilion|ilioane|iliard|iliarde)\z/u', 'de'],
    ];

    /**
     * Attach a currency or fraction label without altering unrelated number words.
     */
    public static function moneyPart(string $words, int $value, string $label, string $language): string
    {
        $words = mb_strtolower($words, 'UTF-8');
        $label = mb_strtolower($label, 'UTF-8');
        $singulars = self::SINGULAR_LABELS[$language] ?? [];

        if ($language === 'es' && (isset($singulars[$label]) || in_array($label, $singulars, true))) {
            if (str_ends_with($words, 'veintiuno')) {
                $words = substr($words, 0, -3).'ún';
            } elseif ($words === 'uno' || str_ends_with($words, ' uno')) {
                $words = substr($words, 0, -1);
            }
        }

        if ($value === 1 || $value === -1) {
            $label = $singulars[$label] ?? $label;
        }

        $joiner = self::MONEY_JOINERS[$language] ?? null;

        if ($joiner !== null && preg_match($joiner[0], $words) === 1) {
            $separator = $language === 'fr' && preg_match('/\A[aeiouyàâäéèêëîïôöùûüÿœæ]/u', $label) === 1
                ? ' d’'
                : ' '.$joiner[1].' ';

            return $words.$separator.$label;
        }

        return $words.' '.$label;
    }

    /**
     * Lowercase the output and apply the configured substring replacements in order.
     *
     * @param array<string|int, string> $replacements
     */
    public static function replaceFromConfig(string $words, array $replacements): string
    {
        $words = mb_strtolower($words, 'UTF-8');

        foreach ($replacements as $search => $replacement) {
            $words = str_replace(
                mb_strtolower((string) $search, 'UTF-8'),
                mb_strtolower($replacement, 'UTF-8'),
                $words
            );
        }

        return $words;
    }
}
