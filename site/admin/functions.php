
<?php
function get_dbhandle(): PDO
{
$host = "90.125.194.95";
$dbname = "martine_travels";
$dbuser = "martinesql";
$dbpasswd = "martine";
return new PDO("mysql:host=$host;dbname=$dbname", $dbuser, $dbpasswd);
}

$pdo = get_dbhandle();

function getTableColumnsWithType($table) {
global $pdo;
$stmt = $pdo->prepare("DESCRIBE $table");
$stmt->execute();
return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function displayTableData($table) {
global $pdo;
$stmt = $pdo->query("SELECT * FROM $table");
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo "<table border='1'>";
    echo "<tr>";
        foreach (array_keys($rows[0]) as $colName) {
        echo "<th>$colName</th>";
        }
        echo "<th>Actions</th>";
        echo "</tr>";

    foreach ($rows as $row) {
    echo "<tr>";
        foreach ($row as $value) {
        echo "<td>$value</td>";
        }
        echo "<td><a href='?table=$table&action=edit&id=" . $row['ID'] . "'>Edit</a> | <a href='?table=$table&action=delete&id=" . $row['ID'] . "'>Delete</a></td>";
        echo "</tr>";
    }
    echo "</table>";
}

function displayForm($table, $id = null) {
$columns = getTableColumnsWithType($table);
global $pdo;

$values = [];
if ($id) {

$stmt = $pdo->prepare("SELECT * FROM $table WHERE ID = :id");
$stmt->execute(['id' => $id]);
$values = $stmt->fetch(PDO::FETCH_ASSOC);
}

echo "<form method='POST' action=''>";
    echo "<input type='hidden' name='table' value='$table'>";
    echo "<input type='hidden' name='action' value='" . ($id ? 'update' : 'insert') . "'>";
    echo "<input type='hidden' name='id' value='$id'>";

    foreach ($columns as $column) {
    $columnName = $column['Field'];
    $columnType = $column['Type'];
    $value = isset($values[$columnName]) ? htmlspecialchars($values[$columnName]) : '';

    // Example of a field with a dropdown (User ID)
    if (strpos($columnType, 'int') !== false && $columnName == 'User_ID') {
    $stmt = $pdo->prepare("SELECT ID, Name FROM User");
    $stmt->execute();
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo "<label>$columnName: <select name='$columnName'>";
            echo "<option value=''>Select User</option>"; // Empty option to prompt user to choose
            foreach ($users as $user) {
            $selected = $value == $user['ID'] ? 'selected' : ''; // Pre-select the current user
            echo "<option value='" . $user['ID'] . "' $selected>" . htmlspecialchars($user['Name']) . "</option>";
            }
            echo "</select></label><br>";
    }

    else {
    echo "<label>$columnName: <input type='text' name='$columnName' value='$value'></label><br>";
    }
    }

    echo "<button type='submit'>" . ($id ? 'Update' : 'Add') . "</button>";
    echo "</form>";
}

function insertData($table, $data) {
    global $pdo;
    $columns = implode(", ", array_keys($data));
    $placeholders = ":" . implode(", :", array_keys($data));
    $sql = "INSERT INTO $table ($columns) VALUES ($placeholders)";
    $stmt = $pdo->prepare($sql);
    return $stmt->execute($data);
}

function updateData($table, $data, $id) {
    global $pdo;
    $sets = [];
    foreach ($data as $column => $value) {
    $sets[] = "$column = :$column";
}
    $sql = "UPDATE $table SET " . implode(", ", $sets) . " WHERE ID = :id";
    $data['id'] = $id;
    $stmt = $pdo->prepare($sql);
    return $stmt->execute($data);
}

function deleteData($table, $id) {
    global $pdo;
    $sql = "DELETE FROM $table WHERE ID = :id";
    $stmt = $pdo->prepare($sql);
    return $stmt->execute(['id' => $id]);
    }

?>
