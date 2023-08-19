<?php

require_once '../config/connection.php';

$conn = connection::getInstance()->getCon();

$loginInput = $_POST['username'];
$password = $_POST['password'];
$statusId = 1;

$error = true;
$roleId = '';
$userId = '';

$query = "SELECT `userId`, `roleId`, `username`, `password`, `email` 
              FROM user 
              WHERE (username = :username OR email = :email)
              AND password = PASSWORD(:password)
              AND statusId = :statusId";

$stmt = $conn->prepare($query);
$stmt->bindValue(':username', $loginInput);
$stmt->bindValue(':email', $loginInput);
$stmt->bindValue(':password', $password);
$stmt->bindParam(':statusId', $statusId);
$stmt->execute();
$rowCount = $stmt->rowCount();

if ($rowCount > 0) {
    $userData = $stmt->fetch(PDO::FETCH_ASSOC);
    $hashedPassword = $userData['password'];

//    if (!password_verify($password, $hashedPassword)) {
//        $error = true;
//    } else {
        $error = false;
        $roleId = $userData['roleId'];
        $userId = $userData['userId'];
//    }
} else {
    $error = true;
}

$response = array(
    'error' => $error,
    'roleId' => $roleId,
    'userId' => $userId
);

echo json_encode($response);
