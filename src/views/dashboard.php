<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../controllers/CRUDController.php';

$crudController = new CRUDController();
$records = $crudController->read();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <title>Dashboard</title>
</head>
<body class="bg-light">
    <nav class="navbar navbar-dark bg-primary mb-4">
        <div class="container">
            <span class="navbar-brand">Contact Manager</span>
        </div>
    </nav>
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h1 class="h3">Contacts</h1>
            <a href="index.php?action=create" class="btn btn-success">+ New Contact</a>
        </div>
        <div class="card shadow-sm">
            <div class="card-body p-0">
                <table class="table table-striped table-hover mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($records): ?>
                            <?php foreach ($records as $record): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($record['id']); ?></td>
                                    <td><?php echo htmlspecialchars($record['name']); ?></td>
                                    <td><?php echo htmlspecialchars($record['email']); ?></td>
                                    <td>
                                        <a href="index.php?action=edit&id=<?php echo htmlspecialchars($record['id']); ?>" class="btn btn-sm btn-primary">Edit</a>
                                        <a href="index.php?action=delete&id=<?php echo htmlspecialchars($record['id']); ?>" class="btn btn-sm btn-danger">Delete</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="4" class="text-center text-muted py-4">No contacts found.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>