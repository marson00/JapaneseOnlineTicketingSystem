<?php
require_once './connection.php';
require_once './common_functions.php';

$email = $_GET['email'];
$newPwd = $_GET['password']; 

$conn = connection::getInstance()->getCon();
$query = "UPDATE user SET `password` = PASSWORD(:password) WHERE "
        . "`email` = :email";

$conn->beginTransaction();
$stmt = $conn->prepare($query);
$stmt->bindValue(':password', $newPwd);
$stmt->bindValue(':email', $email);
$stmt->execute();
$conn->commit();

//echo $rows;
echo "Successfully updated the new password";