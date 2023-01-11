# CONVI
Convierta de números a letras, con la opción de determinar si es para uso en facturas y la moneda a usar. 

[![N|Solid](https://i.ibb.co/ZLzQTpm/Firma-Git-Hub.png)](#)

Convierta de manera sencilla números a letras (Solo en idioma español), esta librería le puede ser útil para usar el valor en letras dentro de facturas, remisiones, etc. Puede retornar los valores como numero o como valor numérico de algún tipo de dinero en específico.

## Instalación
# Instalar Con Composer

```sh
composer require rmunate/spell-number
```

## Métodos

|       LLAMADO METODOS CLASE       |       DESCRIPCIÓN METODO       |
| ------ | ------ |
| ``` SpellNumber::integer(1000)->toLetters() ``` | `Recibe Solo Enteros Positivos` Retorna el valor en letras "Capital Case". El número mas grande aceptado es 999999999999999999 |
| ``` SpellNumber::float('1000,10')->toLetters() ``` | `Recibe Solo String con separador con punto o con coma` Retornar los valores en letras relacionando los dos valores con el conector " _ con _". El numero mas grande aceptado es 999999999999999999 y el decimal mas grande aceptado es 99 |


## Desarrollador(es)

- Ingeniero, Raúl Mauricio Uñate Castro
- raulmauriciounate@gmail.com
- (Se reciben recomendaciones y mejoras al correo electronico.)

## Open Source
- MIT

