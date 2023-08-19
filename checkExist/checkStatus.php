<?php
require_once '../config/connection.php';

$statusTitle = $_GET['statusTitle'];

$conn = connection::getInstance()->getCon();
$query = "SELECT * FROM status WHERE statusTitle = '$statusTitle' ";

$conn->beginTransaction();
$stmt = $conn->prepare($query);
$stmt->execute();
$rows = $stmt->rowCount();
$conn->commit();

echo $rows;