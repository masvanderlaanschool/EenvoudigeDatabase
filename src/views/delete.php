<?php
require_once __DIR__ . '/../controllers/CRUDController.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $crudController = new CRUDController();
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $crudController->delete($id);
        header('Location: index.php');
        exit();
    }
} else {
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
            <span class="navbar-brand">Contact Manager</span>
        </div>
    </nav>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="card border-danger shadow-sm">
                    <div class="card-header bg-danger text-white"><h5 class="mb-0">Confirm Deletion</h5></div>
                    <div class="card-body text-center">
                        <p class="mb-4">Are you sure you want to delete this contact? This action cannot be undone.</p>
                        <form method="POST" action="index.php?action=delete&id=<?php echo htmlspecialchars($id); ?>">
                            <a href="index.php" class="btn btn-secondary me-2">Cancel</a>
                            <button type="submit" class="btn btn-danger">Yes, Delete</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>