<?php
require_once '../../config/connection.php';
require_once '../../config/common_functions.php';
include '../../dataEncryption/decryption.php';

$conn = connection::getInstance()->getCon();

if(isset($_GET['eventId'])){
    //Decryption
    $decryption = new decryption("eventEncryption");
    $eventId = $decryption->decrypt($_GET['eventId']);
    
    $action = $_GET['action'];
    $previousStatusId = getEventStatusId($conn, $eventId);
    $statusId = $previousStatusId == 1 ? 2 : 1;
    echo $previousStatusId;
    echo $statusId;
    $query = "UPDATE `event` SET `statusId` = :statusId WHERE `eventId` = :eventId;";
    $ticketStatus = "UPDATE `ticket` SET `statusId` = :statusId WHERE `eventId` = :eventId;";
    
    try {
        $conn->beginTransaction();

        $stmtDetails = $conn->prepare($query);
        $stmtDetails->bindParam(':statusId', $statusId, PDO::PARAM_INT);
        $stmtDetails->bindParam(':eventId', $eventId, PDO::PARAM_INT);
        $stmtDetails->execute();
        
        //Set ticket status reflecting to the event status
        $ticketStmt = $conn->prepare($ticketStatus);
        $ticketStmt->bindParam(':statusId', $statusId, PDO::PARAM_INT);
        $ticketStmt->bindParam(':eventId', $eventId, PDO::PARAM_INT);
        $ticketStmt->execute();
        
        $conn->commit(); ; 
        header('Location: view_all_events.php?target=Event&action='.$action.'&success=1');
        exit;
    } catch (PDOException $ex) {
        $conn->rollback();
        echo $ex->getMessage();
        echo $ex->getTraceAsString();
        header('Location: view_all_events.php?target=Event&action='.$action.'&success=0');
        exit;
    }
}

