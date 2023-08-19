<?php

include('../../dataEncryption/encryption.php');

$encryption = new encryption("statusEncryption");

if (isset($_POST['statusId'])) {
    $statusId = $_POST['statusId'];
    $encryptedStatusId = $encryption->encrypt($statusId);
    echo json_encode(array('encryptedStatusId' => $encryptedStatusId));
}

