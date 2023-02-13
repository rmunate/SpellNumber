<?php

namespace Rmunate\Utilities;

use Exception;

/**
 * Clase para pasar de numeros a letras
 * --------------------------------------------
 * Desarrollado por: Raul Mauricio Uñate Castro
 * raulmauriciounate@gmail.com
 * V 1.0.0
 */

class SpellNumber
{

    /* Propiedades Inicializador */
    private static $type;
    private static $integer_static;
    private static $decimal_static;

    /* Atributos Para Iniciar Enteros */
    protected static $minInteger = 0;
    protected static $maxInteger = 999999999999999999;
    protected static $integerLength = 18;

    /* Atributos Para Iniciar Flotantes */
    protected static $minFloat = 0;
    protected static $maxFloat = 999999999999999999;
    protected static $floatLength = 18;
    protected static $minDecimals = 1;
    protected static $maxDecimals = 99;
    protected static $decimalsLength = 18;

    /* Espacio de Nombre */
    protected $namespace;
    protected $vendor;

    /* Atributos Publicos */
    public $integer_original;
    public $decimal_original;

    /* Atributos Del Objeto */
    protected $integer_string;
    protected $decimal_string;
    protected $currency;
    protected $fraction;
    protected $initializer;

    #-------------------------------------
    # CONSTRUCTOR DE CLASE
    #-------------------------------------
    public function __construct(){
        $this->namespace = $this::class;
        $this->vendor = 'https://github.com/rmunate';
        $this->integer_string = Self::$integer_static;
        $this->decimal_string = Self::$decimal_static;
        $this->integer_original = intval($this->integer_string);
        $this->decimal_original = intval($this->decimal_string);
        $this->initializer = Self::$type;
    }

    #-------------------------------------
    # INICIALIZADORES
    #-------------------------------------

    public static function integer(int $value){

        /* Garantizar que el valor cumpla con los limites */
        if (($value >= Self::$minInteger) && ($value <= Self::$maxInteger)) {

            Self::$type = 'integer';
            $value = str_pad($value, Self::$integerLength, " ", STR_PAD_LEFT);
            Self::$integer_static = $value;
            Self::$decimal_static = "0";
            return new static();

        } else {

            /* Retornar Excepcion */
            throw new Exception("SpellNumberEl::integer() - El valor ingresado no cumple con los limites establecidos Minimo = " . Self::minInteger . " y Maximo = " . Self::maxInteger);

        }

    }

    public static function float(string $value){

        // 1. Validar si es un string
        if (!is_string($value)) {
            throw new Exception("SpellNumber::float - El valor debe ser un string");
        }

        // 2. Validar que no contenga letras
        $value = str_replace(',', '.', $value); /* Garantizar uso de Punto Como separador */
        $value = explode('.', $value);
        if (count($value) == 1 && !is_numeric($value[0])) {
            throw new Exception("SpellNumber::float() - El valor ingresado contiene letras, espacios ó caracteres no númericos, por favor corríjalo.");
        }
        if (count($value) > 2) {
            throw new Exception("SpellNumber::float() - El valor ingresado contiene más de un separador decimal, por favor corríjalo.");
        }
        if (count($value) == 2 && (!is_numeric($value[0]) || !is_numeric($value[1]))) {
            throw new Exception("SpellNumber::float() - El valor ingresado contiene letras, espacios ó caracteres no númericos, por favor corríjalo.");
        }

        // 3. Validar Longitud Decimal
        if (intval($value[1]) >= 100) {
            throw new Exception("SpellNumber::float() - El valor decimal no puede ser mayor a 99.");
        }

        /* Tratamiento Al Entero */
        if (($value[0] >= Self::$minFloat) && ($value[0] <= Self::$maxFloat)) {
            Self::$integer_static = str_pad($value[0], Self::$floatLength, " ", STR_PAD_LEFT);
        } else {
            throw new Exception("SpellNumber::float() - El valor númerico entero supera el limite establecido Maximo = " . Self::$maxFloat . " y Minimo = " . Self::$minFloat);
        }

        /* Tratamiendo Decimal */
        if (($value[1] >= Self::$minDecimals) && ($value[1] <= Self::$maxDecimals)) {
            Self::$decimal_static = str_pad($value[1], Self::$decimalsLength, " ", STR_PAD_LEFT);
        } else {
            throw new Exception("SpellNumber::float() - El valor decimal supera el limite establecido Maximo = " . Self::$maxDecimals . " y Minimo = " . Self::$minDecimals);
        }

        Self::$type = 'float';
        return new static();

    }

    #-------------------------------------
    # VALORES PARA MONEDAS
    #-------------------------------------

    public function currency(string $arg_currency){
        $this->currency = ucwords(strtolower($arg_currency));
        return $this;
    }
    
    public function fraction(string $fraction){
        $this->fraction = ucwords(strtolower($fraction));
        return $this;
    }

    #-------------------------------------
    # SALIDAS
    #-------------------------------------

