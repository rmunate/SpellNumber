<?php

use Orchestra\Testbench\TestCase;
use Rmunate\Utilities\SpellNumber;

class SpellNumberTest extends TestCase
{
    // Test conversion of numerical value to letters in various locales
    public function testToLetters()
    {
        // English locale
        $this->assertSame('one hundred', SpellNumber::value(100)->locale('en')->toLetters());

        // Spanish locale
        $this->assertSame('cien', SpellNumber::value(100)->locale('es')->toLetters());

        // Farsi (Persian) locale
        $this->assertSame('صد', SpellNumber::value(100)->locale('fa')->toLetters());

        // Hindi locale
        $this->assertSame('एक सौ', SpellNumber::value(100)->locale('hi')->toLetters());

        // Test conversion of floating-point value to letters in English locale
        $this->assertSame('one hundred twenty-three million four hundred fifty-six thousand seven hundred eighty-nine and twelve', SpellNumber::value(123456789.12)->locale('en')->toLetters());

        // Test conversion of integer to letters in English locale
        $this->assertSame('one hundred', SpellNumber::integer(100)->locale('en')->toLetters());

        // Test conversion of floating-point value to letters in English locale
        $this->assertSame('twelve thousand three hundred forty-five and two hundred thirty', SpellNumber::float('12345.230')->locale('en')->toLetters());
    }

    // Test conversion of numerical value to money representation in different locales
    public function testToMoney()
    {
        // English locale with 'Dollars' currency
        $this->assertSame('one hundred Dollars', SpellNumber::value(100)->locale('en')->currency('Dollars')->toMoney());

        // Spanish locale with 'Pesos' currency
        $this->assertSame('cien Pesos', SpellNumber::value(100)->locale('es')->currency('Pesos')->toMoney());

        // Hindi locale with 'रूपये' currency
        $this->assertSame('एक सौ रूपये', SpellNumber::value(100)->locale('hi')->currency('रूपये')->toMoney());

        // Test conversion of integer to money representation in Spanish locale
        $this->assertSame('cien Pesos', SpellNumber::integer(100)->locale('es')->currency('Pesos')->toMoney());

        // Test conversion of floating-point value to money representation in Spanish locale
        $this->assertSame('doce mil trescientos cuarenta y cinco Pesos con doscientos treinta Centavos', SpellNumber::float('12345.230')->locale('es')->currency('Pesos')->fraction('Centavos')->toMoney());
    }
}
