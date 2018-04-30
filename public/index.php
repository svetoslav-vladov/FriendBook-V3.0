<?php

require_once '../app/bootstrap.php';

spl_autoload_register(function ($class) {

    $class = str_replace('\\', DIRECTORY_SEPARATOR, $class) . '.php';

    require_once APP_ROOT . DIRECTORY_SEPARATOR . $class;
});

ini_set('mbstring.internal_encoding', 'UTF-8');
header('Content-Type: text/html; charset=UTF-8');

$fileNotFound = false;

if(isset($_SESSION['logged'])){
    $controllerName = isset($_GET['target']) ? $_GET['target'] : 'index';
    $methodName = isset($_GET['action']) ? $_GET['action'] : 'main';
}
else{
    $controllerName = isset($_GET['target']) ? $_GET['target'] : 'index';
    $methodName = isset($_GET['action']) ? $_GET['action'] : 'index';
}

$controllerClassName = '\\controller\\' . ucfirst($controllerName) . ucfirst('controller');

if(isset($_GET['err'])){
    $error = htmlentities($_GET['err']);
    $controller = new controller\IndexController();
    $controller->error($error);
}
elseif(!file_exists(APP_ROOT .$controllerClassName . ".php")){
    $fileNotFound = true;
}
elseif (class_exists($controllerClassName)) {
    $contoller = new $controllerClassName();

    if(!(($controllerName === "index" || $controllerName === "user")  &&
        ($methodName === "index" || $methodName === "login" || $methodName === "register" ))){
        if(!isset($_SESSION["logged"])){
            $controller = new controller\IndexController();
            $controller->error(401);
        }
        else{
            if (method_exists($contoller, $methodName)) {
                $controller = new controller\IndexController();
                $contoller->$methodName();
            }
            else{
                $controller = new controller\IndexController();
                $controller->error(404);
            }
        }
    }
    elseif (method_exists($contoller, $methodName)) {
        if(isset($_SESSION['logged']) && ($controllerName === "index")  &&
            ($methodName === "login" || $methodName === "register")){
            header('location:'.URL_ROOT.'/index/main');
        }
        $contoller->$methodName();
    }
    else {
        $controller = new controller\IndexController();
        $controller->login();
    }
}
else {
    $fileNotFound = true;
}

if ($fileNotFound) {
    header("location:". URL_ROOT);
}

//var_dump($_GET);