<?php
include '../../config/connection.php';
include '../../config/common_functions.php';
include '../../dataEncryption/decryption.php';

$conn = connection::getInstance()->getCon();

if (isset($_GET['roleId'])) {
    //Decryption
    $decryption = new decryption("roleEncryption");
    $roleId = $decryption->decrypt($_GET['roleId']);
    $roleTitle = getRoleTitle($conn, $roleId);
}

if (isset($_POST['editRole'])) {
    $roleId = $_POST['roleId'];
    $roleTitle = $_POST['roleTitle'];

    $query = "UPDATE `role` SET `roleTitle` = :roleTitle 
              WHERE `roleId` = :roleId;";

    try {
        $conn->beginTransaction();

        $stmtDetails = $conn->prepare($query);
        $stmtDetails->bindParam(':roleTitle', $roleTitle, PDO::PARAM_STR);
        $stmtDetails->bindParam(':roleId', $roleId, PDO::PARAM_INT);
        $stmtDetails->execute();

        $conn->commit();
        header('Location: view_all_roles.php?target=Role&action=update&success=1');
        exit;
    } catch (PDOException $ex) {
        header('Location: view_all_roles.php?target=Role&action=update&success=0');
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <?php include_once '../../config/site_css_links.php'; ?>
        <title>Edit Role</title>
    </head>

    <body class="hold-transition sidebar-mini dark-mode layout-fixed layout-navbar-fixed">
        <!-- Site wrapper -->
        <div class="wrapper">
            <!-- Navbar -->
            <?php 
            include_once '../adapter/header.php';
            include_once '../adapter/sidebar.php';
            ?>  
            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <div class="container-fluid">
                        <div class="row mb-2">
                            <div class="col-sm-6">
                                <h1>Edit Role</h1>
                            </div>
                        </div>
                    </div><!-- /.container-fluid -->
                </section>

                <!-- Main content -->
                <section class="content">

                    <!-- Default box -->
                    <div class="card card-outline card-primary rounded-0 shadow">
                        <div class="card-header">
                            <h3 class="card-title">Edit Role</h3>

                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                    <i class="fas fa-minus"></i>
                                </button>

                            </div>
                        </div>
                        <div class="card-body">
                            <form method="post" enctype="multipart/form-data">
                                <div class="row">
                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-10">
                                        <label>Status Title</label>
                                        <input type="text" 
                                               id="roleTitle" name="roleTitle" 
                                               required="roleTitle"
                                               placeholder="<?=$roleTitle?>"
                                               class="form-control form-control-sm rounded-0" />
                                    </div>

                                    <div class="col-lg-1 col-md-2 col-sm-2 col-xs-2">
                                        <label>&nbsp;</label>
                                        <button type="submit" id="editRole" 
                                                name="editRole" class="btn btn-primary btn-sm btn-flat btn-block">Save</button>
                                    </div>
                                </div>
                                
                                <!--Hidden Input-->
                                <input type="hidden" name="roleId" value="<?= $roleId ?>"/>
                            </form>
                        </div>

                    </div>

                </section>
                <br/>
                <br/>
                <br/>


                <!-- /.content -->
            </div>
            <!-- /.content-wrapper -->
            <?php include_once '../adapter/footer.php';?>  
            <!-- /.control-sidebar -->
        </div>
        <!-- ./wrapper -->

        <!-- include the js files here -->
        <?php include_once '../../config/site_js_links.php'; ?>
    </body>
</html>