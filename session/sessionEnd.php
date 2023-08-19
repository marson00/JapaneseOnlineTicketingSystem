<?php

session_unset();

// end session
session_destroy();

header('Location: /JapaneseOnlineTicketingSystem/ClientSide/Pages/login_page.php');

?>