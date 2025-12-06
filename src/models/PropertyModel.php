<?php

class PropertyModel {
    private $PDO;

    public function __construct () { 
        include_once 'src/config/index.php';
        $conex = new db(); 
        $this->PDO = $conex->conexion();
    }

    public function getAllProperties(){
        $query = $this->PDO->prepare("SELECT 
            p.*, 
            tp.id_technical_properties
        FROM Property p
        LEFT JOIN technical_properties tp
            ON p.id_technical_properties = tp.id_technical_properties");
        $query->execute();
        $properties = $query->fetchAll(PDO::FETCH_OBJ);
        return $properties;
        
    }

    public function getPropertyById($id_property){
        $query = $this->PDO->prepare('SELECT * FROM Property WHERE id_property = ?');
        $query->execute([$id_property]);
        return $query->fetch(PDO::FETCH_OBJ);
    }

   public function addProperty($city, $country, $address, $floor, $apartment, $description, $type, $base_price, $id_technical_properties){
    try {
        $query = $this->PDO->prepare("
        INSERT INTO Property (city, country, address, floor, apartment, description, type, base_price, id_technical_properties) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
        ");
        $query->execute([$city, $country, $address, $floor, $apartment, $description, $type, $base_price, $id_technical_properties]);
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

      public function deletePropertyById($id_property){
        $query = $this->PDO->prepare('DELETE FROM Property WHERE id_property = ?');
        $query->execute([$id_property]);
    }
}
