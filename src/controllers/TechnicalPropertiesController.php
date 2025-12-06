<?php

class TechnicalPropertiesController {
    private $view;
    private $model;
    private $alert;

    public function __construct() {
        include_once 'src/views/TechnicalPropertiesView.php';
        include_once 'src/models/TechnicalPropertiesModel.php';
        include_once 'src/views/ErrorView.php';

        $this->view = new TechnicalPropertiesView();
        $this->model = new TechnicalPropertiesModel();
        $this->alert = new ErrorView();
    }

    public function renderTechnicalProperties($id_technical_properties) {
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
            'cadastral_nomenclature' => $data->cadastral_nomenclature,
            'departure_number'       => $data->departure_number,
            'topography'             => $data->topography,
            'parcel'                 => $data->parcel,
            'meters_front'           => $data->meters_front,
            'meters_deep'            => $data->meters_deep,
            'access'                 => $data->access,
            'services'               => $data->services,
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