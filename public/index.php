<?php 

require_once '../vendor/autoload.php';

//echo "¡Hola mundo!";

use Aura\Router\RouterContainer;

session_start();
//Son capturadas las request en las variables superglobales.
$request = Zend\Diactoros\ServerRequestFactory::fromGlobals(
    $_SERVER,
    $_GET,
    $_POST,
    $_COOKIE,
    $_FILES
);

$routerContainer = new RouterContainer();

//Creamos un mapa de rutas
$map = $routerContainer->getMap();
$rootDir = basename(dirname(__DIR__, 1));
//Index
$map->get('index', '/'.$rootDir.'/', [
    'controller' => 'App\Controllers\IndexController',
    'action' => 'indexAction'
    ]);
//Login
$map->post('login', '/'.$rootDir.'/sign-in', [
    'controller' => 'App\Controllers\AuthController',
    'action' => 'getLogin'
    ]);
$map->get('logout', '/'.$rootDir.'/logout', [
    'controller' => 'App\Controllers\AuthController',
    'action' => 'getLogout'
    ]);

//Posts
$map->get('posts', '/'.$rootDir.'/posts', [
    'controller' => 'App\Controllers\PostController',
    'action' => 'getIndex',
    'needsAuth' => true
    ]);
$map->post('addPost', '/'.$rootDir.'/posts', [
    'controller' => 'App\Controllers\PostController',
    'action' => 'addPost'
    ]);
$map->get('updatePostGet', '/'.$rootDir.'/postUpdate', [
    'controller' => 'App\Controllers\PostController',
    'action' => 'updatePost'
    ]);
$map->post('updatePost', '/'.$rootDir.'/postUpdate', [
    'controller' => 'App\Controllers\PostController',
    'action' => 'updatePost'
    ]);
$map->get('deletePostGet', '/'.$rootDir.'/postDelete', [
    'controller' => 'App\Controllers\PostController',
    'action' => 'deletePost'
    ]);
$map->post('deletePost', '/'.$rootDir.'/postDelete', [
    'controller' => 'App\Controllers\PostController',
    'action' => 'deletePost'
    ]);
//Creamos el validador de rutas
$matcher = $routerContainer->getMatcher();

//Obtenermos la ruta según la petición
$route = $matcher->match($request);

//Validamos que la ruta sea correcta y emitimos la respuesta correspondiente.
if (!$route){
	echo basename(dirname(__DIR__, 1))."Ruta no encontrada.";
}
else{
    //El manejador de la ruta contiene la información básica de la misma
    $handlerData = $route->handler;
    $controllerName = new $handlerData['controller'];
    $actionName = $handlerData['action'];
    $needsAuth = $handlerData['needsAuth'] ?? false; //Se comprueba si el usuario necesita autenticarse
    $sessionUserId = $_SESSION['access_token'] ?? null;
    $responseMessage = null;
    if ($needsAuth && !$sessionUserId) {

        $controllerName = 'App\Controllers\AuthController';
        $actionName = 'getLogout' ;
    }

    $controller = new $controllerName;
    $response = $controller->$actionName($request);

    foreach ($response->getHeaders() as $name => $values) {
        foreach ($values as $value) {
            
                header(sprintf('%s: %s', $name, $value), false);
        }
    }
    http_response_code($response->getStatusCode());
    echo $response->getBody();
}