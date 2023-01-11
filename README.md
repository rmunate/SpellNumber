# Convertir números en Letras Laravel / PHP
Convierta de números a letras, con la opción de determinar si es para uso en facturas y la moneda a usar. 

[![N|Solid](https://i.ibb.co/ZLzQTpm/Firma-Git-Hub.png)](#)

Convierta de manera sencilla números a letras (Solo en idioma español), esta librería le puede ser útil para usar el valor en letras dentro de facturas, remisiones, etc. Puede retornar los valores como numero o como valor numérico de algún tipo de dinero en específico.

## Instalación
# Instalar Con Composer

```sh
composer require rmunate/spell-number
```

## Generalidades

- El número más grande aceptado es 999999999999999999
- El decimal más grande aceptado es 99
- El método `->current('PESO')` asigna una S o ES al final en caso de que el numero sea mayor a 1, de no usarse, usará el valor PESO / PESOS
- El método  `->fraction('CENTAVO')` asigna una S al final en caso de que el numero sea mayor a 1, de no usarse, usará el valor CENTAVO / CENTAVOS
- El metodo `::float('1000.10')` solo recibe valores en formato String con separacion por coma o punto.

## Métodos

|       LLAMADO METODOS CLASE       |       DESCRIPCIÓN METODO       |
| ------ | ------ |
| ``` SpellNumber::integer(1000)->toLetters() ``` | Retorna el valor en letras "Capital Case".  |
| ``` SpellNumber::float('1000,10')->toLetters() ``` | Retornar los valores en letras relacionando los dos valores con el conector " _ con _". |
| ``` SpellNumber::integer(1000)->toMoney() ``` | Retorna el valor en letras "Capital Case" como valor de moneda en letras.  |
| ``` SpellNumber::integer(1000)->currency('DOLAR')->toMoney() ``` | Retorna el valor en letras "Capital Case" como valor de "en este caso Dolares" en letras.  |
| ``` SpellNumber::integer(1000)->currency('DOLAR')->fraction('CENTAVO')->toMoney() ``` | Retorna el valor en letras "Capital Case" como valor de "en este caso Dolares y Centavos" en letras.  |
| ``` SpellNumber::float('1000.50')->toMoney() ``` | Retorna el valor en letras "Capital Case" como valor de moneda en letras.  |
| ``` SpellNumber::float('1000.50')->currency('DOLAR')->toMoney() ``` | Retorna el valor en letras "Capital Case" como valor de "en este caso Dolares" en letras.  |
| ``` SpellNumber::float('1000.50')->currency('DOLAR')->fraction('CENTAVO')->toMoney() ``` | Retorna el valor en letras "Capital Case" como valor de "en este caso Dolares y Centavos" en letras.  |

# Ejemplo de Uso
```sh
SpellNumber::float('2000,50')->currency('Sol')->fraction('Centimo')->toMoney();
// "Dos Mil Soles Con Cincuenta Centimos"
```

## Desarrollador(es)

- Ingeniero, Raúl Mauricio Uñate Castro
- raulmauriciounate@gmail.com
- (Se reciben recomendaciones y mejoras al correo electronico.)

## Open Source
- MIT

