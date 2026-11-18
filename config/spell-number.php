<?php

/**
 * Default settings for spelling numbers with PHP Intl.
 */

return [
    'default' => [
        /** Use Laravel's preset language if null; otherwise use this locale. */
        'locale' => null,

        /** Allow regional and additional ICU locales. */
        'specific_locale' => false,

        /** The whole and fractional currency labels used by toMoney(). */
        'currency' => 'dollars',
        'fraction' => 'cents',

        /** The requested ordinal rule: default, male, or female. */
        'ordinal_output' => 'default',
    ],

    /**
     * Case-insensitive substring replacements by primary language, applied before the callback.
     * Example: 'es' => ['uno' => 'un'].
     */
    'replacements' => [],

    /**
     * Optional callable receiving a DataResponse. Use a static callable such as
     * [App\Support\SpellNumberOutput::class, 'format'] when using artisan config:cache.
     */
    'callback_output' => null,
];
