<?php

class ClientModels
{
    private $PDO;

    public function __construct()
    {
        include_once 'src/config/index.php';
        $conex = new db();
        $this->PDO = $conex->conexion();
    }

    public function DeleteClientById($id)
    {
        $queryClient = $this->PDO->prepare("DELETE FROM Client WHERE id_client = ?");
        $queryClient->execute([$id]);
        return $queryClient;
    }
    public function GetClients()
    {
        $queryClients = $this->PDO->prepare("SELECT * FROM Client");
        $queryClients->execute();
        return $queryClients->fetchAll(PDO::FETCH_OBJ);
    }

    public function GetClientById($id)
    {
        $queryClient = $this->PDO->prepare("SELECT * FROM Client WHERE id_client = ?");
        $queryClient->execute([$id]);
        return $queryClient->fetch(PDO::FETCH_OBJ);
    }

    public function UpdateClient($id, $name, $lastName, $email, $phone, $address, $dni)
    {
        $queryClient = $this->PDO->prepare("UPDATE Client SET name = ?, lastname = ?, email = ?, phone = ?, address = ?, dni = ? WHERE id_client = ?");
        $queryClient->execute([$name, $lastName, $email, $phone, $address, $dni, $id]);
        return $queryClient;
    }

    public function CreateClient($name, $lastName, $email, $phone, $address, $dni)
    {
        try {
            $queryClient = $this->PDO->prepare("INSERT INTO Client (name, lastname, email, phone, address, dni) VALUES (?, ?, ?, ?, ?, ?)");
            $queryClient->execute([$name, $lastName, $email, $phone, $address, $dni]);
            return $this->PDO->lastInsertId();
        } catch (PDOException $e) {
            echo "Error en la inserción: " . $e->getMessage();
            return false;
        }
    }
}
/**CREATE TABLE Client (
    id_client INT NOT NULL AUTO_INCREMENT,
    name VARCHAR(150) NOT NULL,
    lastname VARCHAR(150) NOT NULL,
    email VARCHAR(150) NOT NULL,
    phone VARCHAR(30) NOT NULL,
    address VARCHAR(150) NOT NULL,
    dni INT NOT NULL,
    CONSTRAINT Client_pk PRIMARY KEY (id_client)
);
 */
