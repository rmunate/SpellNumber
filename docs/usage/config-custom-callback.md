---
title: Callback
editLink: true
outline: deep
---

# Callback

In the same configuration file `spell-number.php`, you will have a callback that you can use to do any type of treatment at the output of the packet processing.

``` php
return [
  //...
  'callback_output' => function ($data) {

    // Your logic here...

    return $data->getWords();
  }, 
]
```

Inside the callback you will have a variable `$data`, which contains the necessary information so that you can execute any type of process within this space.

If you print the $data variable, you will find an instance of the `Rmunate\Utilities\Callback\DataResponse` object that allows you to access the following values.

``` php
dd($data);

// Rmunate\Utilities\Callback\DataResponse {
//   #method: "toMoney"
//   #type: "double"
//   #lang: "en"
//   #locale: "en_US"
//   #currency: "Dollars"
//   #fraction: "Cents"
//   +value: "12345.230"
//   +words: "Twelve Thousand Three Hundred Forty-Five Dollars And Two Hundred Thirty Cents"
// }
```

Easily access any property of this object with the syntax `$data->words`, likewise, this object contains getters to obtain the values if you prefer it that way `$data->getWords()`.

::: warning IMPORTANT
Remember that you must return the final value after executing all the actions you want on the package output values.
`return $value`.

