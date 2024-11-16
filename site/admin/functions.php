<?php
include("../connection.php");
$pdo = get_dbhandle();

function GetTableColumnsWithType($table) {
    global $pdo;
    $stmt = $pdo->prepare("DESCRIBE $table");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function DisplayTableData($table) {
    global $pdo;
    $stmt = $pdo->query("SELECT * FROM $table");
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (empty($rows)) {
        echo "<p>Nothing found in the $table table.</p>";
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

function GetForeignKeys($table) {
    global $pdo;
    $query = "
        SELECT COLUMN_NAME, REFERENCED_TABLE_NAME
        FROM INFORMATION_SCHEMA.KEY_COLUMN_USAGE
        WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = :table AND REFERENCED_TABLE_NAME IS NOT NULL";
    $stmt = $pdo->prepare($query);
    $stmt->execute(['table' => $table]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function DisplayForm($table, $id = null) {
    global $pdo;

    $columns = GetTableColumnsWithType($table);
    $foreignKeys = GetForeignKeys($table);

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

        if ($columnName == 'ID') {
            continue;
        }
        $value = isset($values[$columnName]) ? htmlspecialchars($values[$columnName]) : '';

        if (isset($foreignKeyMap[$columnName])) {
            $referencedTable = $foreignKeyMap[$columnName];
            $displayField = GetDisplayField($referencedTable);
            $stmt = $pdo->prepare("SELECT ID, $displayField as DisplayName FROM $referencedTable");
            $stmt->execute();
            $options = $stmt->fetchAll(PDO::FETCH_ASSOC);

            echo "<label>$columnName: <select name='$columnName'>";
            echo "<option value=''>Select an option</option>";
            foreach ($options as $option) {
                $selected = $value == $option['ID'] ? 'selected' : '';
                echo "<option value='" . $option['ID'] . "' $selected>" . htmlspecialchars($option['DisplayName']) . "</option>";
            }
            echo "</select></label><br>";
        }

        else if (strpos($columnType, 'date') !== false || strpos($columnType, 'time') !== false) {
            $inputType = 'text';
            if (strpos($columnType, 'timestamp') !== false) {
                $inputType = 'datetime-local';
                if ($value) {
                    $value = date('Y-m-d\TH:i', strtotime($value)); // Format datetime
                }
            } elseif (strpos($columnType, 'date') !== false) {
                $inputType = 'date';
                if ($value) {
                    $value = date('Y-m-d', strtotime($value));
                }
            } elseif (strpos($columnType, 'time') !== false) {
                $inputType = 'time';
                if ($value) {
                    $value = date('H:i', strtotime($value));
                }
            }
            echo "<label>$columnName: <input type='$inputType' name='$columnName' value='$value'></label><br>";
        }

        else if (strpos($columnType, 'int') !== false || strpos($columnType, 'decimal') !== false || strpos($columnType, 'float') !== false || strpos($columnType, 'double') !== false) {
            echo "<label>$columnName: <input type='number' name='$columnName' value='$value'></label><br>";
        }

        else {
            echo "<label>$columnName: <input type='text' name='$columnName' value='$value'></label><br>";
        }
    }

    echo "<button type='submit'>" . ($id ? 'Update' : 'Add') . "</button>";
    echo "</form>";
}



function GetDisplayField($tableName) {
    switch ($tableName) {
        case 'User':
            return "CONCAT(First_Name, ' ', Last_Name)";
        case 'Accommodation_Type':
            return "Name";
        case 'Address_Country':
            return "Name";
        case 'Address_Street':
            return "Name";
        case 'Address_Town':
            return "Name";
        case 'Amenity':
            return "Name";
        case 'Package_Type':
            return "Name";
        case 'Payment_Method':
            return "Name";
        case 'Room_Type':
            return "Name";
        case 'County':
            return "Name";
        case 'Transportation_Provider':
            return "Name";
        case 'Transportation_Type':
            return "Name";
        case 'Package':
            return  "CONCAT(
            (SELECT Package_Type.Name FROM Package_Type WHERE Package.Type_ID = Package_Type.ID) , 
            ' - ' , 
            (SELECT Address_Country.Name 
                     FROM Address 
                     INNER JOIN Address_Country ON Address.Country_ID = Address_Country.ID 
                     WHERE Address.ID = Package.Address_ID),
            ' - ' , 
            (SELECT Address_Town.Name 
                     FROM Address 
                     INNER JOIN Address_Town ON Address.Town_ID = Address_Town.ID 
                     WHERE Address.ID = Package.Address_ID),
            ' - ' ,
            Duration , ' days ',' - ' , Price , '€ '
            )";
        case 'Accommodation':
            return "CONCAT(
            (SELECT Accommodation_Provider.Name FROM Accommodation_Provider WHERE Accommodation.Provider_ID = Accommodation_Provider.ID) ,
            ' - ',
            (SELECT Room_Type.Name FROM Room_Type WHERE Accommodation.Room_Type_ID = Room_Type.ID) ,
            ' - ', 
            Price_Per_Night
            )";
        case 'Transportation':
            return "CONCAT(
            (SELECT Transportation_Type.Name FROM Transportation_Type WHERE Transportation.Type_ID = Transportation_Type.ID), 
            ' - ', 
            (SELECT Transportation_Provider.Name FROM Transportation_Provider WHERE Transportation.Provider_ID = Transportation_Provider.ID), 
            ' - ', 
            Date_Departure
        )";

        case 'Reservation':
            return "CONCAT(
            (SELECT User.Last_Name FROM User WHERE User.ID = Reservation.Client_ID),
            ' - ', Status
    )";
        default:
            return "ID";
    }
}

function InsertData($table, $data) {
    global $pdo;

    if ($table == 'User' && isset($data['Password'])) {
        $data['Password'] = password_hash($data['Password'], PASSWORD_DEFAULT);
    }
    $columns = implode(", ", array_keys($data));
    $placeholders = ":" . implode(", :", array_keys($data));

    $sql = "INSERT INTO $table ($columns) VALUES ($placeholders)";
    $stmt = $pdo->prepare($sql);

    return $stmt->execute($data);
}

function UpdateData($table, $data, $id) {
    global $pdo;

    if ($table == 'User' && isset($data['Password'])) {
        $data['Password'] = password_hash($data['Password'], PASSWORD_DEFAULT);
    }

    $sets = [];
    foreach ($data as $column => $value) {
        $sets[] = "$column = :$column";
    }
    $sql = "UPDATE $table SET " . implode(", ", $sets) . " WHERE ID = :id";
    $data['id'] = $id;
    $stmt = $pdo->prepare($sql);
    return $stmt->execute($data);
}

function DeleteData($table, $id) {
    global $pdo;
    if (!$table || !$id) {
        return false;
    }
    $sql = "DELETE FROM $table WHERE ID = :id";
    $stmt = $pdo->prepare($sql);
    return $stmt->execute(['id' => $id]);
}
?>
