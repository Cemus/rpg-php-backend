<?php
namespace Config;

class Router
{
    private static ?Router $instance = null;
    private $routes = [];

    private function __construct()
    {
    }

    public static function getInstance(): Router
    {
        if (self::$instance === null) {
            self::$instance = new Router();
        }
        return self::$instance;
    }

    public function add(string $method, string $path, callable $callback, array $middlewares = [])
    {
        $this->routes[] = compact('method', 'path', 'callback', 'middlewares');
    }

    public function dispatch()
    {
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $method = $_SERVER['REQUEST_METHOD'];

        $request = new \Config\Request();


        foreach ($this->routes as $route) {
            if ($route['path'] === $uri && $route['method'] === $method) {

                foreach ($route['middlewares'] as $mw) {
                    $res = \call_user_func($mw, $request);
                    if ($res === false)
                        return;
                }


                \call_user_func($route['callback'], $request);
                return;
            }
        }

        http_response_code(404);
        echo json_encode(['status' => 'error', 'message' => 'Not found']);
    }
}