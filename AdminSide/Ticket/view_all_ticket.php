<!DOCTYPE html>
<html lang="en">
    <head>
        <?php include '../../config/site_css_links.php'; ?>
        <title>Display Tickets</title>
        <link href="../datatable.css" rel="stylesheet" type="text/css"/>
    </head>
    <body class="hold-transition sidebar-mini dark-mode layout-fixed layout-navbar-fixed">
        <!-- Page Wrapper Start -->
        <div class="wrapper">

            <!-- Top & Navbar -->
            <?php
            include '../adapter/header.php';
            include '../adapter/sidebar.php';
            ?>  

            <!-- Content Wrapper Start -->
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <div class="container-fluid">
                        <div class="row mb-2">
                            <div class="col-sm-6">
                                <h1>All Ticket</h1>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- Main content (Display User) -->
                <section class="content">
                    <div class="card card-outline card-primary rounded-0 shadow">
                        <div class="card-header">
                            <h3 class="card-title">All Ticket</h3>

                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                    <i class="fas fa-minus"></i>
                                </button>

                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row table-responsive">

                                <table id="ticketsTable" 
                                       class="table table-striped dataTable table-bordered dtr-inline text-center" 
                                       role="grid" aria-describedby="all_tickets_info">
                                    <colgroup>
                                        <col width="10%">
                                        <col width="30%">
                                        <col width="20%">
                                        <col width="20%">
                                        <col width="20%">
                                    </colgroup>
                                    <thead>
                                        <tr>
                                            <th>Ticket ID</th>
                                            <th>Ticket Code</th>
                                            <th>Event Name</th>
                                            <th>Status</th>
                                            <th>Holder/Buyer</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <td colspan="5" class="text-left">
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
            <?php include '../adapter/footer.php'; ?>  

        </div>
        <!-- Page Wrapper End -->

        <!-- JavaScript -->
        <?php include '../../config/site_js_links.php'; ?>
        <script src="../../dataTable/view_tickets_jquery.js" type="text/javascript"></script>
        <script>
            $(function () {
                showMenuSelected("#tickets", "#view_all_ticket");
            })
        </script>
        <!-- JavaScript -->

    </body>
</html>