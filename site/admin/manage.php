<?php
include("functions.php");
include("../connection.php");
include_once('header_admin.php');

if (session_status() === PHP_SESSION_NONE) session_start();
if (!isset($_SESSION['ID'])) {
    header("Location: signin.php");
    exit();}
$ID = $_SESSION['ID'];
$pdo = get_dbhandle();
$stmt = $pdo->prepare("SELECT Is_Admin FROM User WHERE ID = :id");
$stmt->bindParam(':id', $ID, PDO::PARAM_INT);
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$result || $result['Is_Admin'] != 1) {
    header("Location: ../signin.php");
    exit();}

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
        InsertData($table, $data);
    } elseif ($action == 'update' && $id) {
        UpdateData($table, $data, $id);
    } elseif ($action == 'delete' && $id) {
        DeleteData($table, $id);
    }

    header("Location: ?table=$table");
    exit;
} elseif ($_SERVER['REQUEST_METHOD'] == 'GET') {

    $table = $_GET['table'] ?? null;
    $action = $_GET['action'] ?? 'view';
    $id = $_GET['id'] ?? null;

    if ($action == 'delete' && $id) {
        DeleteData($table, $id);
        header("Location: ?table=$table");
        exit;
    } elseif ($action == 'edit' && $id) {
        DisplayForm($table, $id);
        $tableDisplayed = true;
    } elseif ($action == 'insert') {
        DisplayForm($table);
        $tableDisplayed = true;
    }
}

if (!$tableDisplayed) {
    DisplayTableData($table);
    echo "<a href='?table=$table&action=insert'>Add a new record</a>";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link href ="../css/style_admin.css" rel="stylesheet">
</head>
<br>
<body><a href="admin.php">back (manage another table)</a></body>
</html>
