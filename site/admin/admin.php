
<?php
include_once("functions.php");
include_once("../connection.php");
include('header_admin.php');

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
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Database Table Management</title>
    <link href ="../css/style_admin.css" rel="stylesheet">
</head>
<body>
<h1>Manage Database Tables</h1>
<ul>
    <li><a href="manage.php?table=Accommodation">Manage Accommodation Table</a></li>
    <li><a href="manage.php?table=Accommodation_Join">Manage Accommodation_Join Table</a></li>
    <li><a href="manage.php?table=Accommodation_Provider">Manage Accommodation_Provider Table</a></li>
    <li><a href="manage.php?table=Accommodation_Type">Manage Accommodation_Type Table</a></li>
    <li><a href="manage.php?table=Address">Manage Address Table</a></li>
    <li><a href="manage.php?table=Address_Country">Manage Address_Country Table</a></li>
    <li><a href="manage.php?table=Address_County">Manage Address_County Table</a></li>
    <li><a href="manage.php?table=Address_Street">Manage Address_Street Table</a></li>
    <li><a href="manage.php?table=Address_Town">Manage Address_Town Table</a></li>
    <li><a href="manage.php?table=Amenity">Manage Amenity Table</a></li>
    <li><a href="manage.php?table=Amenity_Join">Manage Amenity_Join Table</a></li>
    <li><a href="manage.php?table=Package">Manage Package Table</a></li>
    <li><a href="manage.php?table=Package_Type">Manage Package_Type Table</a></li>
    <li><a href="manage.php?table=Payment"> Manage Payment Table</a></li>
    <li><a href="manage.php?table=Payment_Method">Manage Payment_Method Table</a></li>
    <li><a href="manage.php?table=Reservation">Manage Reservation Table</a></li>
    <li><a href="manage.php?table=Review">Manage Review Table</a></li>
    <li><a href="manage.php?table=Room_Type">Manage Room_Type Table</a></li>
    <li><a href="manage.php?table=Transportation">Manage Transportation Table</a></li>
    <li><a href="manage.php?table=Transportation_Join">Manage Transportation_Join Table</a></li>
    <li><a href="manage.php?table=Transportation_Preferences">Manage Transportation_Preferences Table</a></li>
    <li><a href="manage.php?table=Transportation_Provider">Manage Transportation_Provider Table</a></li>
    <li><a href="manage.php?table=Transportation_Type">Manage Transportation_Type Table</a></li>
    <li><a href="manage.php?table=User">Manage User Table</a></li>
</ul>
</body>
</html>
