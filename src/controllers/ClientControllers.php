<?php
class ClientControllers
{
    private $view;
    private $model;
    private $alert;

    public function __construct()
    {
        include_once 'src/models/ClientModels.php';
        include_once 'src/views/ErrorView.php';
        include_once 'src/views/ClientView.php';

        $this->model = new ClientModels();
        $this->alert = new ErrorView();
        $this->view = new ClientView();
    }

    public function renderClientPage(){
    $Clients = $this->model->GetClients();
    $this->view->renderClientView($Clients);
    }
    
    public function renderFormCreateClient(){
    $this->view->renderFormCreateClient();
}

     public function handleEditClient($id_Client) {
    $client = $this->model->getClientById($id_Client); 
    if ($client) {
        $this->view->renderClientEditForm($client); 
    } else {
        $this->alert->loadNotFoundErrorPage(); 
    }
}

// Añade esto a tu clase ClientControllers

public function createClient() {
    
    if ($_SERVER['REQUEST_METHOD'] === "POST" && !empty($_POST['name']) && !empty($_POST['lastName']) && !empty($_POST['email'])) {
        
       
        $name = $_POST['name'];
        $lastName = $_POST['lastName'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $address = $_POST['address'];
        $dni = $_POST['dni'];

        
        $id = $this->model->CreateClient($name, $lastName, $email, $phone, $address, $dni);

        if ($id) {
            
            header("Location: http://" . $_SERVER["SERVER_NAME"] . "/clients");
        } else {
        
            echo "Error al crear cliente";
        }
    }
}

    public function updateClient($id){
        if ($_SERVER['REQUEST_METHOD'] === "POST" && !empty($_POST['name']) && !empty($_POST['lastName']) && !empty($_POST['email']) && !empty($_POST['phone']) && !empty($_POST['address']) && !empty($_POST['dni'])) {
            $name = $_POST['name'];
            $lastName = $_POST['lastName'];
            $email = $_POST['email'];
            $phone = $_POST['phone'];
            $address = $_POST['address'];
            $dni = $_POST['dni'];
            $this->model->UpdateClient($id, $name, $lastName, $email, $phone, $address, $dni);
            header("Location: http://" . $_SERVER["SERVER_NAME"] . "/clients");
        }
    }

   
    public function deleteClient($id){
        $this->model->DeleteClientById($id);
        header("Location: http://" . $_SERVER["SERVER_NAME"] . "/clients");
    }

    public function getClients(){
        return $this->model->getClients();
    }



}

