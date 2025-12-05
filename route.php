<?php
// Función para cargar e instanciar un controlador
function controller($path, $className) {
    include_once $path;
    return new $className();
}

// Leer acción
$action = $_GET['action'] ?? 'inicio';
$params = explode('/', $action);

switch ($params[0]) {
    case 'inicio':
        $ctrl = controller('src/controllers/UserController.php', 'UserController');
        $ctrl->renderIndexView();
        break;
    case 'alquileres':
        $ctrl = controller('src/controllers/RentController.php', 'RentController');
        $ctrl->renderManagmentPage();
        break;
    case 'crear-alquiler':
        $ctrl = controller('src/controllers/RentController.php', 'RentController');
        $ctrl->handleCreateRent();
        break;
    case 'editar-alquiler':
        $ctrl = controller('src/controllers/RentController.php', 'RentController');
        $ctrl->handleEditRent($params[1] ?? null);
        break;
    case 'actualizar-alquiler':
        $ctrl = controller('src/controllers/RentController.php', 'RentController');
        $ctrl->updateRent();
        break;
        
    case 'eliminar-alquiler':
        $ctrl = controller('src/controllers/RentController.php', 'RentController');
        $ctrl->deleteRent($params[1] ?? null);
        break;

    case 'propiedades':
        $ctrl = controller('src/controllers/PropertyController.php', 'PropertyController');
        $ctrl->renderPropertyPage();
        break;

    case 'crear-propiedad':
        $ctrl = controller('src/controllers/PropertyController.php', 'PropertyController');
        $ctrl->handleCreateProperty();
        break;

    case 'editar-propiedad':
        $ctrl = controller('src/controllers/PropertyController.php', 'PropertyController');
        $ctrl->handleEditProperty($params[1] ?? null);
        break;

    case 'actualizar-propiedad':
        $ctrl = controller('src/controllers/PropertyController.php', 'PropertyController');
        $ctrl->updateProperty();
        break;

    case 'eliminar-propiedad':
        $ctrl = controller('src/controllers/PropertyController.php', 'PropertyController');
        $ctrl->deleteProperty($params[1] ?? null);
        break;

    case 'clients':
        $ctrl = controller('src/controllers/ClientControllers.php', 'ClientControllers');
        $ctrl->renderClientPage();
        break;

    case 'crear-cliente':
        $ctrl = controller('src/controllers/ClientControllers.php', 'ClientControllers');
        $ctrl->renderFormCreateClient();
        break;

    case 'guardar-cliente':
        $ctrl = controller('src/controllers/ClientControllers.php', 'ClientControllers');
        $ctrl->createClient();
        break;

    case 'editar-cliente':
        $ctrl = controller('src/controllers/ClientControllers.php', 'ClientControllers');
        $ctrl->handleEditClient($params[1] ?? null);
        break;

    case 'actualizar-cliente':
        $ctrl = controller('src/controllers/ClientControllers.php', 'ClientControllers');
        $ctrl->updateClient($params[1] ?? null);
        break;

    case 'eliminar-cliente':
        $ctrl = controller('src/controllers/ClientControllers.php', 'ClientControllers');
        $ctrl->deleteClient($params[1] ?? null);
        break;
        
    case 'generar-recibo':
        $ctrl = controller('src/controllers/RentController.php', 'RentController');
        $ctrl->renderSelectRentPage();
        break;
    case 'procesar-recibo': 
        $ctrl = controller('src/controllers/RentController.php', 'RentController');
        $ctrl->generateReceiptPdf(); 
        break;

    // Si no encuentra la ruta, redirige al 404
    default:
        include_once 'src/views/ErrorView.php';
        $error = new ErrorView();
        $error->loadNotFoundErrorPage("Esta página no existe", "danger");
        break;
}
