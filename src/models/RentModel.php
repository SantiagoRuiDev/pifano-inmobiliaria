<?php

class RentModel
{
    private $PDO;

    public function __construct()
    {
        include_once 'src/config/index.php';
        $conex = new db();
        $this->PDO = $conex->conexion();
    }

    public function getAllRents()
    {
        $query = $this->PDO->prepare("SELECT r.*, c.name, c.lastname, p.address FROM Rent r INNER JOIN Client c ON c.id_client = r.id_tenant INNER JOIN Property p ON p.id_property = r.id_property");
        $query->execute();
        $properties = $query->fetchAll(PDO::FETCH_OBJ);
        return $properties;
    }

    public function getRentById($id_rent)
    {
        $query = $this->PDO->prepare('SELECT * FROM Rent WHERE id_rent = ?');
        $query->execute([$id_rent]);
        return $query->fetch(PDO::FETCH_OBJ);
    }

    public function addRent(
        $id_tenant,
        $id_locator,
        $id_guarantor,
        $id_property,
        $amount,
        $honorarium,
        $discount,
        $generation_date,
        $payment_method,
        $adjustment_type,
        $adjustment_time,
        $start_contract,
        $end_contract
    ) {
        try {
            $query = $this->PDO->prepare("
            INSERT INTO Rent (
                id_tenant,
                id_locator,
                id_guarantor,
                id_property,
                amount,
                honorarium,
                discount,
                generation_date,
                payment_method,
                adjustment_type,
                adjustment_time,
                start_contract,
                end_contract
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
        ");

            $query->execute([
                $id_tenant,
                $id_locator,
                $id_guarantor,
                $id_property,
                $amount,
                $honorarium,
                $discount,
                $generation_date,
                $payment_method,
                $adjustment_type,
                $adjustment_time,
                $start_contract,
                $end_contract
            ]);

            return $this->PDO->lastInsertId();
        } catch (PDOException $e) {
            echo "Error en la inserción: " . $e->getMessage();
            return false;
        }
    }

    public function updateRent(
        $id_rent,
        $id_tenant,
        $id_locator,
        $id_guarantor,
        $id_property,
        $amount,
        $honorarium,
        $discount,
        $generation_date,
        $payment_method,
        $adjustment_type,
        $adjustment_time,
        $start_contract,
        $end_contract
    ) {
        $query = $this->PDO->prepare("
        UPDATE Rent SET
            id_tenant = ?, 
            id_locator = ?, 
            id_guarantor = ?, 
            id_property = ?, 
            amount = ?, 
            honorarium = ?, 
            discount = ?, 
            generation_date = ?, 
            payment_method = ?, 
            adjustment_type = ?, 
            adjustment_time = ?, 
            start_contract = ?, 
            end_contract = ?
        WHERE id_rent = ?
    ");

        $query->execute([
            $id_tenant,
            $id_locator,
            $id_guarantor,
            $id_property,
            $amount,
            $honorarium,
            $discount,
            $generation_date,
            $payment_method,
            $adjustment_type,
            $adjustment_time,
            $start_contract,
            $end_contract,
            $id_rent
        ]);
    }

    public function deleteRentById($id_rent)
    {
        $query = $this->PDO->prepare('DELETE FROM Rent WHERE id_rent = ?');
        $query->execute([$id_rent]);
    }
}
