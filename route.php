<?php
// Iniciamos Session, ya que el route es la primera "pagina" visitada al entrar.
session_start();

// IMPORTAMOS CONTROLADORES
include_once 'src/controllers/UserController.php';
include_once 'src/views/ErrorView.php';

// Instanciamos controlador de noticias
$userController = new UserController();
$errorView = new ErrorView();


// leemos la accion que viene por parametro
$action = 'inicio'; // acción por defecto

if (!empty($_GET['action'])) { // si viene definida la reemplazamos
    $action = $_GET['action'];
}

// parsea la accion Ej: dev/juan --> ['dev', juan]
$params = explode('/', $action);

// determina que camino seguir según la acción
switch ($params[0]) {
        // Aqui estan las rutas referidas a las sesiones  y registros.
    case 'inicio':
        //if (isset($_SESSION['rol'])) header("Location: inicio"); // Esto previene que accedan a una sesion con una sesion ya iniciada.
        $userController->renderIndexView();
        break;

    default:
        //Si no encuentra la URL o no tiene ruta y controlador definido muestra error.
        $errorView->loadNotFoundErrorPage("Esta pagina no existe", "danger");
}

// Cargamos el footer, contenido estatico.