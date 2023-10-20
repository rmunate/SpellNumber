<?php

use PHPUnit\Framework\TestCase;
use Rmunate\Utilities\SpellNumber;

class SpellNumberTest extends TestCase
{
    public function testToLetters()
    {
        //Value
        $this->assertEquals(SpellNumber::value(100)->locale('en')->toLetters(), 'One Hundred');
        $this->assertEquals(SpellNumber::value(100)->locale('es')->toLetters(), 'Cien');
        $this->assertEquals(SpellNumber::value(100)->locale('fa')->toLetters(), 'صد');
        $this->assertEquals(SpellNumber::value(100)->locale('hi')->toLetters(), 'एक सौ');
        $this->assertEquals(SpellNumber::value(123456789.12)->locale('en')->toLetters(), 'One Hundred Twenty-Three Million Four Hundred Fifty-Six Thousand Seven Hundred Eighty-Nine And Twelve');

        //Integer
        $this->assertEquals(SpellNumber::integer(100)->locale('en')->toLetters(), 'One Hundred');

        //Float
        $this->assertEquals(SpellNumber::float('12345.230')->locale('en')->toLetters(), 'Twelve Thousand Three Hundred Forty-Five And Two Hundred Thirty');
    }

    public function testToMoney()
    {
        //Value
        $this->assertEquals(SpellNumber::value(100)->locale('en')->currency('Dollars')->toMoney(), 'One Hundred Dollars');
        $this->assertEquals(SpellNumber::value(100)->locale('es')->currency('Pesos')->toMoney(), 'Cien Pesos');
        $this->assertEquals(SpellNumber::value(100)->locale('hi')->currency('रूपये')->toMoney(), 'एक सौ रूपये');

        //Integer
        $this->assertEquals(SpellNumber::integer(100)->locale('es')->currency('Pesos')->toMoney(), 'Cien Pesos');

        //Float
        $this->assertEquals(SpellNumber::float('12345.230')->locale('es')->currency('Pesos')->fraction('Centavos')->toMoney(), 'Doce Mil Trescientos Cuarenta Y Cinco Pesos Con Doscientos Treinta Centavos');
    }
}
