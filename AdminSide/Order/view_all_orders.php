<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Display Orders</title>
        <?php include_once '../../config/site_css_links.php'; ?>
        <link href="../datatable.css" rel="stylesheet" type="text/css"/>
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
                                <h1>All Orders</h1>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- Main content (Display User) -->
                <section class="content">
                    <div class="card card-outline card-primary rounded-0 shadow">
                        <div class="card-header">
                            <h3 class="card-title">All Orders</h3>

                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                    <i class="fas fa-minus"></i>
                                </button>

                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row table-responsive">

                                <table id="ordersTable" 
                                       class="table table-striped dataTable table-bordered dtr-inline text-center" 
                                       role="grid" aria-describedby="all_orders_info">
                                    
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Event</th>
                                            <th>Quantity</th>
                                            <th>Total Price</th>
                                            <th>Ordered By</th>
                                            <th>Order date</th>
                                            <th>Pay with</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <td colspan="7" class="text-left">
                                                <a  id="csv" class="btn btn-primary btn-sm btn-flat mb-1">
                                                    <span class="mr-2">CSV</span>
                                                </a>
                                                <a id="pdf" class="btn btn-primary btn-sm btn-flat mb-1 ml-2">
                                                    <span class="mr-2">PDF</span>
                                                </a>
                                            </td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </section>
                <!-- Main content (Display User) -->
            </div>
            <!-- Content Wrapper End -->

            <!-- Footer -->
            <?php include_once '../adapter/footer.php'; ?>  

        </div>
        <!-- Page Wrapper End -->

        <!-- JavaScript -->
        <?php include_once '../../config/site_js_links.php'; ?>
        <script src="../../dataTable/view_orders_jquery.js" type="text/javascript"></script>
        <script>
            $(function () {
                showMenuSelected("#orders", "#view_all_order");
            })
        </script>
        <!-- JavaScript -->

    </body>
</html>