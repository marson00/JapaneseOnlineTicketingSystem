<?php

require_once '../config/connection.php';

$email = $_GET['email'];

$conn = connection::getInstance()->getCon();
$query = "SELECT * FROM user WHERE email = '$email'";

$conn->beginTransaction();
$stmt = $conn->prepare($query);
$stmt->execute();
$rows = $stmt->rowCount();
$conn->commit();

//echo $rows;
echo $rows;

