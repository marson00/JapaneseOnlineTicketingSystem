<?php
require_once '../config/connection.php';

$cvv = $_GET['cvv'];

$conn = connection::getInstance()->getCon();
$query = "SELECT * FROM card WHERE cvv = :cvv";

$conn->beginTransaction();
$stmt = $conn->prepare($query);
$stmt->bindValue(':cvv', $cvv);
$stmt->execute();
$rows = $stmt->rowCount();
$conn->commit();

echo $rows;