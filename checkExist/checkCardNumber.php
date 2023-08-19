<?php
require_once '../config/connection.php';

$cardNum = $_GET['cardNum'];

$conn = connection::getInstance()->getCon();
$query = "SELECT * FROM card WHERE cardNum = :cardNum";

$conn->beginTransaction();
$stmt = $conn->prepare($query);
$stmt->bindValue(':cardNum', $cardNum);
$stmt->execute();
$rows = $stmt->rowCount();
$conn->commit();

echo $rows;