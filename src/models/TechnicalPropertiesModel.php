<?php

class TechnicalPropertiesModel {
    private $PDO;

    public function __construct () { 
        include_once 'src/config/index.php';
        $conex = new db(); 
        $this->PDO = $conex->conexion();
    }

    public function getAllTechnicalProperties(){
        $query = $this->PDO->prepare("SELECT * FROM Technical_properties");
        $query->execute();
        $properties = $query->fetchAll(PDO::FETCH_OBJ);
        return $properties;
        
    }

   public function getTechnicalPropertyById($id_technical_properties){
    $query = $this->PDO->prepare('
        SELECT 
            tp.id_technical_properties AS tp_id,
            tp.cadastral_nomenclature,
            tp.departure_number,
            tp.topography,
            tp.parcel,
            tp.meters_front,
            tp.meters_deep,
            tp.access,
            tp.services AS tp_services,
            tp.busy,
            tp.surface,
            tp.amenities,
            tp.adjustment_type,
            tp.is_new,
            p.id_property,
            p.city,
            p.country,
            p.address,
            p.floor,
            p.apartment,
            p.description,
            p.type,
            p.base_price,
            p.id_technical_properties AS p_id_technical
        FROM technical_properties tp
        INNER JOIN Property p 
            ON p.id_technical_properties = tp.id_technical_properties
        WHERE tp.id_technical_properties = ?
        LIMIT 1
    ');
    $query->execute([$id_technical_properties]);
    return $query->fetch(PDO::FETCH_OBJ);
}


 public function addTechnicalProperty($data){
    try {
        $query = $this->PDO->prepare("
            INSERT INTO technical_properties (
                cadastral_nomenclature,
                departure_number,
                topography,
                parcel,
                meters_front,
                meters_deep,
                access,
                services,
                busy,
                surface,
                amenities,
                adjustment_type,
                is_new
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
        ");

        $query->execute([
             $data['cadastral_nomenclature'],
            $data['departure_number'],
            $data['topography'],
            $data['parcel'],
            $data['meters_front'],
            $data['meters_deep'],
            $data['access'],
            $data['services'],
            $data['busy'],
            $data['surface'],
            $data['amenities'],
            $data['adjustment_type'],
            $data['is_new']
        ]);

        return $this->PDO->lastInsertId();

    } catch (PDOException $e) {
        echo "Error en la inserción: " . $e->getMessage();
        return false;
    }
}

    public function updateProperty($id_property, $city, $country, $address, $floor, $apartment, $description, $type, $base_price){
        $query = $this->PDO->prepare("
            UPDATE Property SET
                city = ?, 
                country = ?, 
                address = ?, 
                floor = ?, 
                apartment = ?, 
                description = ?, 
                type = ?, 
                base_price = ?
            WHERE id_property = ?
        ");
        $query->execute([$city, $country, $address, $floor, $apartment, $description, $type, $base_price, $id_property]);
    }

      public function deletePropertyById($id_technical_properties){
        $query = $this->PDO->prepare('DELETE FROM Technical_properties WHERE id_technical_properties = ?');
        $query->execute([$id_technical_properties]);
    }
}
