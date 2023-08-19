<?php
require_once '../../config/connection.php';
require_once '../../config/common_functions.php';
include '../../dataEncryption/decryption.php';

$conn = connection::getInstance()->getCon();

if(isset($_GET['userId'])){
    //Decryption
    $decryption = new decryption("userEncryption");
    $userId = $decryption->decrypt($_GET['userId']);
    
//    $userId = $_GET['userId'];
    $action = $_GET['action'];
    $previousStatusId = getStatusId($conn, $userId);
    $statusId = $previousStatusId == 1 ? 2 : 1;
    echo $previousStatusId;
    echo $statusId;
    $query = "UPDATE `user` SET `statusId` = :statusId WHERE `userId` = :userId;";
    
    try {
        $conn->beginTransaction();

        $stmtDetails = $conn->prepare($query);
        $stmtDetails->bindParam(':statusId', $statusId, PDO::PARAM_INT);
        $stmtDetails->bindParam(':userId', $userId, PDO::PARAM_INT);
        $stmtDetails->execute();

        $conn->commit();
        header('Location: view_all_users.php?target=User&action='.$action.'&success=1');
        exit;
    } catch (PDOException $ex) {
        $conn->rollback();
        echo $ex->getMessage();
        echo $ex->getTraceAsString();
        header('Location: view_all_users.php?target=User&action='.$action.'&success=0');
        exit;
    }
}

