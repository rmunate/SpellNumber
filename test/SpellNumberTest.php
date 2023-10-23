<?php

use PHPUnit\Framework\TestCase;
use Rmunate\Utilities\SpellNumber;

class SpellNumberTest extends TestCase
{
    // Test conversion of numerical value to letters in various locales
    public function testToLetters()
    {
        // English locale
        $this->assertEquals(SpellNumber::value(100)->locale('en')->toLetters(), 'One Hundred');

        // Spanish locale
        $this->assertEquals(SpellNumber::value(100)->locale('es')->toLetters(), 'Cien');

        // Farsi (Persian) locale
        $this->assertEquals(SpellNumber::value(100)->locale('fa')->toLetters(), 'صد');

        // Hindi locale
        $this->assertEquals(SpellNumber::value(100)->locale('hi')->toLetters(), 'एक सौ');

        // Test conversion of floating-point value to letters in English locale
        $this->assertEquals(SpellNumber::value(123456789.12)->locale('en')->toLetters(), 'One Hundred Twenty-Three Million Four Hundred Fifty-Six Thousand Seven Hundred Eighty-Nine And Twelve');

        // Test conversion of integer to letters in English locale
        $this->assertEquals(SpellNumber::integer(100)->locale('en')->toLetters(), 'One Hundred');

        // Test conversion of floating-point value to letters in English locale
        $this->assertEquals(SpellNumber::float('12345.230')->locale('en')->toLetters(), 'Twelve Thousand Three Hundred Forty-Five And Two Hundred Thirty');
    }

    // Test conversion of numerical value to money representation in different locales
    public function testToMoney()
    {
        // English locale with 'Dollars' currency
        $this->assertEquals(SpellNumber::value(100)->locale('en')->currency('Dollars')->toMoney(), 'One Hundred Dollars');

        // Spanish locale with 'Pesos' currency
        $this->assertEquals(SpellNumber::value(100)->locale('es')->currency('Pesos')->toMoney(), 'Cien Pesos');

        // Hindi locale with 'रूपये' currency
        $this->assertEquals(SpellNumber::value(100)->locale('hi')->currency('रूपये')->toMoney(), 'एक सौ रूपये');

        // Test conversion of integer to money representation in Spanish locale
        $this->assertEquals(SpellNumber::integer(100)->locale('es')->currency('Pesos')->toMoney(), 'Cien Pesos');

        // Test conversion of floating-point value to money representation in Spanish locale
        $this->assertEquals(SpellNumber::float('12345.230')->locale('es')->currency('Pesos')->fraction('Centavos')->toMoney(), 'Doce Mil Trescientos Cuarenta Y Cinco Pesos Con Doscientos Treinta Centavos');
    }
}
