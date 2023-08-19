<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Display Events</title>
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
                                <h1>All Events</h1>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- Main content (Display User) -->
                <section class="content">
                    <div class="card card-outline card-primary rounded-0 shadow">
                        <div class="card-header">
                            <h3 class="card-title">All Events</h3>

                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                    <i class="fas fa-minus"></i>
                                </button>

                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row table-responsive">

                                <table id="eventsTable" 
                                       class="table table-striped dataTable table-bordered dtr-inline text-center" 
                                       role="grid" aria-describedby="all_events_info">
                                    <colgroup>
                                        <col width="5%">
                                        <col width="10%">
                                        <col width="5%">
                                        <col width="5%">
                                        <col width="5%">
                                        <col width="5%">
                                        <col width="10%">
                                        <col width="5%">
                                        <col width="5%">
                                        <col width="10%">
                                    </colgroup>
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Event Name</th>
                                            <th>Image</th>
                                            <th>Capacity</th>
                                            <th>Ticket Left</th>
                                            <th>Price</th>
                                            <th>Event Date</th>
                                            <th>Category</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>                                    
                                    <tfoot>
                                        <tr>
                                            <td class="text-right" colspan="10">
                                                <div class="d-flex justify-content-between">
                                                    <div>
                                                        <a  id="csv" class="btn btn-primary btn-sm btn-flat mb-1">
                                                            <span class="mr-2">CSV</span>
                                                        </a>
                                                        <a id="pdf" class="btn btn-primary btn-sm btn-flat mb-1 ml-2">
                                                            <span class="mr-2">PDF</span>
                                                        </a>
                                                    </div>
                                                    <div>
                                                        <a href="/JapaneseOnlineTicketingSystem/AdminSide/Event/add_event.php" class="btn btn-primary btn-sm btn-flat" >
                                                            <span class="mr-2">Add Event</span><i class="fa fa-plus"></i>
                                                        </a>
                                                    </div>
                                                </div>
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
        <script src="../../dataTable/view_event_jquery.js" type="text/javascript"></script>
        <script src="../../config/msgHandler.js" type="text/javascript"></script>
        <script>
            $(function () {
                showMenuSelected("#events", "#view_events");
            })
        </script>
        <!-- JavaScript -->

    </body>
</html>