<?php

namespace Rmunate\Utilities;

use Rmunate\Utilities\Bases\BaseSpellNumber;
use Rmunate\Utilities\Exceptions\SpellNumberExceptions;
use Illuminate\Support\Str;

class SpellNumber extends BaseSpellNumber
{
    private $value;
    private $type;
    protected $locale;
    protected $currency;
    protected $fraction;
    
    public function __construct($value, $type) {
        $this->value = $value;
        $this->type = $type;
        $this->locale = 'es_ES';
        $this->currency = 'Pesos';
        $this->fraction = 'Centavos';
    }

    public function locale(string $locale)
    {
        if ($this->isValidLocale($locale)) {
            $this->locale = $locale;
            return $this;
        } else {
            throw SpellNumberExceptions::create(
                "SpellNumber::locale(?) - El valor ingresado no es valido. puede usar el metodo getAllLocales() para conocer las opciones disponibles"
            );
        }
    }

    public function currency(string $currency)
    {
        $this->currency = Str::title($currency);

    }

    public function fraction(string $fraction)
    {
        $this->fraction = Str::title($fraction);

    }

    public function toLetters()
    {
        
    }




    

    

    

}
