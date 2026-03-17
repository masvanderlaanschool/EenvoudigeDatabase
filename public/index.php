<?php
require_once '../src/config/database.php';
require_once '../src/controllers/CRUDController.php';

$controller = new CRUDController();

$action = $_GET['action'] ?? 'dashboard';

switch ($action) {
    case 'create':
        require_once '../src/views/create.php';
        break;
    case 'edit':
        require_once '../src/views/edit.php';
        break;
    case 'delete':
        require_once '../src/views/delete.php';
        break;
    case 'dashboard':
    default:
        require_once '../src/views/dashboard.php';
        break;
}
?>