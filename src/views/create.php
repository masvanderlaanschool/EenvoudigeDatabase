<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../controllers/CRUDController.php';

$crudController = new CRUDController();
$error = '';
$formData = [
    'Voornaam' => '',
    'Achternaam' => '',
    'Geboortedatum' => '',
    'Geslacht' => '',
    'Email' => '',
    'Studierichting' => '',
    'Startjaar' => '',
    'HuidigJaar' => '',
    'StudieStatus' => '',
    'AchterstalligStudiegeld' => '',
];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    foreach ($formData as $key => $_) {
        $formData[$key] = trim((string)($_POST[$key] ?? ''));
    }

    if ($crudController->createRecord($formData)) {
        header('Location: index.php');
        exit();
    }

    $error = 'Controleer de ingevoerde studentgegevens en probeer opnieuw.';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <title>Nieuwe student</title>
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
                    <div class="card-header"><h5 class="mb-0">Nieuwe student</h5></div>
                    <div class="card-body">
                        <?php if ($error !== ''): ?>
                            <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
                        <?php endif; ?>
                        <form action="index.php?action=create" method="POST">
                            <div class="mb-3">
                                <label for="Voornaam" class="form-label">Voornaam</label>
                                <input type="text" class="form-control" id="Voornaam" name="Voornaam" maxlength="50" value="<?php echo htmlspecialchars($formData['Voornaam']); ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="Achternaam" class="form-label">Achternaam</label>
                                <input type="text" class="form-control" id="Achternaam" name="Achternaam" maxlength="100" value="<?php echo htmlspecialchars($formData['Achternaam']); ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="Geboortedatum" class="form-label">Geboortedatum</label>
                                <input type="date" class="form-control" id="Geboortedatum" name="Geboortedatum" value="<?php echo htmlspecialchars($formData['Geboortedatum']); ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="Geslacht" class="form-label">Geslacht</label>
                                <select class="form-select" id="Geslacht" name="Geslacht">
                                    <option value="">Kies...</option>
                                    <option value="Man" <?php echo $formData['Geslacht'] === 'Man' ? 'selected' : ''; ?>>Man</option>
                                    <option value="Vrouw" <?php echo $formData['Geslacht'] === 'Vrouw' ? 'selected' : ''; ?>>Vrouw</option>
                                    <option value="Anders" <?php echo $formData['Geslacht'] === 'Anders' ? 'selected' : ''; ?>>Anders</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="Email" class="form-label">E-mail</label>
                                <input type="email" class="form-control" id="Email" name="Email" maxlength="100" value="<?php echo htmlspecialchars($formData['Email']); ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="Studierichting" class="form-label">Studierichting</label>
                                <input type="text" class="form-control" id="Studierichting" name="Studierichting" maxlength="100" value="<?php echo htmlspecialchars($formData['Studierichting']); ?>">
                            </div>
                            <div class="mb-3">
                                <label for="Startjaar" class="form-label">Startjaar</label>
                                <input type="number" class="form-control" id="Startjaar" name="Startjaar" min="1900" max="2100" value="<?php echo htmlspecialchars($formData['Startjaar']); ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="HuidigJaar" class="form-label">Huidig jaar</label>
                                <input type="number" class="form-control" id="HuidigJaar" name="HuidigJaar" min="1900" max="2100" value="<?php echo htmlspecialchars($formData['HuidigJaar']); ?>">
                            </div>
                            <div class="mb-3">
                                <label for="StudieStatus" class="form-label">Studie status</label>
                                <input type="text" class="form-control" id="StudieStatus" name="StudieStatus" maxlength="50" value="<?php echo htmlspecialchars($formData['StudieStatus']); ?>">
                            </div>
                            <div class="mb-3">
                                <label for="AchterstalligStudiegeld" class="form-label">Achterstallig studiegeld</label>
                                <input type="text" class="form-control" id="AchterstalligStudiegeld" name="AchterstalligStudiegeld" placeholder="bijv. 112,48" value="<?php echo htmlspecialchars($formData['AchterstalligStudiegeld']); ?>">
                            </div>
                            <div class="d-flex justify-content-between">
                                <a href="index.php" class="btn btn-secondary">Annuleren</a>
                                <button type="submit" class="btn btn-success">Opslaan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>