<?php

namespace Rmunate\Utilities\Traits;

use Illuminate\Support\Facades\App;
use Rmunate\Utilities\Langs\Langs;
use Rmunate\Utilities\Miscellaneous\Utilities;

trait Locale
{
    /**
     * Get the language locale used in Laravel application.
     * If the locale is supported in ISO 639-1 format, return it. Otherwise, return the default.
     */
    public static function getLocaleLaravel()
    {
        $isoLang = Utilities::extractPrimaryLocale(App::getLocale());

        $availables = array_keys(Langs::LOCALES_AVAILABLE);

        // Return especific timezone
        if (in_array($isoLang, $availables)) {
            return $isoLang;
        }

        // Return the default locale if not found in supported locales.
        return 'en'; // English
    }
}
