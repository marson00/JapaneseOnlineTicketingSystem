<?php
require_once '../../config/connection.php';

$conn = connection::getInstance()->getCon();
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <?php include_once '../../config/site_css_links.php'; ?>
        <title>Report</title>
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
                                <h1>Report</h1>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- Main content (ADD User) -->
                <section class="content">
                    <div class="card card-outline card-primary rounded-0 shadow">
                        <div class="card-header">
                            <h3 class="card-title">Generate Report</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <form id="reportForm" method="post" enctype="multipart/form-data">
                                <div class="row">
                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-10">
                                        <label for="report">Select report type</label>
                                        <select id="reportType" name="reportType" class="form-control form-control-sm rounded-0">
                                            <option value="1" selected="">Sales Report</option>
                                            <option value="2">Potential User Report</option>
                                            <option value="3">Popular Category Report</option>
                                        </select>
                                    </div>

                                    <div class="col-lg-1 col-md-2 col-sm-2 col-xs-2">
                                        <label>&nbsp;</label>
                                        <a  id="generate"  class="btn btn-primary btn-sm btn-flat btn-block">
                                            Generate
                                        </a>
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
        <script src="../../validation/roleValidation.js" type="text/javascript"></script>
        <script src="checkRoleExist.js" type="text/javascript"></script>
        <script>
            $(function () {
                showMenuSelected("#report");
            });

            $('#generate').on('click', function () {
                // prevent the form from submitting normally

                var button = document.getElementById("generate");

                // Change the text to a spinner
                button.innerHTML = '<span class="spinner-border spinner-border-sm mr-1" role="status" aria-hidden="true"></span>Loading...';

                // Disable the button so it can't be clicked again
                button.disabled = true;

                // get the selected report value
                var selectedReport = $('#reportType').val();

                // make an AJAX request to the PHP file
                $.ajax({
                    url: '/JapaneseOnlineTicketingSystem/xmlGenerators/generate_report_xml.php',
                    type: 'POST',
                    data: {report: selectedReport},
                    success: function (response) {
                        // generate the report dynamically based on the response
//                        alert(response);
                        $('#generate').attr('href', '/JapaneseOnlineTicketingSystem/xmlGenerators/' + response);
                    },
                    error: function (xhr, status, error) {
                        // handle the error
                        console.log(error);
                    }
                });
            });

        </script>

        <!-- JavaScript -->

    </body>
</html>