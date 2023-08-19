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
    $searchQuery = " AND (t.ticketCode LIKE :ticketCode) 
                    OR (t.holder LIKE :holder)
                    OR (e.eventName LIKE :eventName) 
                    OR (s.statusTitle LIKE :statusTitle) ";
    $searchArray = array(
        'ticketCode' => "%$searchValue%",
        'holder' => "%$searchValue%",
        'eventName' => "%$searchValue%",
        'statusTitle' => "%$searchValue%"
    );
}

## Total number of records without filtering
$stmt = $conn->prepare("SELECT COUNT(*) AS allcount FROM ticket ");
$stmt->execute();
$records = $stmt->fetch();
$totalRecords = $records['allcount'];

## Total number of records with filtering
$stmt = $conn->prepare("SELECT COUNT(*) AS allcount 
                         FROM ticket AS t
                        JOIN status AS s ON t.statusId=s.statusId
                        JOIN event AS e ON t.eventId = e.eventId
                        WHERE 1 " . $searchQuery);
$stmt->execute($searchArray);
$records = $stmt->fetch();
$totalRecordwithFilter = $records['allcount'];

## Fetch records
$stmt = $conn->prepare("SELECT t.*, s.statusTitle, e.eventName
         FROM ticket AS t
         JOIN status AS s ON t.statusId=s.statusId
         JOIN event AS e ON t.eventId=e.eventId
         WHERE 1 " . $searchQuery . " 
         ORDER BY " . $columnName . " " . $columnSortOrder . "
         LIMIT :limit,:offset");

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
        "ticketId" => $row['ticketId'],
        "ticketCode" => $row['ticketCode'],
        "eventName" => $row['eventName'],
        "statusTitle" => $row['statusTitle'],
        "holder" => $row['holder']
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
