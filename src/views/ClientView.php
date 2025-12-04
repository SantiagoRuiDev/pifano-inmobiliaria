<?php
class ClientView {
    
    public function renderClientView($Clients){ 
        include 'src/templates/client.phtml';
    }

    public function renderFormCreateClient(){
        include 'src/templates/create-client.phtml';
    }

    public function renderClientEditForm($client){
        include 'src/templates/edit-client.phtml';
    }
}