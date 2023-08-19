<?php
include '../../config/connection.php';
include '../../config/common_functions.php';
include '../../dataEncryption/decryption.php';

$conn = connection::getInstance()->getCon();

if (isset($_GET['statusId'])) {
    //Decryption
    $decryption = new decryption("statusEncryption");
    $statusId = $decryption->decrypt($_GET['statusId']);
    $statusTitle = getStatusTitle($conn, $statusId);
}

if (isset($_POST['editStatus'])) {
    $statusId = $_POST['statusId'];
    $statusTitle = $_POST['statusTitle'];

    $query = "UPDATE `status` SET `statusTitle` = :statusTitle 
              WHERE `statusId` = :statusId;";

    try {
        $conn->beginTransaction();

        $stmtDetails = $conn->prepare($query);
        $stmtDetails->bindParam(':statusTitle', $statusTitle, PDO::PARAM_STR);
        $stmtDetails->bindParam(':statusId', $statusId, PDO::PARAM_INT);
        $stmtDetails->execute();

        $conn->commit();
        header('Location: view_all_status.php?target=Status&action=update&success=1');
        exit;
    } catch (PDOException $ex) {
        header('Location: view_all_status.php?target=Status&action=update&success=0');
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <?php include_once '../../config/site_css_links.php'; ?>
        <title>Edit role</title>
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
                                <h1>Edit Status</h1>
                            </div>
                        </div>
                    </div><!-- /.container-fluid -->
                </section>

                <!-- Main content -->
                <section class="content">

                    <!-- Default box -->
                    <div class="card card-outline card-primary rounded-0 shadow">
                        <div class="card-header">
                            <h3 class="card-title">Edit Status</h3>

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
                                               id="statusTitle" name="statusTitle" 
                                               required="required"
                                               placeholder="<?=$statusTitle?>"
                                               class="form-control form-control-sm rounded-0" />
                                    </div>

                                    <div class="col-lg-1 col-md-2 col-sm-2 col-xs-2">
                                        <label>&nbsp;</label>
                                        <button type="submit" id="editStatus" 
                                                name="editStatus" class="btn btn-primary btn-sm btn-flat btn-block">Save</button>
                                    </div>
                                </div>
                                
                                <!--Hidden Input-->
                                <input type="hidden" name="statusId" value="<?= $statusId ?>"/>
                            </form>
                        </div>
                    </div>
                </section>
                <!-- /.content -->
            </div>
            <!-- /.content-wrapper -->

            <?php include_once '../adapter/footer.php'; ?>  
            <!-- /.control-sidebar -->
        </div>
        <!-- ./wrapper -->

        <!-- include the js files here -->
        <?php include_once '../../config/site_js_links.php'; ?>
    </body>
</html>