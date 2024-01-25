<?php
require __DIR__ . '/vendor/autoload.php';

use \App\Controller\Pages\HomeController;
use \App\Http\Router;
use \App\Http\Response;

define('URL', 'http://localhost/prod1');

$router = new Router(URL);

include __DIR__ . '/routes/pages.php';

$router->run()
       ->sendResponse();
