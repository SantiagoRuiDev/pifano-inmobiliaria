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
        $query = $this->PDO->prepare("
        SELECT 
            r.*, 
            p.address AS property_address,
            p.city AS property_city,
            l.name AS locator_name,
            l.lastname AS locator_lastname,
            t.name AS tenant_name,
            t.lastname AS tenant_lastname,
            t.dni AS tenant_dni,

            lastPay.issued_date AS last_payment_date

        FROM Rent r
        JOIN Property p ON r.id_property = p.id_property
        JOIN Client l ON r.id_locator = l.id_client
        JOIN Client t ON r.id_tenant = t.id_client

        LEFT JOIN (
            SELECT id_rent, MAX(issued_date) AS issued_date
            FROM Rent_payment
            GROUP BY id_rent
        ) AS lastPay ON lastPay.id_rent = r.id_rent
    ");

        $query->execute();
        return $query->fetchAll(PDO::FETCH_OBJ);
    }
    public function getRentDataById($id_rent)
    {
        // Obtiene todos los datos necesarios para el recibo a partir de múltiples tablas
        $query = $this->PDO->prepare("
            SELECT 
                r.*, 
                p.address AS property_address,
                p.city AS property_city,
                l.name AS locator_name,
                l.lastname AS locator_lastname,
                t.name AS tenant_name,
                t.lastname AS tenant_lastname,
                t.dni AS tenant_dni,
                t.address AS tenant_address 
            FROM Rent r
            JOIN Property p ON r.id_property = p.id_property
            JOIN Client l ON r.id_locator = l.id_client
            JOIN Client t ON r.id_tenant = t.id_client
            WHERE r.id_rent = ?
        ");
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
