<?php

$request_method = $_SERVER['REQUEST_METHOD'];
$request_uri = $_SERVER['REQUEST_URI'];

switch ($request_uri) {
    case '/':
        require_once 'pages/MainPage.php';
        $handler = new pages\MainPage();
        $handler->handle();
        break;
    case '/login':
        require_once 'pages/LoginPage.php';
        $handler = new pages\LoginPage();
        $handler->handle();
        break;
    case '/reg_page':
        require_once 'pages/RegPage.php';
        $handler = new pages\RegPage();
        $handler->handle();
        break;
    case '/reg':
        require_once 'api/handlers/Registration.php';
        $handler = new api\handlers\RegistrationHandler();
        $handler->handle();
        break;
    case '/auth':
        require_once 'api/handlers/Authorization.php';
        $handler = new api\handlers\AuthorizationHandler();
        $handler->handle();
        break;
    case '/create':
        require_once 'api/handlers/BulletinCreate.php';
        $handler = new api\handlers\BulletinCreateHandler();
        $handler->handle();
        break;
    case '/get':
        require_once 'api/handlers/GetBulletins.php';
        $handler = new api\handlers\GetBulletinsHandler();
        $handler->handle();
        break;
    default:
        http_response_code(404);
        echo 'Not Found';
        break;
}