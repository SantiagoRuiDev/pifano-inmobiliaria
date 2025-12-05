<?php

class PropertyController
{
    private $view;
    private $model;
    private $alert;

    public function __construct()
    {
        include_once 'src/views/PropertyView.php';
        include_once 'src/models/PropertyModel.php';
        include_once 'src/views/ErrorView.php';
        $this->view = new PropertyView();
        $this->model = new PropertyModel();
        $this->alert = new ErrorView();
    }

    public function renderPropertyPage()
    {
        $properties = $this->model->getAllProperties();
        $this->view->renderPropertyView($properties);
    }

    public function renderFormProperty()
    {
        $this->view->renderFormCreateProperty();
    }

    public function handleCreateProperty()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $city = $_POST['city'] ?? '';
            $country = $_POST['country'] ?? '';
            $address = $_POST['address'] ?? '';
            $floor = $_POST['floor'] ?? null;
            $apartment = $_POST['apartment'] ?? null;
            $description = $_POST['description'] ?? '';
            $type = $_POST['type'] ?? '';
            $base_price = $_POST['base_price'] ?? 0;

            $property = $this->model->addProperty($city, $country, $address, $floor, $apartment, $description, $type, $base_price);

            if ($property) {
                header("Location: propiedades");
                exit();
            } else {
                echo "Error al agregar propiedad";
            }
        } else {
            $this->view->renderFormCreateProperty();
        }
    }

    public function handleEditProperty($id_property)
    {
        $property = $this->model->getPropertyById($id_property);

        if ($property) {
            $this->view->renderPropertyEditForm($property);
        } else {
            echo "Propiedad no encontrada";
        }
    }

    public function updateProperty()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->model->updateProperty(
                $_POST['id'],
                $_POST['city'],
                $_POST['country'],
                $_POST['address'],
                $_POST['floor'],
                $_POST['apartment'],
                $_POST['description'],
                $_POST['type'],
                $_POST['base_price']
            );
            header("Location: propiedades");
            exit();
        }
    }

    public function deleteProperty($id_property)
    {
        $this->model->deletePropertyById($id_property);
        header("Location: propiedades");
        exit();
    }
}
