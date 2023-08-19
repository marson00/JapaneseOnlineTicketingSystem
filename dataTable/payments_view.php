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
    $searchQuery = " AND (p.paymentId LIKE :paymentId) 
                OR (p.paymentDate LIKE :paymentDate)
                OR (c.cardNum LIKE :cardNum)
                OR (u.username LIKE :username) ";
    $searchArray = array(
        'paymentId' => "%$searchValue%",
        'paymentDate' => "%$searchValue%",
        'cardNum' => "%$searchValue%",
        'username' => "%$searchValue%"
    );
}

## Total number of records without filtering
$stmt = $conn->prepare("SELECT COUNT(*) AS allcount FROM payment AS p");
$stmt->execute();
$records = $stmt->fetch();
$totalRecords = $records['allcount'];

## Total number of records with filtering
$stmt = $conn->prepare("SELECT COUNT(*) AS allcount 
                        FROM payment AS p 
                        JOIN card AS c ON p.cardId=c.cardId
                        JOIN `order` AS o ON p.orderId=o.orderId
                        JOIN user AS u ON o.custId=u.userId
                        WHERE 1 " . $searchQuery);
$stmt->execute($searchArray);
$records = $stmt->fetch();
$totalRecordwithFilter = $records['allcount'];

## Fetch records
$stmt = $conn->prepare("SELECT p.paymentId, p.paymentDate, c.cardNum, u.username
                        FROM payment AS p 
                        JOIN card AS c ON p.cardId=c.cardId
                        JOIN `order` AS o ON p.orderId=o.orderId
                        JOIN user AS u ON o.custId=u.userId
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
        "paymentId" => $row['paymentId'],
        "paymentDate" => $row['paymentDate'],
        "paymentUser" => $row['username'],
        "paymentCardNum" => $row['cardNum']
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
