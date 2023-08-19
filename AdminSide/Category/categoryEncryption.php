<?php

include('../../dataEncryption/encryption.php');

$encryption = new encryption("categoryEncryption");

if (isset($_POST['categoryId'])) {
    $categoryId = $_POST['categoryId'];
    $encryptedCategoryId = $encryption->encrypt($categoryId);
    echo json_encode(array('encryptedCategoryId' => $encryptedCategoryId));
}

