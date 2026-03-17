<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../controllers/CRUDController.php';

$crudController = new CRUDController();
$id = $_GET['id'] ?? null;
$data = null;

if ($id) {
    $data = $crudController->read($id);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $updatedData = [
        'id' => $_POST['id'],
        'name' => $_POST['name'],
        'email' => $_POST['email'],
    ];
    $crudController->update($updatedData);
    header('Location: index.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <title>Edit Contact</title>
</head>
<body class="bg-light">
    <nav class="navbar navbar-dark bg-primary mb-4">
        <div class="container">
            <span class="navbar-brand">Contact Manager</span>
        </div>
    </nav>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow-sm">
                    <div class="card-header"><h5 class="mb-0">Edit Contact</h5></div>
                    <div class="card-body">
                        <?php if ($data): ?>
                            <form action="index.php?action=edit&id=<?php echo htmlspecialchars($id); ?>" method="POST">
                                <input type="hidden" name="id" value="<?php echo htmlspecialchars($data['id']); ?>">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Name</label>
                                    <input type="text" class="form-control" id="name" name="name" value="<?php echo htmlspecialchars($data['name']); ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($data['email']); ?>" required>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <a href="index.php" class="btn btn-secondary">Cancel</a>
                                    <button type="submit" class="btn btn-primary">Save Changes</button>
                                </div>
                            </form>
                        <?php else: ?>
                            <p class="text-danger">Contact not found.</p>
                            <a href="index.php" class="btn btn-secondary">Back to Dashboard</a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>