<?php
function getNumEvent($conn){
    $query = "SELECT COUNT(*) FROM event";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    return $stmt->fetchColumn();
}
function getNumTicket($conn){
    $query = "SELECT COUNT(*) FROM ticket";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    return $stmt->fetchColumn();
}
function getNumTicketSold($conn){
    $query = "SELECT COUNT(*) FROM ticket WHERE holder IS NOT null";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    return $stmt->fetchColumn();
}
function getNumUser($conn){
    $query = "SELECT COUNT(*) FROM user";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    return $stmt->fetchColumn();
}
function getNumCust($conn){
    $query = "SELECT COUNT(*) FROM user WHERE roleId = 2";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    return $stmt->fetchColumn();
}
function getNumOrder($conn){
    $query = "SELECT COUNT(*) FROM `order`";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    return $stmt->fetchColumn();
}
function getHistoryData($conn, $userId) {
    $query = "SELECT o.orderedDate, t.ticketId, t.statusId, t.ticketCode, e.eventName, e.image, e.location, e.startDate, e.endDate
                FROM `Order` o
                JOIN `Order_Detail` od ON od.orderId = o.orderId
                JOIN `Ticket` t ON t.ticketId = od.ticketId
                JOIN `Event` e ON e.eventId = t.eventId
                WHERE o.`custId` = :holder;";

    $stmt = $conn->prepare($query);
    $stmt->bindValue(':holder', $userId, PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $result;
}

function getTicketId($conn, $eventId) {
    $query = "SELECT ticketId FROM ticket 
                      WHERE eventId = :eventId 
                      AND holder IS null";

    $stmt = $conn->prepare($query);
    $stmt->bindValue(':eventId', $eventId, PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result['ticketId'];
}

function getLatestCardId($conn) {
    $query = "SELECT cardId FROM card ORDER BY cardId DESC LIMIT 1;";

    $stmt = $conn->prepare($query);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result['cardId'];
}

function getLatestOrderId($conn) {
    $query = "SELECT orderId FROM `order` ORDER BY orderId DESC LIMIT 1;";

    $stmt = $conn->prepare($query);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result['orderId'];
}

function getStatusId($conn, $userId) {
    $query = "SELECT `statusId` FROM `user` WHERE `userId` = :userId;";

    $stmt = $conn->prepare($query);
    $stmt->bindParam(':userId', $userId);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result['statusId'];
}

function getEventStatusId($conn, $eventId) {
    $query = "SELECT `statusId` FROM `event` WHERE `eventId` = :eventId;";

    $stmt = $conn->prepare($query);
    $stmt->bindParam(':eventId', $eventId);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result['statusId'];
}

function getEventDataById($conn, $eventId) {
    $query = "SELECT * FROM `event` WHERE `eventId` = :eventId;";

    $stmt = $conn->prepare($query);
    $stmt->bindParam(':eventId', $eventId);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result;
}

function getUserDataById($conn, $userId) {
    $query = "SELECT * FROM `user` WHERE `userId` = :userId;";

    $stmt = $conn->prepare($query);
    $stmt->bindParam(':userId', $userId);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result;
}

function getCategories($conn, $categoryId) {

    $query = "select `categoryId`, `categoryTitle` from `category` 
    order by `categoryId` asc;";

    $stmt = $conn->prepare($query);
    try {
        $stmt->execute();
    } catch (PDOException $ex) {
        echo $ex->getTraceAsString();
        echo $ex->getMessage();
        exit;
    }

    $data = '<option value="">Select Category</option>';

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        if ($row['categoryId'] == $categoryId) {
            $data = $data . '<option value="' . $row['categoryId'] . '" selected>' . $row['categoryTitle'] . '</option>';
        } else {
            $data = $data . '<option value="' . $row['categoryId'] . '">' . $row['categoryTitle'] . '</option>';
        }
    }
    return $data;
}

function getRoles($conn, $roleId) {

    $query = "select `roleId`, `roleTitle` from `role` 
    order by `roleId` asc;";

    $stmt = $conn->prepare($query);
    try {
        $stmt->execute();
    } catch (PDOException $ex) {
        echo $ex->getTraceAsString();
        echo $ex->getMessage();
        exit;
    }

    $data = '<option value="">Select Role</option>';

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        if ($row['roleId'] == $roleId) {
            $data = $data . '<option value="' . $row['roleId'] . '" selected>' . $row['roleTitle'] . '</option>';
        } else {
            $data = $data . '<option value="' . $row['roleId'] . '">' . $row['roleTitle'] . '</option>';
        }
    }
    return $data;
}

function getStatus($conn, $statusId) {

    $query = "select `statusId`, `statusTitle` from `status` 
    order by `statusId` asc;";

    $stmt = $conn->prepare($query);
    try {
        $stmt->execute();
    } catch (PDOException $ex) {
        echo $ex->getTraceAsString();
        echo $ex->getMessage();
        exit;
    }

    $data = '<option value="">Select Status</option>';

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        if ($row['statusId'] == $statusId) {
            $data = $data . '<option value="' . $row['statusId'] . '" selected>' . $row['statusTitle'] . '</option>';
        } else {
            $data = $data . '<option value="' . $row['statusId'] . '">' . $row['statusTitle'] . '</option>';
        }
    }
    return $data;
}

function getRoleTitle($conn, $roleId) {
    $query = "SELECT `roleTitle` from `role` WHERE `roleID` = :roleId;";

    $stmt = $conn->prepare($query);
    $stmt->bindParam(':roleId', $roleId);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result['roleTitle'];
}

function getStatusTitle($conn, $statusId) {
    $query = "SELECT `statusTitle` from `status` WHERE `statusId` = :statusId;";

    $stmt = $conn->prepare($query);
    $stmt->bindParam(':statusId', $statusId);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result['statusTitle'];
}

function getCategoryTitle($conn, $categoryId) {
    $query = "SELECT `categoryTitle` from `category` WHERE `categoryId` = :categoryId;";

    $stmt = $conn->prepare($query);
    $stmt->bindParam(':categoryId', $categoryId);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result['categoryTitle'];
}

function generateTicketCode($eventName, $length) {
    $prefix = strtoupper(substr($eventName, 0, 3));
    $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    $ticketCode = '';
    for ($i = 0; $i < $length; $i++) {
        $ticketCode .= $prefix . "-" . $characters[rand(0, strlen($characters) - 1)];
    }
    return $ticketCode;
}


function search($searchValue){
    
}