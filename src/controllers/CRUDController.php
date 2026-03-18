<?php
class CRUDController {
    private $db;

    public function __construct() {
        require_once __DIR__ . '/../models/Database.php';
        $this->db = new Database();
    }

    public function createRecord($name, $email) {
        $name = trim($name);
        $email = trim($email);

        if (!$this->isValidName($name) || !$this->isValidEmail($email)) {
            return false;
        }

        $connection = $this->db->connect();
        $nextId = $this->getNextAvailableId($connection);

        $query = "INSERT INTO contacts (id, name, email) VALUES (:id, :name, :email)";
        $stmt = $connection->prepare($query);
        $stmt->bindParam(':id', $nextId, PDO::PARAM_INT);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':email', $email);
        return $stmt->execute();
    }

    private function getNextAvailableId($connection) {
        // Reuse empty ID numbers (for example: after deleting ID 2, next insert can be 2).
        $query = "
            SELECT CASE
                WHEN NOT EXISTS (SELECT 1 FROM contacts WHERE id = 1) THEN 1
                ELSE (
                    SELECT MIN(t1.id + 1)
                    FROM contacts t1
                    LEFT JOIN contacts t2 ON t1.id + 1 = t2.id
                    WHERE t2.id IS NULL
                )
            END AS next_id
        ";
        $stmt = $connection->prepare($query);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return (int)$result['next_id'];
    }

    private function isValidName($name) {
        return $name !== '' && strlen($name) <= 100;
    }

    private function isValidEmail($email) {
        return filter_var($email, FILTER_VALIDATE_EMAIL) !== false && strlen($email) <= 100;
    }

    public function read($id = null, $filters = []) {
        if ($id) {
            $query = "SELECT * FROM contacts WHERE id = :id";
            $stmt = $this->db->connect()->prepare($query);
            $stmt->bindValue(':id', (int)$id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } else {
            $connection = $this->db->connect();

            $search = trim($filters['search'] ?? '');
            $sort = $filters['sort'] ?? 'id';
            $order = strtoupper($filters['order'] ?? 'ASC');
            $limit = (int)($filters['limit'] ?? 50);

            $allowedSort = ['id', 'name', 'email', 'created_at'];
            if (!in_array($sort, $allowedSort, true)) {
                $sort = 'id';
            }

            if ($order !== 'DESC') {
                $order = 'ASC';
            }

            if ($limit < 1) {
                $limit = 1;
            }
            if ($limit > 100) {
                $limit = 100;
            }

            $query = "SELECT * FROM contacts";
            if ($search !== '') {
                $query .= " WHERE name LIKE :search OR email LIKE :search";
            }
            $query .= " ORDER BY $sort $order LIMIT :limit";

            $stmt = $connection->prepare($query);
            if ($search !== '') {
                $stmt->bindValue(':search', '%' . $search . '%');
            }
            $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
    }

    public function update($data) {
        $id = isset($data['id']) ? (int)$data['id'] : 0;
        $name = trim($data['name'] ?? '');
        $email = trim($data['email'] ?? '');

        if ($id < 1 || !$this->isValidName($name) || !$this->isValidEmail($email)) {
            return false;
        }

        $query = "UPDATE contacts SET name = :name, email = :email WHERE id = :id";
        $stmt = $this->db->connect()->prepare($query);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':email', $email);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function delete($id) {
        $id = (int)$id;
        if ($id < 1) {
            return false;
        }

        $query = "DELETE FROM contacts WHERE id = :id";
        $stmt = $this->db->connect()->prepare($query);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }
}
?>