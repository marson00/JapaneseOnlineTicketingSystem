<?php
require_once '../../config/connection.php';

$conn = connection::getInstance()->getCon();
$error = false;

session_start();
$_SESSION['isLogin'] = false;

if (isset($_POST['loginBtn'])) {
    $loginInput = $_POST['username'];
    $password = $_POST['password'];
    $statusId = 1;
    $isError = false;

    $query = "SELECT `userId`, `roleId`, `username`, `password`, `email` 
              FROM user 
              WHERE (username = :username OR email = :email)
              AND password = PASSWORD(:password)
              AND statusId = :statusId";

    $stmt = $conn->prepare($query);
    $stmt->bindValue(':username', $loginInput);
    $stmt->bindValue(':email', $loginInput);
    $stmt->bindValue(':password', $password);
    $stmt->bindParam(':statusId', $statusId);
    $stmt->execute();
    $rowCount = $stmt->rowCount();

    if ($rowCount > 0) {
        $userData = $stmt->fetch(PDO::FETCH_ASSOC);

        $roleId = $userData['roleId'];
        $_SESSION['userId'] = $userData['userId'];
        $_SESSION['isLogin'] = true;

        $url = ($roleId == 1 ? 'AdminSide/Dashboard/dashboard.php' : 'ClientSide/Pages/homepage.php');
        header('Location: http://localhost/JapaneseOnlineTicketingSystem/' . $url);
        exit;
    } else {
        $isError = true;
    }
}
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Login Account Page</title>
        <?php include_once '../../config/client_css_links.php'; ?>
    </head>
    <body>
        <div class="vh-100" style="background-color: #9A616D;">
            <div class="container py-5 h-100">
                <div class="row d-flex justify-content-center align-items-center h-100">
                    <div class="col col-xl-10">
                        <div class="card" style="border-radius: 1rem;">
                            <div class="row g-0">
                                <div class="col-md-6 col-lg-5 d-none d-md-block ">
                                    <img src="../Pictures/pic3.png"
                                         alt="register form" class="img-fluid" style="border-radius: 1rem 0 0 1rem; object-fit:cover;height:100%" />
                                </div>

                                <div class="col-md-6 col-lg-7 d-flex align-items-center mt-5 mb-5">
                                    <div class="card-body p-4 p-lg-4 text-black">
                                        <form method="post" enctype="multipart/form-data" class="ms-4 me-5 mb-2 mt-2">
                                            <div class="d-flex align-items-center mb-3 pb-1 m-2">
                                                <i class="fas fa-sign-in fa-3x me-4"style="color: #FA8072   ;"></i>
                                                <span class="h1 fw-bold mb-0 text-danger">Login</span>
                                            </div>
                                            <h5 class="fw-normal mb-4" style="letter-spacing: 1px;">Please enter your details to login</h5>
                                            <div class="form-outline mb-4">
                                                <input type="text" class="form-control form-control-lg" id="username" name="username" required>
                                                <label for="username" class="form-label">Username / Email</label>
                                            </div>
                                            <div class="form-outline mb-4  ">
                                                <input type="password" class="form-control form-control-lg" id="password" name="password" required>
                                                <label for="password" class="form-label">Password</label>
                                            </div>
                                            <div class="pt-1 mt-4 mb-4">
                                                <button class="btn btn-danger btn-lg btn-block btn-rounded" type="submit" id="loginBtn" name="loginBtn"><b>Login</b></button>
                                            </div>
                                            <a class="text-muted" href="forgetpassword.php">Forgot password?</a>
                                            <p class="">Don't have an account? <a href="register_page.php" class="text-decoration-none">Sign up now</a>.</p> 
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- MDB -->
        <?php include_once '../../config/client_js_links.php'; ?>
        <!-- Custom scripts -->
        <script type="text/javascript">
            function showError() {
                Swal.fire({
                    position: 'top',
                    icon: 'error',
                    title: 'Incorrect username or password',
                    showConfirmButton: false,
                    timer: 1500
                });
            }

<?php
if ($isError) {
    echo 'showError();';
}
?>
        </script>

    </body>
</html>

