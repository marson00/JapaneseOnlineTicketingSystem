<?php
require_once '../config/connection.php';

$categoryTitle = $_GET['categoryTitle'];

$conn = connection::getInstance()->getCon();
$query = "SELECT * FROM category WHERE categoryTitle = '$categoryTitle' ";

$conn->beginTransaction();
$stmt = $conn->prepare($query);
$stmt->execute();
$rows = $stmt->rowCount();
$conn->commit();

echo $rows;