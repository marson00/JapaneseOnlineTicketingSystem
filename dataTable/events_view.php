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
    $searchQuery = " AND (e.eventId LIKE :eventId) 
                OR (e.eventName LIKE :eventName) 
                OR (e.image LIKE :image) 
                OR (e.capacity LIKE :capacity) 
                OR (e.quantityLeft LIKE :quantityLeft) 
                OR (e.startDate LIKE :startDate) 
                OR (e.endDate LIKE :endDate) 
                OR (e.price LIKE :price)
                OR (s.statusTitle LIKE :statusTitle)
                OR (c.categoryTitle LIKE :categoryTitle) ";
    $searchArray = array(
        'eventId' => "%$searchValue%",
        'eventName' => "%$searchValue%",
        'image' => "%$searchValue%",
        'capacity' => "%$searchValue%",
        'quantityLeft' => "%$searchValue%",
        'startDate' => "%$searchValue%",
        'endDate' => "%$searchValue%",
        'price' => "%$searchValue%",
        'statusTitle' => "%$searchValue%",
        'categoryTitle' => "%$searchValue%",
    );
}

## Total number of records without filtering
$stmt = $conn->prepare("SELECT COUNT(*) AS allcount FROM event As e");
$stmt->execute();
$records = $stmt->fetch();
$totalRecords = $records['allcount'];

## Total number of records with filtering
$stmt = $conn->prepare("SELECT COUNT(*) AS allcount FROM event As e
                        JOIN status AS s ON e.statusId=s.statusId
                        JOIN category AS c ON e.categoryId=c.categoryId
                        WHERE 1 " . $searchQuery);
$stmt->execute($searchArray);
$records = $stmt->fetch();
$totalRecordwithFilter = $records['allcount'];

## Fetch records
$stmt = $conn->prepare("SELECT e.*, s.statusTitle, c.categoryTitle
         FROM event AS e
         JOIN status AS s ON e.statusId=s.statusId
         JOIN category AS c ON e.categoryId=c.categoryId
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
        "eventId" => $row['eventId'],
        "eventName" => $row['eventName'],
        "image" => $row['image'],
        "capacity" => $row['capacity'],
        "quantityLeft" => $row['quantityLeft'],
        "price" => $row['price'],
        "startDate" => $row['startDate'],
        "endDate" => $row['endDate'],
        "categoryTitle" => $row['categoryTitle'],
        "statusTitle" => $row['statusTitle']
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