    /* Salida del Valor a Letras */
    public function toLetters(){
        if ($this->initializer == 'integer') {
            $letters = $this->numtoletras($this->integer_string);
        } else if ($this->initializer == 'float') {
            $letters_int = $this->numtoletras($this->integer_string);
            $letters_dec = $this->numtoletras($this->decimal_string);
            $letters = $letters_int . " coma " . $letters_dec;
        }
        return $letters;
    }

    /* Salida del Valor a Letras De Moneda */
    public function toMoney(){

        /* Definir Moneda */
        $currency = $this->currency ?? 'Peso';
        if (($this->integer_original > 1) && (substr($currency, -1) != 's')) {
            if (substr($currency, -1) != 'a' && substr($currency, -1) != 'e' && substr($currency, -1) != 'i' && substr($currency, -1) != 'o' && substr($currency, -1) != 'u') {
                $currency = $currency . 'es';
            } else {
                $currency = $currency . 's';
            }
        }

        $fraction = $this->fraction ?? 'Centavo';
        if (($this->decimal_original > 1) && (substr($fraction, -1) != 's')) {
            if (substr($fraction, -1) != 'a' && substr($fraction, -1) != 'e' && substr($fraction, -1) != 'i' && substr($fraction, -1) != 'o' && substr($fraction, -1) != 'u') {
                $fraction = $fraction . 'es';
            } else {
                $fraction = $fraction . 's';
            }
        }

        if ($this->initializer == 'integer') {
            $letters = $this->numtoletras($this->integer_string, $currency);
            $letters = $letters . ' ' . $currency;
        } else if ($this->initializer == 'float') {
            $letters_int = $this->numtoletras($this->integer_string, $currency);
            $letters_dec = $this->numtoletras($this->decimal_string, $fraction);
            $letters = $letters_int . ' ' . $currency . " Con " . $letters_dec . ' ' . $fraction;
        }
        return $letters;

    }

    #-------------------------------------
    # PROCESAMIENTO NUMEROS A LETRAS
    #-------------------------------------

    private function arrayLetters(){
        return array(
            0 => "CERO",
            1 => "UN",
            2 => "DOS",
            3 => "TRES",
            4 => "CUATRO",
            5 => "CINCO",
            6 => "SEIS",
            7 => "SIETE",
            8 => "OCHO",
            9 => "NUEVE",
            10 => "DIEZ",
            11 => "ONCE",
            12 => "DOCE",
            13 => "TRECE",
            14 => "CATORCE",
            15 => "QUINCE",
            16 => "DIECISEIS",
            17 => "DIECISIETE",
            18 => "DIECIOCHO",
            19 => "DIECINUEVE",
            20 => "VEINTI",
            30 => "TREINTA",
            40 => "CUARENTA",
            50 => "CINCUENTA",
            60 => "SESENTA",
            70 => "SETENTA",
            80 => "OCHENTA",
            90 => "NOVENTA",
            100 => "CIENTO",
            200 => "DOSCIENTOS",
            300 => "TRESCIENTOS",
            400 => "CUATROCIENTOS",
            500 => "QUINIENTOS",
            600 => "SEISCIENTOS",
            700 => "SETECIENTOS",
            800 => "OCHOCIENTOS",
            900 => "NOVECIENTOS",
        );
    }

    /* Genera el Subfijo de la Sifra */
    private function subfijo($value){

        /* Eliminar Espacios */
        $value = trim($value);

        /* Conocer longitud */
        $lenght = strlen($value);

        /* Calculo */
        if ($lenght >= 1 && $lenght <= 3) {
            $subfijo = "";
        }
        if ($lenght >= 4 && $lenght <= 6) {
            $subfijo = "MIL";
        }

        return $subfijo;
    }

