
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

    if (empty($rows)) {
        echo "<p>No records found in the $table table.</p>";
        return;
    }

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



function getForeignKeys($table) {
    global $pdo;
    $query = "
        SELECT COLUMN_NAME, REFERENCED_TABLE_NAME
        FROM INFORMATION_SCHEMA.KEY_COLUMN_USAGE
        WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = :table AND REFERENCED_TABLE_NAME IS NOT NULL";
    $stmt = $pdo->prepare($query);
    $stmt->execute(['table' => $table]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
function displayForm($table, $id = null) {
    global $pdo;

    $columns = getTableColumnsWithType($table);
    $foreignKeys = getForeignKeys($table);

    $foreignKeyMap = [];
    foreach ($foreignKeys as $foreignKey) {
        $foreignKeyMap[$foreignKey['COLUMN_NAME']] = $foreignKey['REFERENCED_TABLE_NAME'];
    }

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
        if ($columnName == 'ID' && !$id) {
            continue;
        }

        $value = isset($values[$columnName]) ? htmlspecialchars($values[$columnName]) : '';

        if (isset($foreignKeyMap[$columnName])) {
            $referencedTable = $foreignKeyMap[$columnName];
            $displayField = getDisplayField($referencedTable);
            $query = "SELECT ID, $displayField AS DisplayName FROM $referencedTable";
            $stmt = $pdo->prepare($query);
            $stmt->execute();
            $options = $stmt->fetchAll(PDO::FETCH_ASSOC);

            echo "<label>$columnName: <select name='$columnName'>";
            echo "<option value=''>Sélectionner une option</option>";
            foreach ($options as $option) {
                $selected = $value == $option['ID'] ? 'selected' : '';
                echo "<option value='" . $option['ID'] . "' $selected>" . htmlspecialchars($option['DisplayName']) . "</option>";
            }
            echo "</select></label><br>";
        } else {
            echo "<label>$columnName: <input type='text' name='$columnName' value='$value'></label><br>";
        }
    }

    echo "<button type='submit'>" . ($id ? 'Mettre à jour' : 'Ajouter') . "</button>";
    echo "</form>";
}



function getDisplayField($tableName) {
    switch ($tableName) {
        case 'User':
            return "CONCAT(First_Name, ' ', Last_Name)";
        case 'Accommodation':
            return "Room_Type_ID";
        case 'Package':
            return "Type_ID";

        default:
            return "ID";
    }
}




function insertData($table, $data) {
    global $pdo;

    if (isset($data['ID'])) {
        unset($data['ID']);
    }

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


    if (!$table || !$id) {
        echo "Table or ID missing.";
        return false;
    }


    $sql = "DELETE FROM $table WHERE ID = :id";
    $stmt = $pdo->prepare($sql);


    if ($stmt->execute(['id' => $id])) {
        echo "succes.";
        return true;
    } else {
        echo "Erreur";
        return false;
    }
}

?>
