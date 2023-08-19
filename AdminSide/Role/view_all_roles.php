<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Display Roles</title>
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
                                <h1>All Roles</h1>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- Main content (Display Role) -->
                <section class="content">
                    <div class="card card-outline card-primary rounded-0 shadow">

                        <div class="card-header">
                            <h3 class="card-title">All Roles</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>

                        <div class="card-body">
                            <div class="row table-responsive">

                                <!-- Table -->
                                <table id="rolesTable" 
                                       class="table dataTable table-bordered dtr-inline text-center" 
                                       role="grid" aria-describedby="all_roles_info">
                                    <colgroup>
                                        <col width="10%">
                                        <col width="70%">
                                        <col width="20%">
                                    </colgroup>
                                    <thead>
                                        <tr>
                                            <th class="p-1 text-center">No</th>
                                            <th class="p-1 text-center">Role title</th>
                                            <th class="p-1 text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <td colspan="3">
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
                                                        <a href="/JapaneseOnlineTicketingSystem/AdminSide/Role/add_role.php" class="btn btn-primary btn-sm btn-flat mb-1">
                                                            <span class="mr-2">Add Role</span><i class="fa fa-plus"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    </tfoot>
                                </table>
                                <!-- Table -->
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

        <!-- Script -->
        <?php include_once '../../config/site_js_links.php'; ?>        
        <script src="../../dataTable/view_roles_jquery.js" type="text/javascript"></script>
        <script src="../../config/msgHandler.js" type="text/javascript"></script>
        <script>
            $(function () {
                showMenuSelected("#roles", "#view_roles");
            });
        </script>
        <!-- Script -->

    </body>
</html>