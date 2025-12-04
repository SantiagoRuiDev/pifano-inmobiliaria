<?php

class RentController {
    private $view;
    private $model;
    private $alert;

    public function __construct() {
        include_once 'src/views/RentView.php';
        include_once 'src/views/ErrorView.php';
        $this->view = new RentView();
        $this->alert = new ErrorView();
    }

    public function renderManagmentPage(){
        $this->view->loadManagmentPage();
    }
}