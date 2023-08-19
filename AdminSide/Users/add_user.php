<?php
require_once '../../config/connection.php';
require_once '../../config/common_functions.php';

$conn = connection::getInstance()->getCon();

$displayRoles = getRoles($conn, 0);

if (isset($_POST['addUser'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $password = $_POST['password'];
//    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $confirmPassword = $_POST['confirmPassword'];
    $roleId = $_POST['role'];
    $createdBy = $_POST['hiddenUsername'];

    $query = "INSERT INTO user (roleId, statusId, username, password, email, phone, createdBy, creationDate) VALUES 
                (:roleId, 1, :username, PASSWORD(:password), :email, :phone, :createdBy, NOW());";

    try {
        $conn->beginTransaction();
        $stmtDetails = $conn->prepare($query);

        // bind the parameter values
        $stmtDetails->bindParam(':roleId', $roleId, PDO::PARAM_INT);
        $stmtDetails->bindParam(':username', $username, PDO::PARAM_STR);
//            $stmtDetails->bindParam(':password', $hashed_password, PDO::PARAM_STR);
        $stmtDetails->bindParam(':password', $password, PDO::PARAM_STR);
        $stmtDetails->bindParam(':email', $email, PDO::PARAM_STR);
        $stmtDetails->bindParam(':phone', $phone, PDO::PARAM_STR);
        $stmtDetails->bindParam(':createdBy', $createdBy, PDO::PARAM_STR);

        // execute the statement
        $stmtDetails->execute();

        $conn->commit();
        header('Location: view_all_users.php?target=User&action=add&success=1');
        exit;
    } catch (PDOException $ex) {
        $conn->rollback();

        echo $ex->getMessage();
        echo $ex->getTraceAsString();
//        header('Location: view_all_users.php?target=User&action=add&success=0');
        exit;
    }
}
?>


<!DOCTYPE html>
<html lang="en">
    <head>
        <?php include_once '../../config/site_css_links.php'; ?>
        <title>Add User</title>
    </head>
    <body class="hold-transition sidebar-mini dark-mode layout-fixed layout-navbar-fixed">
        <!-- Page Wrapper Start -->
        <div class="wrapper">

            <!-- Top & Navbar -->
            <?php
            include_once '../adapter/header.php';
            include_once '../adapter/sidebar.php';
            ?>  

            <!-- Content Wrapper Start -->
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <div class="container-fluid">
                        <div class="row mb-2">
                            <div class="col-sm-6">
                                <h1>Add User</h1>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- Main content (ADD User) -->
                <section class="content">
                    <div class="card card-outline card-primary rounded-0 shadow">
                        <div class="card-header">
                            <h3 class="card-title">Add User</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <form method="post" enctype="multipart/form-data"">
                                <div class="row">
                                    <div class="col-lg-4 col-md-6 col-sm-6 col-xs-10">
                                        <label for="username">User name</label>
                                        <input type="text" id="username" name="username" class="form-control form-control-sm rounded-0" required>
                                        <span id="usernameFeedback"></span>
                                    </div>


                                    <div class="col-lg-4 col-md-6 col-sm-6 col-xs-10">
                                        <label>Email address</label>
                                        <input type="email" id="email" name="email" class="form-control form-control-sm rounded-0" required>
                                        <span id="emailFeedback"></span>
                                    </div>


                                    <div class="col-lg-4 col-md-6 col-sm-6 col-xs-10">
                                        <label>Phone Number</label>
                                        <input type="text" id="phone" name="phone" class="form-control form-control-sm rounded-0" required/>
                                        <span id="phoneFeedback"></span>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-5 col-md-6 col-sm-6 col-xs-10">
                                        <label>Password</label>
                                        <input type="password" id="password" name="password" class="form-control form-control-sm rounded-0"/>
                                        <span id="passwordFeedback"> </span>
                                    </div>

                                    <div class="col-lg-5 col-md-6 col-sm-6 col-xs-10">
                                        <label>Confirmed Password</label>
                                        <input type="password" id="confirmPassword" name="confirmPassword"class="form-control form-control-sm rounded-0"/>
                                        <span id="confirmPasswordFeedback"> </span>
                                    </div>

                                    <div class="col-lg-2 col-md-6 col-sm-6 col-xs-10">
                                        <label>Role</label>
                                        <select id="role" name="role" class="form-control form-control-sm rounded-0">
                                            <?php echo $displayRoles; ?>
                                        </select>
                                        <span id="roleFeedback"></span>
                                    </div>
                                </div>

                                <div class="clearfix">&nbsp;</div>
                                <div class="row">
                                    <div class="col-lg-11 col-md-11 col-sm-11 col-xs-2">&nbsp;</div>
                                    <div class="col-lg-1 col-md-1 col-sm-1 col-xs-2">
                                        <button type="submit" id="addUser" 
                                                name="addUser" class="btn btn-primary btn-sm btn-flat btn-block" disabled>Add</button>
                                    </div>
                                </div>

                                <!-- Hidden -->
                                <input type="hidden" name="hiddenUsername" value="<?= $usernameSession ?>"/>
                            </form>
                        </div>

                    </div>
                </section>
                <!-- Main content (ADD User) -->

            </div>
            <!-- Content Wrapper End -->

            <!-- Footer -->
            <?php include_once '../adapter/footer.php'; ?>  

        </div>
        <!-- Page Wrapper End -->

        <!-- JavaScript -->
        <?php include_once '../../config/site_js_links.php'; ?>
        <script src="../../validation/validation.js" type="text/javascript"></script>
        <script src="checkUserExist.js" type="text/javascript"></script>
        <script>
            $(function () {
                showMenuSelected("#users", "#add_users");
            });
        </script>
        <!-- JavaScript -->

    </body>
</html>