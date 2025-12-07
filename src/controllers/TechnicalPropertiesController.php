<?php

class TechnicalPropertiesController
{
    private $view;
    private $model;
    private $alert;

    public function __construct()
    {

        include_once 'src/config/base_url.php';

        include_once 'src/views/TechnicalPropertiesView.php';
        include_once 'src/models/TechnicalPropertiesModel.php';
        include_once 'src/views/ErrorView.php';

        $this->view = new TechnicalPropertiesView();
        $this->model = new TechnicalPropertiesModel();
        $this->alert = new ErrorView();
    }

    public function renderEditForm($id_technical)
    {
        $data = $this->model->getTechnicalPropertyById($id_technical);

        if ($data) {
            // Preparamos los datos para la vista
            $technical = (object)[
                'id_technical_properties' => $data->tp_id,
                'cadastral_nomenclature' => $data->cadastral_nomenclature,
                'departure_number' => $data->departure_number,
                'topography' => $data->topography,
                'parcel' => $data->parcel,
                'meters_front' => $data->meters_front,
                'meters_deep' => $data->meters_deep,
                'access' => $data->access,
                'services' => $data->tp_services,
                'busy' => $data->busy,
                'surface' => $data->surface,
                'amenities' => $data->amenities,
                'adjustment_type' => $data->adjustment_type,
                'is_new' => $data->is_new,
            ];

            // Usamos la dirección para mostrar de qué propiedad es
            $propertyAddress = $data->address;

            include 'src/templates/edit-technical-properties.phtml';
        } else {
            $this->alert->loadNotFoundErrorPage();
        }
    }

    public function handleUpdate()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id_technical_properties'];

            $data = [
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

            $this->model->updateTechnicalProperty($id, $data);

            // Redirigir a la vista de datos técnicos
            header("Location: " . BASE_URL . "datos-tecnicos/" . $id);
            exit();
        }
    }

    public function renderTechnicalProperties($id_technical_properties)
    {
        try {
            $data = $this->model->getTechnicalPropertyById($id_technical_properties);

            if (!$data) {
                echo "No se encontraron datos técnicos para esta propiedad.";
                return;
            }

            $property = (object)[
                'id_property'    => $data->id_property,
                'city'           => $data->city,
                'country'        => $data->country,
                'address'        => $data->address,
                'floor'          => $data->floor,
                'apartment'      => $data->apartment,
                'description'    => $data->description,
                'type'           => $data->type,
                'base_price'     => $data->base_price,
            ];

            $technical = (object)[
                'id_technical_properties' => $data->tp_id, // Agregamos el ID por si acaso
                'cadastral_nomenclature' => $data->cadastral_nomenclature,
                'departure_number'       => $data->departure_number,
                'topography'             => $data->topography,
                'parcel'                 => $data->parcel,
                'meters_front'           => $data->meters_front,
                'meters_deep'            => $data->meters_deep,
                'access'                 => $data->access,


                'services'               => $data->tp_services,


                'busy'                   => $data->busy,

                'surface'                => $data->surface,
                'amenities'              => $data->amenities,
                'adjustment_type'        => $data->adjustment_type,
                'is_new'                 => $data->is_new,
            ];

            $this->view->renderTechnicalProperty($property, $technical);
        } catch (Exception $e) {
            echo "Error al cargar los datos técnicos: " . $e->getMessage();
        }
    }
}
