<?php
    class db {
        // Estos datos son para ingresar a la DB
        private $host = "localhost";
        private $dbname = "inmobiliaria";
        private $user = "root";
        private $password = "pass34!";
//pass34!
        public function conexion() {
            try {
                // Intentamos la conexion a la db.
                $PDO = new PDO("mysql:host=".$this->host.";dbname=".$this->dbname,$this->user,$this->password);
                return $PDO; // La retornamos a quien haya llamado al metodo.
            } catch (PDOException $e) {
                return $e->getMessage(); // Si hay un error devolvemos el mensaje para mejur debug.
            }
        }
    }


?>