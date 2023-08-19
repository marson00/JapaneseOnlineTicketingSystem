<?php

require_once './login_abstract.php';

class login extends login_abstract {

    protected function showError() {
        return "<script>
                showError()
                
                function showError() {
                    Swal.fire({
                        position: 'top',
                        icon: 'error',
                        title: 'Incorrect username or password',
                        showConfirmButton: false,
                        timer: 1500
                    });
                }
              </script>";
    }

    protected function handleSuccess($stmt) {
        $userData = $stmt->fetch(PDO::FETCH_ASSOC);

        $roleId = $userData['roleId'];
        $_SESSION['userId'] = $userData['userId'];
        $_SESSION['isLogin'] = true;

        $url = ($roleId == 1 ? 'AdminSide/Dashboard/dashboard.php' : 'ClientSide/Pages/homepage.php');
        header('Location: http://localhost/JapaneseOnlineTicketingSystem/' . $url);
        exit;
    }

}
