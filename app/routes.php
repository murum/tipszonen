<?php

Route::get('/', function()
{
    return [
        'HOST' => $_ENV['DB_HOST'],
        'NAME' => $_ENV['DB_NAME'],
        'USERNAME' => $_ENV['DB_USERNAME'],
        'PASSWORD' => $_ENV['DB_PASSWORD'],
        'ENVIRONMENT' => App::environment()
    ];
});
