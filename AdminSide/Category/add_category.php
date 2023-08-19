<?php
require_once '../../config/connection.php';

$conn = connection::getInstance()->getCon();

if (isset($_POST['addCategory'])) {
    $categoryTitle = $_POST['categoryTitle'];

    $query = "INSERT INTO `category` (`categoryTitle`)
              VALUES (:categoryTitle);";

    try {
        $conn->beginTransaction();
        $stmtDetails = $conn->prepare($query);
        $stmtDetails->bindParam(':categoryTitle', $categoryTitle, PDO::PARAM_STR);
        $stmtDetails->execute();

        $conn->commit();
        header('Location: view_all_categories.php?target=Category&action=add&success=1');
        exit;
    } catch (PDOException $ex) {
        header('Location: view_all_categories.php?target=Category&action=add&success=0');
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <?php include_once '../../config/site_css_links.php'; ?>
        <title>Add Category</title>
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
                                <h1>Add Category</h1>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- Main content (ADD User) -->
                <section class="content">
                    <div class="card card-outline card-primary rounded-0 shadow">
                        <div class="card-header">
                            <h3 class="card-title">Add Category</h3>
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
                                        <label>Category title</label>
                                        <input type="text" id="categoryTitle" name="categoryTitle" required="required"
                                               class="form-control form-control-sm rounded-0"/>
                                        <span id="categoryTitleFeedback"></span>
                                    </div>

                                    <div class="col-lg-1 col-md-2 col-sm-2 col-xs-2">
                                        <label>&nbsp;</label>
                                        <button type="submit" id="addCategory" 
                                                name="addCategory" class="btn btn-primary btn-sm btn-flat btn-block">Add</button>
                                    </div>
                                </div>
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
        <script src="../../validation/categoryValidation.js" type="text/javascript" ></script>
        <script src="checkCategoryExist.js" type="text/javascript"></script>
        <script>
            $(function () {
                showMenuSelected("#categories", "#add_category");
            });
            
        </script>
        <!-- JavaScript -->

    </body>
</html>