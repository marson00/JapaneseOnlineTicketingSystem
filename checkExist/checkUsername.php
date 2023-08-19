<?php
require_once '../config/connection.php';

$username = $_GET['username'];

$conn = connection::getInstance()->getCon();
$query = "SELECT * FROM user WHERE username = '$username'";

$conn->beginTransaction();
$stmt = $conn->prepare($query);
$stmt->execute();
$rows = $stmt->rowCount();
$conn->commit();


echo $rows;