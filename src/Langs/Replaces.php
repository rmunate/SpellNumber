<?php

namespace Rmunate\Utilities\Langs;

final class Replaces
{
    /**
     * Replacements where the currency needs to be defined at the end.
     */
    public const TO_MONEY = [
        'de' => [
            'illion' => 'illion Von',
        ],
        'en' => [
            'illion' => 'illion Of',
        ],
        'es' => [
            'uno'     => 'un',
            'illón'   => 'illón De',
            'illones' => 'illones De',
        ],
        'pt' => [
            'ilhão'  => 'ilhão De',
            'ilhões' => 'ilhões De',
        ],
        'fr' => [
            'illion'  => 'illion De',
            'illions' => 'illions De',
        ],
        'it' => [
            'ilione' => 'ilione Di',
            'ilioni' => 'ilioni Di',
        ],
        'ro' => [
            'ilion'   => 'ilion De',
            'ilioane' => 'ilioane De',
        ],
        'fa' => [
            'ilion'   => 'میلیون و',
        ],
    ];

    /**
     * These replacements will be applied generally to the output each language.
     */
    public const GENERAL = [
        'es' => [
            'un pesos'    => 'un peso',
            'un centavos' => 'un centavo',
        ],
    ];
}
