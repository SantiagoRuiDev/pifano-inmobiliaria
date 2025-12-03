<?php

class UserModel {
    private $PDO;

    public function __construct () { 
        include_once 'src/config/index.php';
        $conex = new db(); // Instacia de la clase DB
        $this->PDO = $conex->conexion(); // Metodo conexion.
    } // El constructor crea la conexion a la BD y la guarda en el PDO

    /*public function SQL_EXAMPLE($nombre) {
        $query = $this->PDO->prepare("SELECT * FROM inquilinos WHERE nombre = ?");
        $query->execute([$nombre]);
        return $query->fetch(PDO::FETCH_ASSOC); 
    }*/
}