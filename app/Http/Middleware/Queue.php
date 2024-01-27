<?php

namespace App\Http\Middleware;

use \Closure;
use App\Http\Request;
use App\Http\Response;

class Queue
{
    /**
     * middleware mapping
     * @var array
     */
    private static $map = [];

    /**
     * Middleware mapping that should execute everywhere
     * @var array
     */
    private static $default = [];
    /**
     * middleware queues to be executed
     * @var array
     */
    private $middlewares = [];

    /**
     * Controller execution function
     * @var Closure
     */
    private $controller;

    /**
     * Controller function args
     * @var array
     */
    private $controllerArgs = [];

    /**
     * Constructs the class of middleware queues
     * @param array $middlewares
     * @param Closure $controller
     * @param array $controllerArgs
     */
    public function __construct($middlewares, $controller, $controllerArgs)
    {
        $this->middlewares = array_merge(self::$default, $middlewares);
        $this->controller = $controller;
        $this->controllerArgs = $controllerArgs;
    }

    /**
     * sets the middleware mapping
     * @param array $map
     */
    public static function setMap($map)
    {
        self::$map = $map;
    }

        /**
     * sets the default middleware mapping
     * @param array $map
     */
    public static function setDefault($default)
    {
        self::$default = $default;
    }


    /**
     * @param Request $request
     * 
     * @return Response
     */
    public function next($request)
    {
        if (empty($this->middlewares)) {
            return call_user_func_array($this->controller, $this->controllerArgs);
        }

        $middleware = array_shift($this->middlewares);

        if (!isset(self::$map[$middleware])) {
            throw new \Exception("A problem occurred while processing a middleware", 500);
        }

        $queue = $this;
        $next = function($request) use($queue) {
            return $queue->next($request);
        };

        return (new self::$map[$middleware])->handle($request, $next);
    }
}
