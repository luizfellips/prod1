<?php

require __DIR__ . '/../vendor/autoload.php';

use App\DatabaseManager\Database;
use App\Utils\View;
use App\Utils\Env;
use \App\Http\Middleware\Queue as MiddlewareQueue;

Env::load(__DIR__ . '/../');

define('URL', getenv('URL'));

Database::setConfiguration(
    getenv('DB_HOST'),
    getenv('DB_NAME'),
    getenv('DB_USER'),
    getenv('DB_PASS'),
    getenv('DB_PORT'),
);

View::init([
    'URL' => URL,
]);

MiddlewareQueue::setMap([
    'maintenance' => \App\Http\Middleware\Maintenance::class,
]);


MiddlewareQueue::setDefault([
    'maintenance'
]);