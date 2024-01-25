<?php

namespace App\Http;

use \Closure;
use Exception;

class Router
{
    private $url = '';

    private $prefix = '';

    private $routes = [];

    private Request $request;

    public function __construct($url)
    {
        $this->request = new Request();
        $this->url = $url;
        $this->setPrefix();
    }

    /**
     * Set the value of prefix
     *
     * @return  self
     */
    public function setPrefix()
    {
        $parseUrl = parse_url($this->url);
        $this->prefix = $parseUrl['path'] ?? '';
    }

    private function addRoute($method, $route, $params = [])
    {
        foreach ($params as $key => $value) {
            if ($value instanceof Closure) {
                $params['controller'] = $value;
                unset($params[$key]);
                continue;
            }
        }
        $patternRoute = '/^'.str_replace('/', '\/', $route).'$/';
        $this->routes[$patternRoute][$method] = $params;
    }

    public function get($route, $params = [])
    {
        $this->addRoute('GET', $route, $params);
    }

    public function post($route, $params = [])
    {
        $this->addRoute('POST', $route, $params);
    }

    public function put($route, $params = [])
    {
        $this->addRoute('PUT', $route, $params);
    }

    public function delete($route, $params = [])
    {
        $this->addRoute('DELETE', $route, $params);
    }

    private function getUri()
    {
        $uri = $this->request->getUri();
        $xUri = strlen($this->prefix) ? explode($this->prefix, $uri) : [$uri];

        return end($xUri);
    }

    private function getRoute()
    {
        $uri = $this->getUri();
        $httpMethod = $this->request->getHttpMethod();

        foreach ($this->routes as $patternRoute => $methods) {
            if (preg_match($patternRoute, $uri)) {
                if ($methods[$httpMethod]){
                    return $methods[$httpMethod];
                }
                throw new Exception("Method not allowed", 405);
            }
            //Method not allowed
        }

        throw new Exception("URL not found", 404);
    }

    public function run()
    {
        try {
            $route = $this->getRoute();
            
            if (!isset($route['controller'])) {
                throw new Exception('An error occurred in the application', 500);
            }

            $args = [];
            return call_user_func_array($route['controller'], $args);

        } catch (Exception $e) {
            return new Response($e->getCode(), $e->getMessage());
        }
    }
}
