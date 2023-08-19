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
    $searchQuery = " AND (cardId LIKE :cardId) 
            OR (holderName LIKE :holderName) 
            OR (cardNum LIKE :cardNum) 
            OR (expMonth LIKE :expMonth) 
            OR (expYear LIKE :expYear)
            OR (cvv LIKE :cvv) 
            OR (cardType LIKE :cardType)";
    $searchArray = array(
        'cardId' => "%$searchValue%",
        'holderName' => "%$searchValue%",
        'cardNum' => "%$searchValue%",
        'expMonth' => "%$searchValue%",
        'expYear' => "%$searchValue%",
        'cvv' => "%$searchValue%",
        'cardType' => "%$searchValue%"
    );
}

## Total number of records without filtering
$stmt = $conn->prepare("SELECT COUNT(*) AS allcount FROM card ");
$stmt->execute();
$records = $stmt->fetch();
$totalRecords = $records['allcount'];

## Total number of records with filtering
$stmt = $conn->prepare("SELECT COUNT(*) AS allcount FROM card WHERE 1 " . $searchQuery);
$stmt->execute($searchArray);
$records = $stmt->fetch();
$totalRecordwithFilter = $records['allcount'];

## Fetch records
$stmt = $conn->prepare("SELECT * FROM card WHERE 1 " . $searchQuery . " ORDER BY " . $columnName . " " . $columnSortOrder . " LIMIT :limit,:offset");

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
        "cardId" => $row['cardId'],
        "holderName" => $row['holderName'],
        "cardNum" => $row['cardNum'],
        "expMonth" => $row['expMonth'],
        "expYear" => $row['expYear'],
        "cvv" => $row['cvv'],
        "cardType" => $row['cardType']
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
