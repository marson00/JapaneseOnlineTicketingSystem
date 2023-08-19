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
    $searchQuery = " AND (u.userId LIKE :userId) 
                OR (u.username LIKE :username) 
                OR (u.email LIKE :email) 
                OR (u.phone LIKE :phone) 
                OR (s.statusTitle LIKE :statusTitle) 
                OR (r.roleTitle LIKE :roleTitle)";
    $searchArray = array(
        'userId' => "%$searchValue%",
        'username' => "%$searchValue%",
        'email' => "%$searchValue%",
        'phone' => "%$searchValue%",
        'statusTitle' => "%$searchValue%",
        'roleTitle' => "%$searchValue%"
    );
}

## Total number of records without filtering
$stmt = $conn->prepare("SELECT COUNT(*) AS allcount FROM user AS u");
$stmt->execute();
$records = $stmt->fetch();
$totalRecords = $records['allcount'];

## Total number of records with filtering
$stmt = $conn->prepare("SELECT COUNT(*) AS allcount FROM user AS u 
                        JOIN role AS r ON u.roleId=r.roleId 
                        JOIN status AS s ON u.statusId=s.statusId 
                        WHERE 1 " . $searchQuery);
$stmt->execute($searchArray);
$records = $stmt->fetch();
$totalRecordwithFilter = $records['allcount'];

## Fetch records
$stmt = $conn->prepare("SELECT u.*, r.roleTitle, s.statusTitle 
                        FROM user AS u 
                        JOIN role AS r ON u.roleId=r.roleId 
                        JOIN status AS s ON u.statusId=s.statusId 
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
        "userId" => $row['userId'],
        "username" => $row['username'],
        "email" => $row['email'],
        "phone" => $row['phone'],
        "statusTitle" => $row['statusTitle'],
        "roleTitle" => $row['roleTitle'],
        "createdBy" => $row['createdBy'],
        "creationDate" => $row['creationDate'],
        "updatedBy" => $row['updatedBy'],
        "updatedDate" => $row['updatedDate']
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
