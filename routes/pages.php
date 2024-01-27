<?php
 
use \App\Http\Response;
use \App\Controller\Pages;

$router->get('/', [
    'middlewares' => [
        'maintenance'
    ],
    function () {
        return new Response(200, Pages\HomeController::getHome());
    }
]);

$router->get('/about', [
    function () {
        return new Response(200, Pages\AboutController::getAbout());
    }
]);

$router->get('/testimonies', [
    function ($request) {
        return new Response(200, Pages\TestimonyController::getTestimonies($request));
    }
]);


$router->post('/testimonies', [
    function ($request) {
        return new Response(200, Pages\TestimonyController::insertTestimony($request));
    }
]);