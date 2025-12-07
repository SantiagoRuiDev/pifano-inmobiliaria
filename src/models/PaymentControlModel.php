<?php

class PaymentControlModel
{
    private $PDO;

    public function __construct()
    {
        include_once 'src/config/index.php';
        $conex = new db();
        $this->PDO = $conex->conexion();
    }

    public function getPaymentDataById($id_rent)
    {
        // Obtiene todos los alquileres, que podrías necesitar para un <select> más avanzado.
        $query = $this->PDO->prepare("SELECT * FROM Rent_payment WHERE id_rent = ? ORDER BY issued_date ASC");
        $query->execute([$id_rent]);
        return $query->fetch(PDO::FETCH_OBJ);
    }

    public function getAllPaymentsByRentId($id_rent)
    {
        // Obtiene todos los alquileres, que podrías necesitar para un <select> más avanzado.
        $query = $this->PDO->prepare("SELECT * FROM Rent_payment WHERE id_rent = ?");
        $query->execute([$id_rent]);
        return $query->fetchAll(PDO::FETCH_OBJ);
    }

    public function addPayment(
        $id_rent,
        $amount,
        $issued_date
    ) {
        try {
            $query = $this->PDO->prepare("INSERT INTO Rent_payment(id_rent,amount,issued_date) VALUES (?,?,?)");

            $query->execute([
                $id_rent,
                $amount,
                $issued_date
            ]);

            return $this->PDO->lastInsertId();
        } catch (PDOException $e) {
            echo "Error en la inserción: " . $e->getMessage();
            return false;
        }
    }

    public function updatePayment(
        $id,
        $amount,
        $issued_date
    ) {
        $query = $this->PDO->prepare("UPDATE Rent_payment SET amount = ?, issued_date = ? WHERE id_payment = ?");

        $query->execute([
            $amount,
            $issued_date,
            $id
        ]);
    }

    public function deletePaymentById($id)
    {
        $query = $this->PDO->prepare('DELETE FROM Rent_payment WHERE id_payment = ?');
        $query->execute([$id]);
    }
}
