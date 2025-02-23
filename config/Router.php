<?php
class Router
{
    private $routes = [];

    public function add($method, $path, $handler)
    {
        $this->routes[] = [
            "method" => $method,
            "path" => $path,
            "handler" => $handler,
        ];
    }

    public function dispatch($requestUri)
    {
        foreach ($this->routes as $route) {
            if (
                $route["path"] === $requestUri &&
                $route["method"] === $_SERVER["REQUEST_METHOD"]
            ) {
                list($controller, $action) = explode("@", $route["handler"]);
                require "../app/controllers/$controller.php";
                $controllerInstance = new $controller($GLOBALS["pdo"]);
                $controllerInstance->$action();
                return;
            }
        }
        http_response_code(404);
        echo "404 Not Found";
    }
}
?>
