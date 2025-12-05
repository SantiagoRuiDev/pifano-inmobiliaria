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

    private function renderRentEditForm($rent)
    {
        include_once 'src/models/ClientModels.php';
        include_once 'src/models/PropertyModel.php';

        $clientModel = new ClientModels();
        $propertyModel = new PropertyModel();

        $clients = $clientModel->GetClients();
        $properties = $propertyModel->getAllProperties();

        $this->view->renderRentEditForm($rent, $clients, $properties);
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

    public function handleEditRent($id_rent)
    {
        $rent = $this->model->getRentDataById($id_rent);

        if ($rent) {
            $this->renderRentEditForm($rent);
        } else {
            echo "Alquiler no encontrado";
        }
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

    public function updateRent()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id_rent = $_POST['id_rent'] ?? '';
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

            $this->model->updateRent($id_rent, $id_tenant, $id_locator, $id_guarantor, $id_property, $amount, $honorarium, $discount, $generation_date, $payment_method, $adjustment_type, $adjustment_time, $start_contract, $end_contract);
            header("Location: alquileres");
            exit();
        }
    }


    public function deleteRent($id_rent)
    {
        $this->model->deleteRentById($id_rent);
        header("Location: alquileres");
        exit();
    }

    public function generateReceiptPdf()
    {

        $id_rent = $_POST['id_rent'] ?? null;

        if (!$id_rent) {
            $this->alert->loadNotFoundErrorPage();
            return;
        }

        $rentData = $this->model->getRentDataById($id_rent);

        if (!$rentData) {
            $this->alert->loadNotFoundErrorPage();
            return;
        }

        require_once dirname(__DIR__, 2) . '/vendor/autoload.php';

        $options = new \Dompdf\Options();
        $options->set('defaultFont', 'Helvetica');

        $options->set('isHtml5ParserEnabled', true);
        $options->set('default_charset', 'UTF-8');

        $dompdf = new \Dompdf\Dompdf($options);


        $html = $this->renderHtmlForReceipt($rentData);


        $dompdf->loadHtml($html);

        $dompdf->setPaper('A4', 'portrait');

        $dompdf->render();


        $filename = 'Recibo_Alquiler_' . $id_rent . '.pdf';

        $dompdf->stream($filename, array("Attachment" => false));
        exit();
    }

    private function renderHtmlForReceipt($rentData)
    {
        ob_start();
        include __DIR__ . '/../templates/receipt_template.phtml';
        $html = ob_get_clean();
        return $html;
    }

    public function renderSelectRentPage(){
        $rents = $this->model->getAllRents();
        $this->view->loadSelectRentPage($rents);
    }
}
