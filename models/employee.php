<?php
class Customer {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    // Create a new customer
    public function createCustomer($name, $email, $phone_number, $address, $date_of_birth, $national_id) {
        $sql = "INSERT INTO customers (name, email, phone_number, address, date_of_birth, national_id) 
                VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$name, $email, $phone_number, $address, $date_of_birth, $national_id]);
    }

    // Retrieve all customers
    public function getAllCustomers() {
        $sql = "SELECT * FROM customers";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll();
    }

    // Update customer details
    public function updateCustomer($id, $name, $email, $phone_number, $address, $date_of_birth, $national_id) {
        $sql = "UPDATE customers 
                SET name = ?, email = ?, phone_number = ?, address = ?, date_of_birth = ?, national_id = ? 
                WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$name, $email, $phone_number, $address, $date_of_birth, $national_id, $id]);
    }

    // Delete a customer
    public function deleteCustomer($id) {
        $sql = "DELETE FROM customers WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id]);
    }
}
?>
