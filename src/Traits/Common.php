<?php

trait Common
{
    /**
     * Validar si el Locales es Correcto
     */
    private function isValidLocale($locale)
    {
        try {
            new \NumberFormatter($locale, \NumberFormatter::DECIMAL);
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function getAllLocales()
    {
        $locales = [];
        $allLocales = \ResourceBundle::getLocales('');
        foreach ($allLocales as $locale) {
            if ($this->isValidLocale($locale)) {
                $locales[] = $locale;
            }
        }
    }

    
}
