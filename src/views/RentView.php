<?php

class RentView {

    public function loadManagmentPage($rents){
        include_once 'src/templates/rent.phtml';
    }

    public function renderFormRent($clients, $properties){
        include_once 'src/templates/create-rent.phtml';
    }
}