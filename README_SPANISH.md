# Convertir Números a Palabras en Laravel

Convierte fácilmente números a palabras en Laravel utilizando esta biblioteca, que aprovecha la extensión `PHP INTL` nativa para realizar conversiones sin esfuerzo. Con esta biblioteca, puedes convertir números a palabras en varios idiomas y también obtener el valor en formato de moneda según el idioma seleccionado. Los idiomas admitidos incluyen inglés, español, portugués, francés, italiano, rumano, hindi, polaco y persa (farsi).

⚙️ Esta biblioteca es compatible con las versiones de PHP +8.0 con Laravel 8.0 y superiores ⚙️

![Laravel 8.0+](https://img.shields.io/badge/Laravel-8.0%2B-orange.svg)
![Laravel 9.0+](https://img.shields.io/badge/Laravel-9.0%2B-orange.svg)
![Laravel 10.0+](https://img.shields.io/badge/Laravel-10.0%2B-orange.svg)

![logo-spell-number](https://github.com/alejandrodiazpinilla/SpellNumber/assets/51100789/e51cf045-26d0-44e0-a873-3034deaea046)

📖 [**DOCUMENTATION IN ENGLISH**](README.md) 📖

## Tabla de Contenidos

- [Instalación](#instalación)
- [Uso](#uso)
- [Creador](#creador)
- [Contribuyentes](#contribuyentes)
- [Licencia](#licencia)

## Instalación

Para instalar la dependencia a través de Composer, ejecuta el siguiente comando:

```shell
composer require rmunate/spell-number
```

Es importante asegurarse de que la extensión `intl` esté habilitada y cargada en el entorno.

## Uso

Después de instalar la dependencia en tu proyecto, puedes comenzar a usarla con los siguientes ejemplos:

#### Conocer las Configuraciones Regionales Soportadas

Para obtener la lista actual de idiomas compatibles, ejecuta el siguiente comando:

```php
SpellNumber::getAllLocales();
// array [
//    'de', // German
//    'en', // English
//    'es', // Spanish
//    'pt', // Portuguese
//    'fr', // French
//    'it', // Italian
//    'ro', // Romanian
//    'fa', // Farsi
//    'hi', // Hindi
//    'pl', // Polish
// ]
```

#### Convertir Enteros a Palabras

Puedes convertir fácilmente números a palabras definiendo la configuración regional a aplicar. Si no defines una configuración regional, se aplicará "en" (inglés) de forma predeterminada.

```php
SpellNumber::value(100)->locale('es')->toLetters();
// "Cien"

SpellNumber::value(100)->locale('fa')->toLetters();
// "صد"

SpellNumber::value(100)->locale('en')->toLetters();
// "One Hundred"

SpellNumber::value(100)->locale('hi')->toLetters();
// "एक सौ"
```

#### Convertir Números de Punto Flotante

Si es necesario, puedes pasar un número de punto flotante como argumento para convertirlo a palabras.

```php
SpellNumber::value(123456789.12)->locale('es')->toLetters();
// "Ciento Veintitrés Millones Cuatrocientos Cincuenta Y Seis Mil Setecientos Ochenta Y Nueve Con Doce"

SpellNumber::value(123456789.12)->locale('hi')->toLetters();
// "बारह करोड़ चौंतीस लाख छप्पन हज़ार सात सौ नवासी और बारह"
```

#### Convertir a Formato de Moneda

Este método puede ser útil para facturas, recibos y escenarios similares. Obtiene el valor proporcionado en formato de moneda.

```php
SpellNumber::value(100)->locale('es')->currency('pesos')->toMoney();
// "Cien Pesos"

SpellNumber::value(100.12)->locale('es')->currency('Pesos')->fraction('centavos')->toMoney();
// "Cien Pesos Con Doce Centavos"

SpellNumber::value(100)->locale('fa')->currency('تومان')->toMoney();
// "صد تومان"

SpellNumber::value(100.12)->locale('hi')->currency('रूपये')->fraction('पैसे')->toMoney();
// "एक सौ रूपये और बारह पैसे"

SpellNumber::value(100)->locale('hi')->currency('रूपये')->toMoney();
// "एक सौ रूपये"

SpellNumber::value(100.65)->locale('pl')->currency('złotych')->fraction('groszy')->toMoney();
// "Sto Złotych I Sześćdziesiąt Pięć Groszy"
```

#### Otros Métodos de Inicialización
Para admitir la versión 1.X, se mantienen los siguientes métodos de inicialización.

```php
// Entero, este método requiere estrictamente un valor entero que se envíe como argumento.
SpellNumber::integer(100)->locale('es')->toLetters();

// Números de punto flotante, este método requiere estrictamente un valor de cadena como argumento.
SpellNumber::float('12345.23')->locale('es')->toLetters();
```

## Creador
- 🇨🇴 Raúl Mauricio Uñate Castro
- Correo Electrónico: raulmauriciounate@gmail.com

## Contribuyentes

- [Siros Fakhri](https://github.com/sirosfakhri) (Idioma Farsi)
- [Ashok Devatwal](https://github.com/ashokdevatwal) (Idioma Hindi)
- [Olsza](https://github.com/olsza) (Idioma Polaco)
- [Jens Twesmann](https://github.com/jetwes) (German Language)

## Licencia
Este proyecto se encuentra bajo la [Licencia MIT](https://choosealicense.com/licenses/mit/).

🌟 ¡Apoya Mis Proyectos! 🚀

[![Hazte patrocinador](https://img.shields.io/badge/-Become%20a%20Sponsor-blue?style=for-the-badge&logo=github)](https://github.com/sponsors/rmunate)


Realiza cualquier contribución que consideres adecuada; el código es completamente tuyo. Juntos, podemos hacer cosas increíbles y mejorar el mundo del desarrollo. Tu apoyo es invaluable. ✨

Si tienes ideas, sugerencias o simplemente quieres colaborar, ¡estamos abiertos a todo! Únete a nuestra comunidad y sé parte de nuestro camino hacia el éxito. 🌐👩‍💻👨‍💻
