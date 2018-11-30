<?php

Route::get('/', 'HomeController@index');

// passi i parametri tra graffe nel primo argomento; ? indica parametro opzionale
Route::get('/welcome/{name?}/{lastname?}/{age?}', 'WelcomeController@welcome')

// regex in where per controllare i parametri
->where([
    'name' => '[a-zA-Z]+',
    'lastname' => '[a-zA-Z]+',
    'age' => '[0-9]{1,3}'
]);

Route::get('/test', function () {
    return view('test');
});
