<?php
class CRUDController {
    private $db;
    private $allowedSort = [
        'StudentID',
        'Voornaam',
        'Achternaam',
        'Geboortedatum',
        'Geslacht',
        'Email',
        'Studierichting',
        'Startjaar',
        'HuidigJaar',
        'StudieStatus',
        'AchterstalligStudiegeld',
    ];

    public function __construct() {
        require_once __DIR__ . '/../models/Database.php';
        $this->db = new Database();
    }

    public function createRecord($data) {
        $student = $this->normalizeStudentData($data);
        if (!$this->isValidStudent($student)) {
            return false;
        }

        $query = "
            INSERT INTO studenten
            (Voornaam, Achternaam, Geboortedatum, Geslacht, Email, Studierichting, Startjaar, HuidigJaar, StudieStatus, AchterstalligStudiegeld)
            VALUES
            (:Voornaam, :Achternaam, :Geboortedatum, :Geslacht, :Email, :Studierichting, :Startjaar, :HuidigJaar, :StudieStatus, :AchterstalligStudiegeld)
        ";
        $stmt = $this->db->connect()->prepare($query);
        return $stmt->execute($student);
    }

    public function read($id = null, $filters = []) {
        if ($id) {
            $query = "SELECT * FROM studenten WHERE StudentID = :id";
            $stmt = $this->db->connect()->prepare($query);
            $stmt->bindValue(':id', (int)$id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } else {
            $connection = $this->db->connect();

            $search = trim($filters['search'] ?? '');
            $sort = $filters['sort'] ?? 'StudentID';
            $order = strtoupper($filters['order'] ?? 'ASC');
            $limit = (int)($filters['limit'] ?? 50);

            if (!in_array($sort, $this->allowedSort, true)) {
                $sort = 'StudentID';
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

            $query = "SELECT * FROM studenten";
            if ($search !== '') {
                $query .= " WHERE Voornaam LIKE :search OR Achternaam LIKE :search OR Email LIKE :search OR Studierichting LIKE :search OR StudieStatus LIKE :search";
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
        $id = isset($data['StudentID']) ? (int)$data['StudentID'] : 0;
        $student = $this->normalizeStudentData($data);

        if ($id < 1 || !$this->isValidStudent($student)) {
            return false;
        }

        $query = "
            UPDATE studenten
            SET
                Voornaam = :Voornaam,
                Achternaam = :Achternaam,
                Geboortedatum = :Geboortedatum,
                Geslacht = :Geslacht,
                Email = :Email,
                Studierichting = :Studierichting,
                Startjaar = :Startjaar,
                HuidigJaar = :HuidigJaar,
                StudieStatus = :StudieStatus,
                AchterstalligStudiegeld = :AchterstalligStudiegeld
            WHERE StudentID = :StudentID
        ";
        $stmt = $this->db->connect()->prepare($query);
        return $stmt->execute(array_merge($student, ['StudentID' => $id]));
    }

    public function delete($id) {
        $id = (int)$id;
        if ($id < 1) {
            return false;
        }

        $query = "DELETE FROM studenten WHERE StudentID = :id";
        $stmt = $this->db->connect()->prepare($query);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    private function normalizeStudentData($data) {
        $startjaar = isset($data['Startjaar']) ? (int)$data['Startjaar'] : 0;
        $huidigJaarRaw = trim((string)($data['HuidigJaar'] ?? ''));
        $huidigJaar = $huidigJaarRaw === '' ? null : (int)$huidigJaarRaw;

        $schuldRaw = trim((string)($data['AchterstalligStudiegeld'] ?? ''));
        $schuldRaw = str_replace(['EUR', '€', ' '], '', $schuldRaw);
        $schuldRaw = str_replace(',', '.', $schuldRaw);
        $schuld = null;
        if ($schuldRaw !== '' && $schuldRaw !== '-') {
            $schuld = is_numeric($schuldRaw) ? number_format((float)$schuldRaw, 2, '.', '') : null;
        }

        $geslacht = trim((string)($data['Geslacht'] ?? ''));
        $studierichting = trim((string)($data['Studierichting'] ?? ''));
        $status = trim((string)($data['StudieStatus'] ?? ''));

        return [
            'Voornaam' => trim((string)($data['Voornaam'] ?? '')),
            'Achternaam' => trim((string)($data['Achternaam'] ?? '')),
            'Geboortedatum' => trim((string)($data['Geboortedatum'] ?? '')),
            'Geslacht' => $geslacht === '' ? null : $geslacht,
            'Email' => trim((string)($data['Email'] ?? '')),
            'Studierichting' => $studierichting === '' ? null : $studierichting,
            'Startjaar' => $startjaar,
            'HuidigJaar' => $huidigJaar,
            'StudieStatus' => $status === '' ? null : $status,
            'AchterstalligStudiegeld' => $schuld,
        ];
    }

    private function isValidStudent($student) {
        if ($student['Voornaam'] === '' || strlen($student['Voornaam']) > 50) {
            return false;
        }
        if ($student['Achternaam'] === '' || strlen($student['Achternaam']) > 100) {
            return false;
        }
        if (!$this->isValidDate($student['Geboortedatum'])) {
            return false;
        }
        if (!$this->isValidEmail($student['Email'])) {
            return false;
        }
        if (!$this->isValidYear($student['Startjaar'])) {
            return false;
        }
        if ($student['HuidigJaar'] !== null && !$this->isValidYear($student['HuidigJaar'])) {
            return false;
        }
        if ($student['HuidigJaar'] !== null && $student['HuidigJaar'] < $student['Startjaar']) {
            return false;
        }
        if ($student['Geslacht'] !== null && strlen($student['Geslacht']) > 10) {
            return false;
        }
        if ($student['Studierichting'] !== null && strlen($student['Studierichting']) > 100) {
            return false;
        }
        if ($student['StudieStatus'] !== null && strlen($student['StudieStatus']) > 50) {
            return false;
        }
        if ($student['AchterstalligStudiegeld'] !== null && !is_numeric($student['AchterstalligStudiegeld'])) {
            return false;
        }

        return true;
    }

    private function isValidEmail($email) {
        return filter_var($email, FILTER_VALIDATE_EMAIL) !== false && strlen($email) <= 100;
    }

    private function isValidDate($date) {
        $d = DateTime::createFromFormat('Y-m-d', $date);
        return $d && $d->format('Y-m-d') === $date;
    }

    private function isValidYear($year) {
        return $year >= 1900 && $year <= 2100;
    }
}
?>