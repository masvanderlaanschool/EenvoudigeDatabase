<?php
class CRUDController {
    private $db;

    public function __construct() {
        require_once __DIR__ . '/../models/Database.php';
        $this->db = new Database();
    }

    public function createRecord($name, $email) {
        $query = "INSERT INTO contacts (name, email) VALUES (:name, :email)";
        $stmt = $this->db->connect()->prepare($query);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':email', $email);
        return $stmt->execute();
    }

    public function read($id = null) {
        if ($id) {
            $query = "SELECT * FROM contacts WHERE id = :id";
            $stmt = $this->db->connect()->prepare($query);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } else {
            $query = "SELECT * FROM contacts";
            $stmt = $this->db->connect()->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
    }

    public function update($data) {
        $query = "UPDATE contacts SET name = :name, email = :email WHERE id = :id";
        $stmt = $this->db->connect()->prepare($query);
        $stmt->bindParam(':name', $data['name']);
        $stmt->bindParam(':email', $data['email']);
        $stmt->bindParam(':id', $data['id']);
        return $stmt->execute();
    }

    public function delete($id) {
        $query = "DELETE FROM contacts WHERE id = :id";
        $stmt = $this->db->connect()->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}
?>