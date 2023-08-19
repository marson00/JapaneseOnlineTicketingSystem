<?php

include('../../dataEncryption/encryption.php');

$encryption = new encryption("eventEncryption");

if (isset($_POST['eventId'])) {
    $eventId = $_POST['eventId'];
    $encryptedEventId = $encryption->encrypt($eventId);
    echo json_encode(array('encryptedEventId' => $encryptedEventId));
}

