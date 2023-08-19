<?php

include('../../dataEncryption/encryption.php');

$encryption = new encryption("userEncryption");

if (isset($_POST['userId'])) {
    $userId = $_POST['userId'];
    $encryptedUserId = $encryption->encrypt($userId);
    echo json_encode(array('encryptedUserId' => $encryptedUserId));
}

