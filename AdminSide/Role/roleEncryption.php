<?php

include('../../dataEncryption/encryption.php');

$encryption = new encryption("roleEncryption");

if (isset($_POST['roleId'])) {
    $roleId = $_POST['roleId'];
    $encryptedRoleId = $encryption->encrypt($roleId);
    echo json_encode(array('encryptedRoleId' => $encryptedRoleId));
}

