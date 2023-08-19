<?php
include '../../config/connection.php';
include '../../config/common_functions.php';
include '../../dataEncryption/decryption.php';

$conn = connection::getInstance()->getCon();

if (isset($_GET['categoryId'])) {
    //Decryption
    $decryption = new decryption("categoryEncryption");
    $categoryId = $decryption->decrypt($_GET['categoryId']);
    $categoryTitle = getCategoryTitle($conn, $categoryId);
}

if (isset($_POST['editCategory'])) {
    $categoryId = $_POST['categoryId'];
    $categoryTitle = $_POST['categoryTitle'];

    $query = "UPDATE `category` SET `categoryTitle` = :categoryTitle 
              WHERE `categoryId` = :categoryId;";

    try {
        $conn->beginTransaction();

        $stmtDetails = $conn->prepare($query);
        $stmtDetails->bindParam(':categoryTitle', $categoryTitle, PDO::PARAM_STR);
        $stmtDetails->bindParam(':categoryId', $categoryId, PDO::PARAM_INT);
        $stmtDetails->execute();

        $conn->commit();
        header('Location: view_all_categories.php?target=Category&action=update&success=1');
        exit;
    } catch (PDOException $ex) {
        header('Location: view_all_categories.php?target=Category&action=update&success=0');
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <?php include_once '../../config/site_css_links.php'; ?>
        <title>Edit Category</title>
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
                                <h1>Edit Category</h1>
                            </div>
                        </div>
                    </div><!-- /.container-fluid -->
                </section>

                <!-- Main content -->
                <section class="content">

                    <!-- Default box -->
                    <div class="card card-outline card-primary rounded-0 shadow">
                        <div class="card-header">
                            <h3 class="card-title">Edit Category</h3>

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
                                        <label>Category Title</label>
                                        <input type="text" 
                                               id="categoryTitle" name="categoryTitle" 
                                               required="categoryTitle"
                                               placeholder="<?=$categoryTitle?>"
                                               class="form-control form-control-sm rounded-0" />
                                    </div>

                                    <div class="col-lg-1 col-md-2 col-sm-2 col-xs-2">
                                        <label>&nbsp;</label>
                                        <button type="submit" id="editCategory" 
                                                name="editCategory" class="btn btn-primary btn-sm btn-flat btn-block">Save</button>
                                    </div>
                                </div>
                                
                                <!--Hidden Input-->
                                <input type="hidden" name="categoryId" value="<?= $categoryId ?>"/>
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