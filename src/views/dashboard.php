<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../controllers/CRUDController.php';

$crudController = new CRUDController();

$search = trim($_GET['search'] ?? '');
$sort = $_GET['sort'] ?? 'id';
$order = strtoupper($_GET['order'] ?? 'ASC');
$limit = (int)($_GET['limit'] ?? 50);

$records = $crudController->read(null, [
    'search' => $search,
    'sort' => $sort,
    'order' => $order,
    'limit' => $limit,
]);

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
        <div class="card shadow-sm mb-3">
            <div class="card-body">
                <form method="GET" action="index.php" class="row g-2">
                    <input type="hidden" name="action" value="dashboard">
                    <div class="col-md-4">
                        <input
                            type="text"
                            name="search"
                            class="form-control"
                            placeholder="Search by name or email"
                            value="<?php echo htmlspecialchars($search); ?>"
                        >
                    </div>
                    <div class="col-md-2">
                        <select name="sort" class="form-select">
                            <option value="id" <?php echo $sort === 'id' ? 'selected' : ''; ?>>Sort: ID</option>
                            <option value="name" <?php echo $sort === 'name' ? 'selected' : ''; ?>>Sort: Name</option>
                            <option value="email" <?php echo $sort === 'email' ? 'selected' : ''; ?>>Sort: Email</option>
                            <option value="created_at" <?php echo $sort === 'created_at' ? 'selected' : ''; ?>>Sort: Date</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <select name="order" class="form-select">
                            <option value="ASC" <?php echo $order === 'ASC' ? 'selected' : ''; ?>>A-Z / Old-New</option>
                            <option value="DESC" <?php echo $order === 'DESC' ? 'selected' : ''; ?>>Z-A / New-Old</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <select name="limit" class="form-select">
                            <option value="10" <?php echo $limit === 10 ? 'selected' : ''; ?>>10 rows</option>
                            <option value="25" <?php echo $limit === 25 ? 'selected' : ''; ?>>25 rows</option>
                            <option value="50" <?php echo $limit === 50 ? 'selected' : ''; ?>>50 rows</option>
                            <option value="100" <?php echo $limit === 100 ? 'selected' : ''; ?>>100 rows</option>
                        </select>
                    </div>
                    <div class="col-md-2 d-grid">
                        <button type="submit" class="btn btn-outline-primary">Apply</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="card shadow-sm">
            <div class="card-body p-0">
                <table class="table table-striped table-hover mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Date Added</th>
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
                                        <?php
                                        if (!empty($record['created_at'])) {
                                            echo htmlspecialchars(date('Y-m-d H:i', strtotime($record['created_at'])));
                                        } else {
                                            echo 'Unknown';
                                        }
                                        ?>
                                    </td>
                                    <td>
                                        <a href="index.php?action=edit&id=<?php echo htmlspecialchars($record['id']); ?>" class="btn btn-sm btn-primary">Edit</a>
                                        <a href="index.php?action=delete&id=<?php echo htmlspecialchars($record['id']); ?>" class="btn btn-sm btn-danger">Delete</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5" class="text-center text-muted py-4">No contacts found.</td>
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