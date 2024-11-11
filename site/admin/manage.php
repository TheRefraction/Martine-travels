<?php
include("functions.php");

$table = $_GET['table'] ?? null;

if (!$table) {
    echo "Please select a table to manage.";
    exit;
}

echo "<h1>Manage $table Table</h1>";

$tableDisplayed = false;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $table = $_POST['table'];
    $action = $_POST['action'];
    $id = $_POST['id'] ?? null;

    $data = array_filter($_POST, fn($key) => !in_array($key, ['table', 'action', 'id']), ARRAY_FILTER_USE_KEY);

    if ($action == 'insert') {
        insertData($table, $data);
    } elseif ($action == 'update' && $id) {
        updateData($table, $data, $id);
    } elseif ($action == 'delete' && $id) {
        deleteData($table, $id);
    }

    header("Location: ?table=$table");
    exit;
} elseif ($_SERVER['REQUEST_METHOD'] == 'GET') {

    $table = $_GET['table'] ?? null;
    $action = $_GET['action'] ?? 'view';
    $id = $_GET['id'] ?? null;

    if ($action == 'delete' && $id) {
        deleteData($table, $id);
        header("Location: ?table=$table");
        exit;
    } elseif ($action == 'edit' && $id) {
        displayForm($table, $id);
        $tableDisplayed = true;
    } elseif ($action == 'insert') {
        displayForm($table);
        $tableDisplayed = true;
    }
}

if (!$tableDisplayed) {
    displayTableData($table);
    echo "<a href='?table=$table&action=insert'>Add a new record</a>";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
</head>
<br>
<body><a href="test.php">back</a></body>
</html>
