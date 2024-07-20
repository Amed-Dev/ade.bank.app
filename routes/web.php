<?php
use App\Controllers\AuthController;

$requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$requestMethod = $_SERVER['REQUEST_METHOD'];

$controller = new AuthController();

switch ($requestUri) {
    case '/login':
        $controller->login();
        break;
    case '/register':
        $controller->register();
        break;
    case '/dashboard':
        $controller->dashboard();
        break;
    case '/cuenta_ahorros':
        $controller->cuenta_ahorros();
        break;
    case '/logout':
        $controller->logout();
        break;
    case '/my_profile':
        $controller->edit_profile();
        break;
    case (preg_match('/^\/user\/(.+)$/', $requestUri, $matches) ? true : false):
        $username = $matches[1];
        $controller->profile($username);
        break;
    case '/':
        if (!isset($_SESSION['user'])) {
            $controller->login();
        } else {
            header('location: /dashboard');
        }
        break;
    default:
        if (strpos($requestUri, '/api.php') === false) {
            $controller->pageNotFound();
        }
        break;
}
