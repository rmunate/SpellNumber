# Convertir de números a Letras en Laravel

Convierta fácilmente números a letras en Laravel utilizando esta biblioteca, que admite la extensión nativa PHP INTL para realizar la conversión de manera sencilla. Con esta librería, puede convertir números a letras en varios idiomas y también obtener el valor en formato de moneda según el idioma seleccionado. Los idiomas con soporte incluyen inglés, español, portugués, francés, italiano y rumano.

⚙️ Esta librería es compatible con versiones de Laravel 8.0 y superiores ⚙️

![Laravel 8.0+](https://img.shields.io/badge/Laravel-8.0%2B-orange.svg)
![Laravel 9.0+](https://img.shields.io/badge/Laravel-9.0%2B-orange.svg)
![Laravel 10.0+](https://img.shields.io/badge/Laravel-10.0%2B-orange.svg)

![SpellNumbers](https://github.com/rmunate/SpellNumber/assets/91748598/f2aea68b-fc9f-46be-ae54-a4955f0ce7a2)

## Tabla de Contenidos
- [Instalación](#instalación)
- [Uso](#uso)
- [Creador](#creador)
- [Licencia](#licencia)

## Instalación
Para instalar la dependencia a través de Composer, ejecuta el siguiente comando:

```shell
composer require rmunate/spell-number
```

Es importante asegurarse de que la extensión `intl` esté habilitada y cargada en el entorno.

## Uso
Después de instalar la dependencia en tu proyecto, puedes empezar a usarla con los siguientes ejemplos:

```php
// OBTENER LOS IDIOMAS DISPONIBLES
SpellNumber::getAllLocales();
// array:6 [▼ //
//     0 => "en"
//     1 => "es"
//     2 => "pt"
//     3 => "fr"
//     4 => "it"
//     5 => "ro"
// ]

// CONVERTIR ENTERO A LETRAS
SpellNumber::value(100)->locale('es')->toLetters();
// "Cien"
SpellNumber::value(12300000)->locale('es')->toLetters();
// "Doce Millones Trescientos Mil"

// CONVERTIR FLOAT A LETRAS
SpellNumber::value(123456789.12)->locale('es')->toLetters();
// "Ciento Veintitrés Millones Cuatrocientos Cincuenta Y Seis Mil Setecientos Ochenta Y Nueve Con Doce"

// CONVERTIR ENTERO A FORMATO TEXTO MONEDA
SpellNumber::value(100)->locale('es')->currency('pesos')->toMoney();
// "Cien Pesos"
SpellNumber::value(100.12)->locale('es')->currency('Pesos')->fraction('centavos')->toMoney();
// "Cien Pesos Con Doce Centavos"

// OTROS MÉTODOS DE INICIO 

// Entero, este método requiere de forma estricta que se envíe un valor entero como argumento.
SpellNumber::integer(100)->locale('es')->toLetters();

// Flotantes, este método requiere de forma estricta que se envíe un valor de cadena de texto como argumento.
SpellNumber::float('12345.23')->locale('es')->toLetters();
```

## Creador
- 🇨🇴 Raúl Mauricio Uñate Castro
- Correo electrónico: raulmauriciounate@gmail.com

## Licencia
Este proyecto se encuentra bajo la [Licencia MIT](https://choosealicense.com/licenses/mit/).