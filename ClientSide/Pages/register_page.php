<?php
require_once '../../config/connection.php';

$conn = connection::getInstance()->getCon();
$isSuccess = false;
if (isset($_POST['registerBtn'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    $query = "INSERT INTO user (`roleId`, `statusId`, `username`, `password`, `email`, `phone`, `createdBy`, `creationDate`)
              VALUES (2, 1, :username, PASSWORD(:password), :email, '', 'register', NOW())";

    $conn->beginTransaction();
    $stmt = $conn->prepare($query);
    $stmt->bindValue(':username', $username, PDO::PARAM_STR);
    $stmt->bindValue(':email', $email, PDO::PARAM_STR);
    $stmt->bindValue(':password', $password, PDO::PARAM_STR);
    $stmt->execute();
    $conn->commit();
    $isSuccess = true;
//    header('Location: login_page.php');
//    exit;
}
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Register Account Page</title>
        <?php include_once '../../config/client_css_links.php'; ?>
    </head>
    <body>
        <div class="vh-100" style="background-color:#B0C4DE;">
            <div class="container py-5 h-100">
                <div class="row d-flex justify-content-center align-items-center h-100">
                    <div class="col col-xl-10">
                        <div class="card" style="border-radius: 1rem;">
                            <div class="row g-0">
                                <div class="col-md-6 col-lg-5 d-none d-md-block ">
                                    <img src="../Pictures/pic1.png"
                                         alt="register form" class="img-fluid" style="border-radius: 1rem 0 0 1rem;object-fit: cover;height: 100%" />
                                </div>
                                <div class="col-md-6 col-lg-7 d-flex align-items-center">
                                    <div class="card-body p-4 p-lg-4 text-black">
                                        <form method="post" enctype="multipart/form-data" class="ms-4 me-5">
                                            <div class="d-flex align-items-center mb-3 pb-1">
                                                <i class="fas fa-sign-out fa-3x me-4 text-info"></i>
                                                <span class="h1 fw-bold mb-0 text-primary">Register</span>
                                            </div>
                                            <h5 class="fw-normal mb-4" style="letter-spacing: 1px;">Please enter your details to register an account</h5>
                                            <div class="form-outline mb-3" id="emailOutline">
                                                <input type="email" class="form-control form-control-lg mb-0" id="email" name="email" required>
                                                <label for="email" class="form-label">Email address</label>
                                                <span id="emailFeedback" class="fw-bold mt-1"></span>
                                            </div>
                                            <div class="form-outline mb-3" id="usernameOutline">
                                                <input type="text" class="form-control form-control-lg mb-0" id="username" name="username" required>
                                                <label for="username" class="form-label">Username</label>
                                                <span id="usernameFeedback" class="fw-bold mt-1"></span>
                                            </div>
                                            <div class="form-outline mb-3" id="pwdOutline">
                                                <input type="password" class="form-control form-control-lg mb-0" id="password" name="password" required>
                                                <label for="password" class="form-label">Password</label>
                                                <span id="pwdFeedback" class="fw-bold mt-1"></span>
                                            </div>
                                            <div class="form-outline mb-3" id="cpwdOutline">
                                                <input type="password" class="form-control form-control-lg mb-0" id="confirmPassword" required>
                                                <label for="confirmPassword" class="form-label">Confirm Password</label>
                                                <span id="confirmPwdFeedback" class="fw-bold mt-1"></span>
                                            </div>

                                            <div class="pt-1 mt-4 mb-4 ">
                                                <button id="registerBtn" name="registerBtn" class="btn btn-primary btn-rounded btn-lg btn-block" type="submit"><b>Register</b></button>
                                            </div>
                                            <p class="">Already have an account? <a href="login_page.php">Click here to login</a>.</p> 
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
        <script src="../../validation/registerValidation.js" type="text/javascript"></script>
        <script src="checkRegister.js" type="text/javascript"></script>
        <script type="text/javascript">
            function showSuccess() {
                Swal.fire({
                    position: 'center',
                    icon: 'success',
                    title: 'Successfully register account',
                    showConfirmButton: false,
                    timer: 1500
                }).then(() => {
                    setTimeout(() => {
                        window.location.href = 'login_page.php';
                    }, 500); 
                });
            }

<?php
if ($isSuccess) {
    echo 'showSuccess();';
}
?>
        </script>
    </body>
</html>

