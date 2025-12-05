<?php

class RentController
{
    private $view;
    private $model;
    private $alert;

    public function __construct()
    {
        include_once 'src/views/RentView.php';
        include_once 'src/models/RentModel.php';
        include_once 'src/views/ErrorView.php';
        $this->view = new RentView();
        $this->alert = new ErrorView();
        $this->model = new RentModel();
    }

    public function renderManagmentPage()
    {
        $rents = $this->model->getAllRents();
        $this->view->loadManagmentPage($rents);
    }

    private function renderFormRent()
    {
        include_once 'src/models/ClientModels.php';
        include_once 'src/models/PropertyModel.php';

        $clientModel = new ClientModels();
        $propertyModel = new PropertyModel();

        $clients = $clientModel->GetClients();
        $properties = $propertyModel->getAllProperties();

        $this->view->renderFormRent($clients, $properties);
    }

    public function handleCreateRent()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id_tenant = $_POST['id_tenant'] ?? '';
            $id_locator = $_POST['id_locator'] ?? '';
            $id_guarantor = $_POST['id_guarantor'] ?? '';
            $id_property = $_POST['id_property'] ?? '';
            $amount = $_POST['amount'] ?? '';
            $honorarium = $_POST['honorarium'] ?? '';
            $discount = $_POST['discount'] ?? '';
            $generation_date = $_POST['generation_date'] ?? '';
            $payment_method = $_POST['payment_method'] ?? '';
            $adjustment_type = $_POST['adjustment_type'] ?? '';
            $adjustment_time = $_POST['adjustment_time'] ?? '';
            $start_contract = $_POST['start_contract'] ?? '';
            $end_contract = $_POST['end_contract'] ?? '';

            $rent = $this->model->addRent($id_tenant, $id_locator, $id_guarantor, $id_property, $amount, $honorarium, $discount, $generation_date, $payment_method, $adjustment_type, $adjustment_time, $start_contract, $end_contract);

            if ($rent) {
                header("Location: alquileres");
                exit();
            } else {
                echo "Error al agregar el alquiler";
            }
        } else {
            $this->renderFormRent();
        }
    }
}
