<?php
require_once '../config/connection.php';

$roleTitle = $_GET['roleTitle'];

$conn = connection::getInstance()->getCon();
$query = "SELECT * FROM role WHERE roleTitle = '$roleTitle' ";

$conn->beginTransaction();
$stmt = $conn->prepare($query);
$stmt->execute();
$rows = $stmt->rowCount();
$conn->commit();


echo $rows;