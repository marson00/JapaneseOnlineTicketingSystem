<?php
include './../../config/connection.php';
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <?php include '../../config/site_css_links.php'; ?>
        <?php include '../../config/data_tables_css.php'; ?>
        <link rel="stylesheet" href="plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
        <title>Update ticket</title>
    </head>

    <body class="hold-transition sidebar-mini dark-mode layout-fixed layout-navbar-fixed">
        <!-- Site wrapper -->
        <div class="wrapper">
            <!-- Navbar -->
            <?php
            include '../adapter/header.php';
            include '../adapter/sidebar.php';
            ?>  
            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <div class="container-fluid">
                        <div class="row mb-2">
                            <div class="col-sm-6">
                                <h1>Update ticket</h1>
                            </div>
                        </div>
                    </div><!-- /.container-fluid -->
                </section>

                <!-- Main content -->
                <section class="content">

                    <!-- Default box -->
                    <div class="card card-outline card-primary rounded-0 shadow">
                        <div class="card-header">
                            <h3 class="card-title">Update ticket</h3>

                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                    <i class="fas fa-minus"></i>
                                </button>

                            </div>
                        </div>
                        <div class="card-body">
                            <form method="post">
                                <input type="hidden" name="hidden_id" 
                                       value="">
                                <div class="row">
                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-10">&nbsp;</div>
                                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-10">
                                            <label class="text-center">Ticket Code</label>
                                            <input type="text" id="ticket_code" name="ticket_code" required="required"
                                                   class="form-control form-control-sm rounded-0" value="" />
                                        </div>
                                </div>

                                <div class="clearfix">&nbsp;</div>
                                <div class="row">
                                    <div class="col-lg-11 col-md-10 col-sm-10">&nbsp;</div>
                                    <div class="col-lg-1 col-md-2 col-sm-2 col-xs-2">
                                        <button type="submit" id="update_ticket" 
                                                name="update_ticket" class="btn btn-primary btn-sm btn-flat btn-block">Update</button>
                                    </div>
                                </div>
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
            <?php
            include '../adapter/footer.php';

            /*
              $message = '';
              if (isset($_GET['message'])) {
              $message = $_GET['message'];
              }
             */
            ?>  
            <!-- /.control-sidebar -->
        </div>
        <!-- ./wrapper -->

        <!-- include the js files here -->
        <?php include '../../config/site_js_links.php'; ?>
        <?php include '../../config/data_tables_js.php'; ?>



    </body>
</html>