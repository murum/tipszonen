<?php

Route::get('/', function()
{
    return [
        'HOST' => getenv('DB_HOST'),
        'NAME' => getenv('DB_NAME'),
        'USERNAME' => getenv('DB_USERNAME'),
        'PASSWORD' => getenv('DB_PASSWORD'),
        'ENVIRONMENT' => App::environment()
    ];
});
