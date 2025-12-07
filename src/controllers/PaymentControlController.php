<?php

class PaymentControlController
{
    private $view;
    private $model;
    private $alert;

    public function __construct()
    {
        include_once 'src/views/PaymentControlView.php';
        include_once 'src/models/PaymentControlModel.php';
        include_once 'src/views/ErrorView.php';
        $this->view = new PaymentControlView();
        $this->alert = new ErrorView();
        $this->model = new PaymentControlModel();
    }

    public function renderManagmentPage($id_rent)
    {
        $payments = $this->model->getAllPaymentsByRentId($id_rent);
        $this->view->loadManagmentPage($id_rent, $payments);
    }

    private function renderFormPayment($id_rent)
    {
        $this->view->renderFormPayment($id_rent);
    }

    public function handleCreatePayment($id_rent)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id_rent = $_POST['id_rent'] ?? '';
            $amount = $_POST['amount'] ?? 0;
            $issued_date = $_POST['issued_date'] ?? '';

            $payment = $this->model->addPayment($id_rent, $amount, $issued_date);

            if ($payment) {
                header("Location: control-alquiler/" . $id_rent);
                exit();
            } else {
                echo "Error al agregar el alquiler";
            }
        } else {
            $this->renderFormPayment($id_rent);
        }
    }

    public function updatePayment()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id_payment = $_POST['id_payment'] ?? '';
            $id_rent = $_POST['id_rent'] ?? '';
            $amount = $_POST['amount'] ?? 0;
            $issued_date = $_POST['issued_date'] ?? '';

            $this->model->updatePayment($id_payment, $amount, $issued_date);
            header("Location: control-alquiler/" . $id_rent);
            exit();
        }
    }


    public function deletePayment($id_payment, $id_rent)
    {
        $this->model->deletePaymentById($id_payment);
        header("Location: " . $id_rent);
        exit();
    }
}
