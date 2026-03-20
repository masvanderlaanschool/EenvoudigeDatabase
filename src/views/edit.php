<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../controllers/CRUDController.php';

$crudController = new CRUDController();
$id = $_GET['id'] ?? null;
$data = null;
$error = '';

if ($id) {
    $data = $crudController->read($id);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $updatedData = [
        'StudentID' => $_POST['StudentID'] ?? '',
        'Voornaam' => trim((string)($_POST['Voornaam'] ?? '')),
        'Achternaam' => trim((string)($_POST['Achternaam'] ?? '')),
        'Geboortedatum' => trim((string)($_POST['Geboortedatum'] ?? '')),
        'Geslacht' => trim((string)($_POST['Geslacht'] ?? '')),
        'Email' => trim((string)($_POST['Email'] ?? '')),
        'Studierichting' => trim((string)($_POST['Studierichting'] ?? '')),
        'Startjaar' => trim((string)($_POST['Startjaar'] ?? '')),
        'HuidigJaar' => trim((string)($_POST['HuidigJaar'] ?? '')),
        'StudieStatus' => trim((string)($_POST['StudieStatus'] ?? '')),
        'AchterstalligStudiegeld' => trim((string)($_POST['AchterstalligStudiegeld'] ?? '')),
    ];

    if ($crudController->update($updatedData)) {
        header('Location: index.php');
        exit;
    }

    $error = 'Controleer de ingevoerde studentgegevens en probeer opnieuw.';
    $data = $updatedData;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <title>Student bewerken</title>
</head>
<body class="bg-light">
    <nav class="navbar navbar-dark bg-primary mb-4">
        <div class="container">
            <span class="navbar-brand">Studentenbeheer</span>
        </div>
    </nav>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow-sm">
                    <div class="card-header"><h5 class="mb-0">Student bewerken</h5></div>
                    <div class="card-body">
                        <?php if ($data): ?>
                            <?php if ($error !== ''): ?>
                                <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
                            <?php endif; ?>
                            <form action="index.php?action=edit&id=<?php echo htmlspecialchars($id); ?>" method="POST">
                                <input type="hidden" name="StudentID" value="<?php echo htmlspecialchars($data['StudentID']); ?>">
                                <div class="mb-3">
                                    <label for="Voornaam" class="form-label">Voornaam</label>
                                    <input type="text" class="form-control" id="Voornaam" name="Voornaam" maxlength="50" value="<?php echo htmlspecialchars($data['Voornaam']); ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label for="Achternaam" class="form-label">Achternaam</label>
                                    <input type="text" class="form-control" id="Achternaam" name="Achternaam" maxlength="100" value="<?php echo htmlspecialchars($data['Achternaam']); ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label for="Geboortedatum" class="form-label">Geboortedatum</label>
                                    <input type="date" class="form-control" id="Geboortedatum" name="Geboortedatum" value="<?php echo htmlspecialchars($data['Geboortedatum']); ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label for="Geslacht" class="form-label">Geslacht</label>
                                    <select class="form-select" id="Geslacht" name="Geslacht">
                                        <option value="">Kies...</option>
                                        <option value="Man" <?php echo ($data['Geslacht'] ?? '') === 'Man' ? 'selected' : ''; ?>>Man</option>
                                        <option value="Vrouw" <?php echo ($data['Geslacht'] ?? '') === 'Vrouw' ? 'selected' : ''; ?>>Vrouw</option>
                                        <option value="Anders" <?php echo ($data['Geslacht'] ?? '') === 'Anders' ? 'selected' : ''; ?>>Anders</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="Email" class="form-label">E-mail</label>
                                    <input type="email" class="form-control" id="Email" name="Email" maxlength="100" value="<?php echo htmlspecialchars($data['Email']); ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label for="Studierichting" class="form-label">Studierichting</label>
                                    <input type="text" class="form-control" id="Studierichting" name="Studierichting" maxlength="100" value="<?php echo htmlspecialchars($data['Studierichting'] ?? ''); ?>">
                                </div>
                                <div class="mb-3">
                                    <label for="Startjaar" class="form-label">Startjaar</label>
                                    <input type="number" class="form-control" id="Startjaar" name="Startjaar" min="1900" max="2100" value="<?php echo htmlspecialchars($data['Startjaar']); ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label for="HuidigJaar" class="form-label">Huidig jaar</label>
                                    <input type="number" class="form-control" id="HuidigJaar" name="HuidigJaar" min="1900" max="2100" value="<?php echo htmlspecialchars($data['HuidigJaar'] ?? ''); ?>">
                                </div>
                                <div class="mb-3">
                                    <label for="StudieStatus" class="form-label">Studie status</label>
                                    <input type="text" class="form-control" id="StudieStatus" name="StudieStatus" maxlength="50" value="<?php echo htmlspecialchars($data['StudieStatus'] ?? ''); ?>">
                                </div>
                                <div class="mb-3">
                                    <label for="AchterstalligStudiegeld" class="form-label">Achterstallig studiegeld</label>
                                    <input type="text" class="form-control" id="AchterstalligStudiegeld" name="AchterstalligStudiegeld" value="<?php echo htmlspecialchars($data['AchterstalligStudiegeld'] ?? ''); ?>">
                                </div>
                                <div class="d-flex justify-content-between">
                                    <a href="index.php" class="btn btn-secondary">Annuleren</a>
                                    <button type="submit" class="btn btn-primary">Opslaan</button>
                                </div>
                            </form>
                        <?php else: ?>
                            <p class="text-danger">Student niet gevonden.</p>
                            <a href="index.php" class="btn btn-secondary">Terug naar dashboard</a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>