    /* De Numeros A Letras */
    public function numtoletras($value_string, $subject = null){
        /* ARREGLO DE VALORES EN TEXTO */
        $arrayLetters = $this->arrayLetters();

        /* Eliminar Espacios y volver numero */
        $value = intval(trim($value_string));

        /* Ajusto la longitud de la cifra, para que sea divisible por centenas de miles (grupos de 6) */
        $num_string_full = $value_string;
        $cadena_str = "";

        for ($i = 0; $i < 3; $i++) {

            $num_substring = substr($num_string_full, $i * 6, 6);
            $i_auxiliar = 0;

            /* Inicializo el contador de centenas xi y establezco el límite a 6 dígitos en la parte entera */
            $limite = 6; 

            /* Bandera para controlar el ciclo del While */
            $end = true; 

            while ($end) {

                /* Si ya llegó al límite máximo de enteros */
                if ($i_auxiliar == $limite) { 
                    break; 
                }

                /* Comienzo con los tres primeros digitos de la cifra, comenzando por la izquierda */
                $digitos = ($limite - $i_auxiliar) * -1; 

                /* Obtengo la centena (los tres dígitos) */
                $num_substring = substr($num_substring, $digitos, abs($digitos)); 

                /* Ciclo para revisar centenas, decenas y unidades, en ese orden */
                for ($i2 = 1; $i2 < 4; $i2++) { 

                    switch ($i2) {

                        /* Checa las centenas */
                        case 1: 
                            if (!(substr($num_substring, 0, 3) < 100)){

                                $key = (int) substr($num_substring, 0, 3);

                                /* Busco si la centena es número redondo (100, 200, 300, 400, etc..) */
                                if (true === array_key_exists($key, $arrayLetters)) { 

                                    $xseek = $arrayLetters[$key];
                                    /* Devuelve el subfijo correspondiente (Millón, Millones, Mil o nada) */
                                    $xsub = $this->subfijo($num_substring); 
                                    if (substr($num_substring, 0, 3) == 100) {
                                        $cadena_str = " " . $cadena_str . " CIEN " . $xsub;
                                    } else {
                                        $cadena_str = " " . $cadena_str . " " . $xseek . " " . $xsub;
                                    }

                                    /* La centena fue redonda, entonces termino el ciclo del for y ya no reviso decenas ni unidades */
                                    $i2 = 3; 

                                } else { 

                                    /* Entra aquí si la centena no fue numero redondo (101, 253, 120, 980, etc.) */
                                    $key = (int) substr($num_substring, 0, 1) * 100;

                                    /* toma el primer caracter de la centena y lo multiplica por cien y lo busca en el arreglo (para que busque 100,200,300, etc) */
                                    $xseek = $arrayLetters[$key]; 
                                    $cadena_str = " " . $cadena_str . " " . $xseek;
                                }
                            }
                            break;
                        case 2: 
                            /* Checa las decenas (con la misma lógica que las centenas) */
                            if (!(substr($num_substring, 1, 2) < 10)){

                                $key = (int) substr($num_substring, 1, 2);

                                if (true === array_key_exists($key, $arrayLetters)) {

                                    $xseek = $arrayLetters[$key];
                                    $xsub = $this->subfijo($num_substring);
                                    if (substr($num_substring, 1, 2) == 20) {
                                        $cadena_str = " " . $cadena_str . " VEINTE " . $xsub;
                                    } else {
                                        $cadena_str = " " . $cadena_str . " " . $xseek . " " . $xsub;
                                    }
                                    $i2 = 3;

                                } else {

                                    $key = (int) substr($num_substring, 1, 1) * 10;
                                    $xseek = $arrayLetters[$key];
                                    if (20 == substr($num_substring, 1, 1) * 10) {
                                        $cadena_str = " " . $cadena_str . " " . $xseek;
                                    } else {
                                        $cadena_str = " " . $cadena_str . " " . $xseek . " Y ";
                                    }

                                }
                            }
                            break;
                        case 3: 
                            /* Checa las unidades */
                            if (!(substr($num_substring, 2, 1) < 1)) {

                                $key = (int) substr($num_substring, 2, 1);
                                /* obtengo directamente el valor de la unidad (del uno al nueve) */
                                $xseek = $arrayLetters[$key]; 
                                $xsub = $this->subfijo($num_substring);
                                $cadena_str = " " . $cadena_str . " " . $xseek . " " . $xsub;
                            }
                            break;
                    }
                }

                $i_auxiliar = $i_auxiliar + 3;

            }

            /* Si la cadena obtenida termina en MILLON o BILLON, entonces le agrega al final la conjuncion DE */
            if ((substr(trim($cadena_str), -5, 5) == "ILLON") && (!empty($subject))) {
                $cadena_str .= " DE";
            }

            /* Si la cadena obtenida en MILLONES o BILLONES, entoncea le agrega al final la conjuncion DE */
            if ((substr(trim($cadena_str), -7, 7) == "ILLONES") && (!empty($subject))) {
                $cadena_str .= " DE";
            }

            if (trim($num_substring) != "") {
                switch ($i) {
                    case 0:
                        if (trim(substr($num_string_full, $i * 6, 6)) == "1") {
                            $cadena_str .= "UN BILLON ";
                        } else {
                            $cadena_str .= " BILLONES ";
                        }
                        break;
                    case 1:
                        if (trim(substr($num_string_full, $i * 6, 6)) == "1") {
                            $cadena_str .= "UN MILLON ";
                        } else {
                            $cadena_str .= " MILLONES ";
                        }
                        break;
                    case 2:
                        if ($value < 1) {
                            $cadena_str = "CERO  ";
                        }
                        if ($value >= 1 && $value < 2) {
                            $cadena_str = "UN   ";
                        }
                        if ($value >= 2) {
                            $cadena_str .= "  ";
                        }
                        break;
                }
            }
            
            /* Limpiezas Cadenas */
            $cadena_str = str_replace("VEINTI ", "VEINTI", $cadena_str); 
            $cadena_str = str_replace("  ", " ", $cadena_str);
            $cadena_str = str_replace("UN UN", "UN", $cadena_str);
            $cadena_str = str_replace("  ", " ", $cadena_str);
            $cadena_str = str_replace("BILLON DE MILLONES", "BILLON DE", $cadena_str);
            $cadena_str = str_replace("BILLONES DE MILLONES", "BILLONES DE", $cadena_str);
            $cadena_str = str_replace("DE UN", "UN", $cadena_str);
        }

        return ucwords(strtolower(trim($cadena_str)));

    }

}
