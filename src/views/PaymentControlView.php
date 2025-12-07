<?php

class PaymentControlView {

    public function loadManagmentPage($id_rent, $payments){
        include_once 'src/templates/rent-control.phtml';
    }

    public function renderFormPayment($id_rent){
        include_once 'src/templates/rent-payment-create.phtml';
    }
}