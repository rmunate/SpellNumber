<?php

namespace Rmunate\Utilities\Langs;

use Rmunate\Utilities\Traits\Accesor;

final class Replaces
{
    use Accesor;

    /**
     * ->toMoney()
     * The primary value must be there, that is, "es" instead of "es_ES" or similar.
     */
    public const TO_MONEY = [
        'de' => [
            // 'illion' => 'illion Von',
        ],
        'en' => [
            'illion' => 'illion of',
        ],
        'es' => [
            'veintiuno'         => 'veintiún',
            'treinta Y Uno'     => 'treintaiún',
            'cuarenta y uno'    => 'cuarentaiún',
            'cincuenta y uno'   => 'cincuentaiún',
            'sesenta y uno'     => 'sesentaiún',
            'setenta y uno'     => 'setentaiún',
            'ochenta y uno'     => 'ochentaiún',
            'noventa y uno'     => 'noventaiún',
            'ciento uno'        => 'ciento un',
            'doscientos uno'    => 'doscientos un',
            'trescientos uno'   => 'trescientos un',
            'cuatrocientos uno' => 'cuatrocientos un',
            'quinientos uno'    => 'quinientos un',
            'seiscientos uno'   => 'seiscientos un',
            'setecientos uno'   => 'setecientos un',
            'ochocientos uno'   => 'ochocientos un',
            'novecientos uno'   => 'novecientos un',
            'mil uno'           => 'mil un',
            'uno millón'        => 'un millón',
            'illón'             => 'illón De',
            'illones'           => 'illones De',
            'uno pesos'         => 'un peso',
            'uno soles'         => 'un sol',
            'uno euros'         => 'un euro',
            'uno bolívares'     => 'un bolívar',
            'uno bolivares'     => 'un bolívar',
            'uno quetzales'     => 'un quetzal',
            'uno lempiras'      => 'un lempira',
            'uno córdobas'      => 'un córdoba',
            'uno cordobas'      => 'un córdoba',
            'uno colónes'       => 'un colón',
            'uno colones'       => 'un colón',
            'uno balboas'       => 'un balboa',
            'uno centavos'      => 'un centavo',
            'uno céntimos'      => 'un céntimo',
            'uno centimos'      => 'un céntimo',
            'uno centimo'       => 'un céntimo',
        ],
        'fa' => [
            'ilion' => 'میلیون و',
        ],
        'fr' => [
            'illion'  => 'illion de',
            'illions' => 'illions de',
        ],
        'hi' => [
            //...
        ],
        'it' => [
            'ilione' => 'ilione di',
            'ilioni' => 'ilioni di',
        ],
        'pl' => [
            //...
        ],
        'pt' => [
            'ilhão'  => 'ilhão de',
            'ilhões' => 'ilhões de',
        ],
        'ro' => [
            'ilion'   => 'ilion de',
            'ilioane' => 'ilioane de',
        ],
        'vi' => [
            'illion' => 'illion của',
        ],
    ];

    /**
     * ->toLetters()
     * The primary value must be there, that is, "es" instead of "es_ES" or similar.
     */
    public const TO_LETTERS = [
        'de' => [
            //...
        ],
        'en' => [
            //...
        ],
        'es' => [
            //...
        ],
        'fa' => [
            //...
        ],
        'fr' => [
            //...
        ],
        'hi' => [
            //...
        ],
        'it' => [
            //...
        ],
        'pl' => [
            //...
        ],
        'pt' => [
            //...
        ],
        'ro' => [
            //...
        ],
        'vi' => [
            //...
        ],
    ];

    /**
     * ->toOrdinal()
     * The primary value must be there, that is, "es" instead of "es_ES" or similar.
     */
    public const TO_ORDINAL = [
        'de' => [
            //...
        ],
        'en' => [
            //...
        ],
        'es' => [
            //...
        ],
        'fa' => [
            //...
        ],
        'fr' => [
            //...
        ],
        'hi' => [
            //...
        ],
        'it' => [
            //...
        ],
        'pl' => [
            //...
        ],
        'pt' => [
            //...
        ],
        'ro' => [
            //...
        ],
        'vi' => [
            //...
        ],
    ];
}
