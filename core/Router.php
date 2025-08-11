<?php
class Router {
    public function run() {
        $controllerName = $_GET['controller'] ?? 'blog';
        $actionName = $_GET['action'] ?? 'index';

        $controllerClass = ucfirst($controllerName) . 'Controller';

        if (class_exists($controllerClass)) {
            $controller = new $controllerClass();

            if (method_exists($controller, $actionName)) {
                $controller->$actionName();
            } else {
                echo "Action '$actionName' introuvable.";
            }
        } else {
            echo "Contrôleur '$controllerClass' introuvable.";
        }
    }
}
