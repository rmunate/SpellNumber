# Convertir números en Letras Laravel / PHP
Convierta de números a letras, de forma facil para implementar en Facturas, Remisiones u otros. 

[![N|Solid](https://i.ibb.co/ZLzQTpm/Firma-Git-Hub.png)](#)

Convierta de manera sencilla números a letras (Solo en idioma Español), esta librería le puede ser útil para usar el valor en letras dentro de facturas, remisiones, etc. Puede retornar los valores en letras de solo números o tambien definiendo un tipo de moneda.

## Instalación
# Instalar a través de Composer

```console
composer require rmunate/spell-number 1.0.x-dev
```

## Generalidades
- El número entero más grande aceptado es 999999999999999999
- El decimal más grande aceptado es 99
- El método `->current('PESO')` asigna una S o ES al final en caso de que el numero sea mayor a 1, de no usarse, usará el valor PESO / PESOS
- El método  `->fraction('CENTAVO')` asigna una S o ES al final en caso de que el numero sea mayor a 1, de no usarse, usará el valor CENTAVO / CENTAVOS
- El metodo `::float('1000.10')` solo recibe valores en formato String con separacion por coma o punto.

## Métodos

|       LLAMADO METODOS CLASE       |       DESCRIPCIÓN METODO       |
| ------ | ------ |
| ``` SpellNumber::integer(1000)->toLetters() ``` | Retorna el valor en letras "Capital Case".  |
| ``` SpellNumber::float('1000,10')->toLetters() ``` | Retornar los valores en letras relacionando los dos valores con el conector "coma". |
| ``` SpellNumber::integer(1000)->toMoney() ``` | Retorna el valor en letras "Capital Case" como valor de moneda en letras.  |
| ``` SpellNumber::integer(1000)->currency('DOLAR')->toMoney() ``` | Retorna el valor en letras "Capital Case" como valor de "en este caso Dolares" en letras.  |
| ``` SpellNumber::integer(1000)->currency('DOLAR')->fraction('CENTAVO')->toMoney() ``` | Retorna el valor en letras "Capital Case" como valor de "en este caso Dolares y Centavos" en letras.  |
| ``` SpellNumber::float('1000.50')->toMoney() ``` | Retorna el valor en letras "Capital Case" como valor de moneda en letras.  |
| ``` SpellNumber::float('1000.50')->currency('DOLAR')->toMoney() ``` | Retorna el valor en letras "Capital Case" como valor de "en este caso Dolares" en letras.  |
| ``` SpellNumber::float('1000.50')->currency('DOLAR')->fraction('CENTAVO')->toMoney() ``` | Retorna el valor en letras "Capital Case" como valor de "en este caso Dolares y Centavos" en letras.  |

# Ejemplo de Uso
```php
SpellNumber::float('2000,50')->currency('Sol')->fraction('Centimo')->toMoney();
// "Dos Mil Soles Con Cincuenta Centimos"

SpellNumber::float('2000,50')->toMoney();
// "Dos Mil Pesos Con Cincuenta Centavos"

```

## Desarrollador(es)
- Ingeniero, Raúl Mauricio Uñate Castro
- raulmauriciounate@gmail.com
- (Se reciben recomendaciones y mejoras al correo electronico.)

## Open Source
- MIT

