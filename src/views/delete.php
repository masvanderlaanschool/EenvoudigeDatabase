<?php
require_once __DIR__ . '/../controllers/CRUDController.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id < 1) {
    header('Location: index.php');
    exit();
}

$crudController = new CRUDController();
$record = $crudController->read($id);

if (!$record) {
    header('Location: index.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $crudController->delete($id);
    header('Location: index.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <title>Delete Contact</title>
</head>
<body class="bg-light">
    <nav class="navbar navbar-dark bg-primary mb-4">
        <div class="container">
            <span class="navbar-brand">Studentenbeheer</span>
        </div>
    </nav>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="card border-danger shadow-sm">
                    <div class="card-header bg-danger text-white"><h5 class="mb-0">Verwijderen bevestigen</h5></div>
                    <div class="card-body text-center">
                        <p class="mb-4">Weet je zeker dat je deze student wilt verwijderen? Deze actie kan niet ongedaan worden gemaakt.</p>
                        <form method="POST" action="index.php?action=delete&id=<?php echo htmlspecialchars($id); ?>">
                            <a href="index.php" class="btn btn-secondary me-2">Annuleren</a>
                            <button type="submit" class="btn btn-danger">Ja, verwijderen</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>