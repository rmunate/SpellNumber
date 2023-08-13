# Convertir Números a Letras en Laravel

Convierte fácilmente números a letras en Laravel utilizando esta biblioteca, que emplea la extensión nativa `PHP INTL` para realizar la conversión de manera sencilla. Con esta librería, puedes convertir números a letras en varios idiomas y también obtener el valor en formato de moneda según el idioma seleccionado. Los idiomas con soporte incluyen inglés, español, portugués, francés, italiano, rumano y gracias a la colaboración de [Siros Fakhri](https://github.com/sirosfakhri), también se ha agregado soporte para persa (Farsi).

⚙️ Esta librería es compatible con versiones de Laravel 8.0 y superiores ⚙️

![Laravel 8.0+](https://img.shields.io/badge/Laravel-8.0%2B-orange.svg)
![Laravel 9.0+](https://img.shields.io/badge/Laravel-9.0%2B-orange.svg)
![Laravel 10.0+](https://img.shields.io/badge/Laravel-10.0%2B-orange.svg)

![SpellNumbers](https://github.com/rmunate/SpellNumber/assets/91748598/f2aea68b-fc9f-46be-ae54-a4955f0ce7a2)

## Tabla de Contenidos

- [Instalación](#instalación)
- [Uso](#uso)
- [Creador](#creador)
- [Contribuidores](#contribuidores)
- [Licencia](#licencia)

## Instalación

Para instalar la dependencia a través de Composer, ejecuta el siguiente comando:

```shell
composer require rmunate/spell-number
```

Es importante asegurarse de que la extensión `intl` esté habilitada y cargada en el entorno.

## Uso

Después de instalar la dependencia en tu proyecto, puedes empezar a usarla con los siguientes ejemplos:

#### Conocer las Configuraciones Regionales con Soporte

Para obtener el listado actual de idiomas con soporte, ejecuta el siguiente comando:

```php
SpellNumber::getAllLocales();
// array:7 [▼
//     0 => "en" (Inglés)
//     1 => "es" (Español)
//     2 => "pt" (Portugués)
//     3 => "fr" (Francés)
//     4 => "it" (Italiano)
//     5 => "ro" (Rumano)
//     6 => "fa" (Farsi)
// ]
```

#### Convertir Números Enteros a Letras

Puedes convertir fácilmente números a letras definiendo la configuración regional a aplicar. Si no defines la configuración regional, por defecto se aplicará "en" (Inglés).

```php
SpellNumber::value(100)->locale('es')->toLetters();
// "Cien"

SpellNumber::value(100)->locale('fa')->toLetters();
// "صد"

SpellNumber::value(100)->locale('en')->toLetters();
// "One Hundred"
```

#### Convertir Números de Coma Flotante

Si lo necesitas, puedes enviar un número de coma flotante como argumento para convertirlo a letras.

```php
SpellNumber::value(123456789.12)->locale('es')->toLetters();
// "Ciento Veintitrés Millones Cuatrocientos Cincuenta Y Seis Mil Setecientos Ochenta Y Nueve Con Doce"
```

#### Convertir a Formato Moneda

Este método puede ser útil para facturas, remisiones y similares. Obtén el valor suministrado en formato moneda.

```php
SpellNumber::value(100)->locale('es')->currency('pesos')->toMoney();
// "Cien Pesos"

SpellNumber::value(100.12)->locale('es')->currency('Pesos')->fraction('centavos')->toMoney();
// "Cien Pesos Con Doce Centavos"

SpellNumber::value(100)->locale('fa')->currency('تومان')->toMoney();
// "صد تومان"
```

#### Otros Métodos Inicializadores

Para dar soporte a la versión 1.X, se mantienen los siguientes inicializadores.

```php
// Entero, este método requiere de forma estricta que se envíe un valor entero como argumento.
SpellNumber::integer(100)->locale('es')->toLetters();

// Flotantes, este método requiere de forma estricta que se envíe un valor de cadena de texto como argumento.
SpellNumber::float('12345.23')->locale('es')->toLetters();
```

## Creador

- 🇨🇴 Raúl Mauricio Uñate Castro
- Correo electrónico: raulmauriciounate@gmail.com

## Contribuidores
<a href="https://github.com/sirosfakhri">
    <img src="https://avatars.githubusercontent.com/u/56381478?v=4" alt="Imagen de perfil" width="40" height="40" style="border-radius: 50%;">
</a>
[Siros Fakhri](https://github.com/sirosfakhri)

## Licencia

Este proyecto se encuentra bajo la [Licencia MIT](https://choosealicense.com/licenses/mit/).