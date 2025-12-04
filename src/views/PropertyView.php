<?php

class PropertyView {

    public function renderPropertyView($properties){
        include 'src/templates/property.phtml';
    }

     public function renderFormCreateProperty(){
        include 'src/templates/create-property.phtml';
    }

    public function renderPropertyEditForm($property){
        include 'src/templates/edit-property.phtml';
    }

}
