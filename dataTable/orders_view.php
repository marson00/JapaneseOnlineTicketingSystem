<?php

include '../config/connection.php';

$conn = connection::getInstance()->getCon();

## Read value
$draw = $_POST['draw']; //
$row = $_POST['start']; //Retrieve the first row index 
$rowperpage = $_POST['length']; // Rows display per page
$columnIndex = $_POST['order'][0]['column']; // Column index
$columnName = $_POST['columns'][$columnIndex]['data']; // Column name
$columnSortOrder = $_POST['order'][0]['dir']; // asc or desc
$searchValue = $_POST['search']['value']; // Search value

$searchArray = array();

## Search 
$searchQuery = " ";
if ($searchValue != '') {
    $searchQuery = " AND (r.orderId LIKE :orderId) 
                     OR (r.purchaseQty LIKE :purchaseQty) 
                     OR (r.totalPrice LIKE :totalPrice) 
                     OR (r.orderedDate LIKE :orderedDate) 
                     OR (e.eventName LIKE :eventName) 
                     OR (u.username LIKE :username) 
                     OR (c.cardType LIKE :cardType) ";
    $searchArray = array(
        'orderId' => "%$searchValue%",
        'purchaseQty' => "%$searchValue%",
        'totalPrice' => "%$searchValue%",
        'orderedDate' => "%$searchValue%",
        'eventName' => "%$searchValue%",
        'username' => "%$searchValue%",
        'cardType' => "%$searchValue%",
    );
}

## Total number of records without filtering
$stmt = $conn->prepare("SELECT COUNT(*) AS allcount FROM `order` ");
$stmt->execute();
$records = $stmt->fetch();
$totalRecords = $records['allcount'];

## Total number of records with filtering
$stmt = $conn->prepare("SELECT COUNT(*) AS allcount FROM `order` AS r
                        JOIN event AS e ON r.eventId=e.eventId
                        JOIN user AS u ON r.custId=u.userId
                        WHERE 1 " . $searchQuery);
$stmt->execute($searchArray);
$records = $stmt->fetch();
$totalRecordwithFilter = $records['allcount'];

## Fetch records
$stmt = $conn->prepare("SELECT r.*, e.eventName, u.username, c.cardType
                        FROM `order` AS r
                        JOIN event AS e ON r.eventId=e.eventId
                        JOIN user AS u ON r.custId=u.userId
                        JOIN payment AS p ON p.orderId=r.orderId
                        JOIN card AS c ON p.cardId=c.cardId
                        WHERE 1 " . $searchQuery . " ORDER BY " . $columnName . " " . $columnSortOrder . " LIMIT :limit,:offset");

// Bind values
foreach ($searchArray as $key => $search) {
    $stmt->bindValue(':' . $key, $search, PDO::PARAM_STR);
}

$stmt->bindValue(':limit', (int) $row, PDO::PARAM_INT);
$stmt->bindValue(':offset', (int) $rowperpage, PDO::PARAM_INT);
$stmt->execute();
$empRecords = $stmt->fetchAll();

$data = array();

foreach ($empRecords as $row) {
    $data[] = array(
        "orderId" => $row['orderId'],
        "orderedEvent" => $row['eventName'],
        "orderedQty" => $row['purchaseQty'],
        "orderedPrice" => $row['totalPrice'],
        "orderedBy" => $row['username'],
        "orderedDate" => $row['orderedDate'],
        "orderedCard" => $row['cardType'],
    );
}

## Response
$response = array(
    "draw" => intval($draw),
    "iTotalRecords" => $totalRecords,
    "iTotalDisplayRecords" => $totalRecordwithFilter,
    "aaData" => $data
);

echo json_encode($response);
