<?php

class PropertyController
{
    private $view;
    private $model;
    private $modelTechnicalProperties;
    private $alert;

    public function __construct()
    {
        include_once 'src/views/PropertyView.php';
        include_once 'src/models/PropertyModel.php';
        include_once 'src/models/TechnicalPropertiesModel.php';
        include_once 'src/views/ErrorView.php';
        $this->view = new PropertyView();
        $this->model = new PropertyModel();
        $this->modelTechnicalProperties = new TechnicalPropertiesModel();
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

    public function handleCreateFullProperty()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

                 $technical_properties_data = [
            'cadastral_nomenclature' => $_POST['cadastral_nomenclature'],
            'departure_number'       => $_POST['departure_number'],
            'topography'            => $_POST['topography'],
            'parcel'                => $_POST['parcel'],
            'meters_front'          => $_POST['meters_front'],
            'meters_deep'           => $_POST['meters_deep'],
            'access'                => $_POST['access'],
            'services'              => $_POST['services'],
            'busy'                  => $_POST['busy'],
            'surface'               => $_POST['surface'],
            'amenities'             => $_POST['amenities'],
            'adjustment_type'       => $_POST['adjustment_type'],
            'is_new'                => $_POST['is_new'],
        ];

          $technical_properties_id = $this->modelTechnicalProperties->addTechnicalProperty($technical_properties_data);

         if (!$technical_properties_id) {
            echo "Error al guardar los datos técnicos";
            return;
        }

            $city = $_POST['city'] ?? '';
            $country = $_POST['country'] ?? '';
            $address = $_POST['address'] ?? '';
            $floor = $_POST['floor'] ?? null;
            $apartment = $_POST['apartment'] ?? null;
            $description = $_POST['description'] ?? '';
            $type = $_POST['type'] ?? '';
            $base_price = $_POST['base_price'] ?? 0;

            $propertyId = $this->model->addProperty($city, $country, $address, $floor, $apartment, $description, $type, $base_price, $technical_properties_id);

            if ($propertyId) {
                header("Location: propiedades");
                exit();
            } else {
                echo "Error al agregar propiedad";
            }

            header("Location: propiedades");
            exit();

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
