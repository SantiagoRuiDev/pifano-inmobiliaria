<?php

class UserController {
    private $view;
    private $model;
    private $alert;

    public function __construct() {
        include_once 'src/views/UserView.php';
        include_once 'src/models/UserModel.php';
        include_once 'src/views/ErrorView.php';
        $this->view = new UserView();
        $this->model = new UserModel();
        $this->alert = new ErrorView();
    }

    public function renderIndexView(){
        $this->view->loadIndexPage();
    }
}