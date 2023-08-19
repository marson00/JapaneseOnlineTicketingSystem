<?php
require_once '../../config/connection.php';
require_once '../../config/common_functions.php';
require_once '../../dataEncryption/decryption.php';

$conn = connection::getInstance()->getCon();

if (isset($_GET['userId'])) {
    //Decryption
    $decryption = new decryption("userEncryption");
    $userId = $decryption->decrypt($_GET['userId']);
    
    $userData = getUserDataById($conn, $userId);
    $displayRoles = getRoles($conn, $userData['roleId']);
    $displayStatus = getStatus($conn, $userData['statusId']);
}

if (isset($_POST['editUser'])) {
    $userId = $_POST['userId'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $roleId = $_POST['role'];
//    $statusId = $_POST['status'];

    $query = "UPDATE `user` SET `roleId` = :roleId, 
             `username` = :username, 
             `email` = :email, `phone` = :phone 
              WHERE `userId` = :userId";

    try {
        $conn->beginTransaction();

        $stmtDetails = $conn->prepare($query);
        $stmtDetails->bindParam(':roleId', $roleId, PDO::PARAM_INT);
        // $stmtDetails->bindParam(':statusId', $statusId, PDO::PARAM_INT);
        $stmtDetails->bindParam(':username', $username, PDO::PARAM_STR);
        $stmtDetails->bindParam(':email', $email, PDO::PARAM_STR);
        $stmtDetails->bindParam(':phone', $phone, PDO::PARAM_STR);
        $stmtDetails->bindParam(':userId', $userId, PDO::PARAM_INT);

        $stmtDetails->execute();

        $conn->commit();
        header('Location: view_all_users.php?target=User&action=update&success=1');
        exit;
    } catch (PDOException $ex) {
        $conn->rollback();
        echo $ex->getMessage();
        echo $ex->getTraceAsString();
        header('Location: view_all_users.php?target=User&action=update&success=0');
        exit;
    }
}
?>


<!DOCTYPE html>
<html lang="en">
    <head>
<?php include_once '../../config/site_css_links.php'; ?>
        <title>Edit User</title>
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
                                <h1>Edit User</h1>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- Main content (ADD User) -->
                <section class="content">
                    <div class="card card-outline card-primary rounded-0 shadow">
                        <div class="card-header">
                            <h3 class="card-title">Edit User <b class="ml-2">No: <?= $userData['userId'] ?></b></h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <form method="post" enctype="multipart/form-data">
                                <div class="row">

                                    <div class="col-lg-4 col-md-6 col-sm-6 col-xs-10">
                                        <label>Username</label>
                                        <input type="text" id="username" 
                                               name="username" required="required" 
                                               value="<?= $userData['username'] ?>"
                                               class="form-control form-control-sm rounded-0" />
                                    </div>

                                    <div class="col-lg-4 col-md-6 col-sm-6 col-xs-10">
                                        <label>Email</label>
                                        <input type="email" id="email" 
                                               name="email" required="required"
                                               value="<?= $userData['email'] ?>"
                                               class="form-control form-control-sm rounded-0" />
                                    </div>

                                    <div class="col-lg-4 col-md-6 col-sm-6 col-xs-10">
                                        <label>Phone Number</label>
                                        <input type="text" id="phone" 
                                               name="phone" 
                                               value="<?= $userData['phone'] ?>"
                                               class="form-control form-control-sm rounded-0" />
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-2 col-md-6 col-sm-6 col-xs-10">
                                        <label>Role</label>
                                        <select id="role" name="role" class="form-control form-control-sm rounded-0" required="required">
<?= $displayRoles; ?>
                                        </select>
                                    </div>

                                    <!--                                    <div class="col-lg-2 col-md-6 col-sm-6 col-xs-10">
                                                                            <label>Status</label>
                                                                            <select id="status" name="status" class="form-control form-control-sm rounded-0" required="required">
<?= $displayStatus; ?>
                                                                            </select>
                                                                        </div>-->


                                </div>

                                <div class="clearfix">&nbsp;</div>
                                <div class="row">
                                    <div class="col-lg-11 col-md-11 col-sm-11 col-xs-2">&nbsp;</div>
                                    <div class="col-lg-1 col-md-1 col-sm-1 col-xs-2">
                                        <button type="submit" id="editUser" 
                                                name="editUser" class="btn btn-primary btn-sm btn-flat btn-block">Save</button>
                                    </div>
                                </div>

                                <!--Hidden Input-->
                                <input type="hidden" name="userId" value="<?= $userData['userId'] ?>"/>
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
        <!-- JavaScript -->

    </body>
</html>