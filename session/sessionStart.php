<?php
require_once '../../config/connection.php';
require_once '../../config/common_functions.php';

$conn = connection::getInstance()->getCon();

session_start();

if (isset($_SESSION['isLogin']) && $_SESSION['isLogin']) {
    $userIdSession = $_SESSION['userId'];

    $userDataSession = getUserDataById($conn, $userIdSession);
    $usernameSession = $userDataSession['username'];
    $userphoneSession = $userDataSession['phone'];
    $useremailSession = $userDataSession['email'];
} else {
    header('Location: /JapaneseOnlineTicketingSystem/ClientSide/Pages/login_page.php');
}
?>
