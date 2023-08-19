<?php
require_once '../../config/common_functions.php';
require_once '../../config/connection.php';

$conn = connection::getInstance()->getCon();
$eventNum = getNumEvent($conn);
$userNum = getNumUser($conn);
$ticketNum = getNumTicket($conn);
$orderNum = getNumOrder($conn);

$custNum = getNumCust($conn);
$ticketSoldNum = getNumTicketSold($conn);
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <?php include '../../config/site_css_links.php'; ?>
        <title>Dashboard</title>

        <style>
            .dark-mode .bg-fuchsia, .dark-mode .bg-maroon {
                color: #fff!important;
            }
        </style>
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
                                <h1>Dashboard</h1>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- Main content -->
                <section class="content">
                    <div class="container-fluid">
                        <!-- Small boxes (Stat box) -->
                        <div class="row">
                            <div class="col-lg-3 col-6">
                                <!-- small box -->
                                <div class="small-box bg-info">
                                    <div class="inner">
                                        <h3> <?= $userNum ?> </h3>

                                        <p> Total Users </p>
                                    </div>
                                    <div class="icon">
                                        <i class="fa fa-user-circle"></i>
                                    </div>

                                </div>
                            </div>
                            <!-- ./col -->
                            <div class="col-lg-3 col-6">
                                <!-- small box -->
                                <div class="small-box bg-purple">
                                    <div class="inner">
                                        <h3> <?= $eventNum ?> </h3>

                                        <p>Total Event</p>
                                    </div>
                                    <div class="icon">
                                        <i class="fa fa-calendar-week"></i>
                                    </div>

                                </div>
                            </div>
                            <!-- ./col -->
                            <div class="col-lg-3 col-6">
                                <!-- small box -->
                                <div class="small-box bg-fuchsia text-reset">
                                    <div class="inner">
                                        <h3> <?= $ticketNum ?> </h3>

                                        <p>Total Event Number</p>
                                    </div>
                                    <div class="icon">
                                        <i class="fa fa-ticket"></i>
                                    </div>

                                </div>
                            </div>
                            <!-- ./col -->
                            <div class="col-lg-3 col-6">
                                <!-- small box -->
                                <div class="small-box bg-maroon text-reset">
                                    <div class="inner">
                                        <h3> <?= $orderNum ?> </h3>

                                        <p>Total order</p>
                                    </div>
                                    <div class="icon">
                                        <i class="fa fa-bag-shopping"></i>
                                    </div>

                                </div>
                            </div>
                            <!-- ./col -->
                            <div class="col-lg-3 col-6">
                                <!-- small box -->
                                <div class="small-box bg-info text-reset">
                                    <div class="inner">
                                        <h3> <?= $custNum ?> </h3>

                                        <p>Customers</p>
                                    </div>
                                    <div class="icon">
                                        <i class="fa fa-user-tie"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-6"></div>
                            <div class="col-lg-3 col-6">
                                <!-- small box -->
                                <div class="small-box bg-fuchsia text-reset">
                                    <div class="inner">
                                        <h3> <?= $ticketSoldNum ?> </h3>

                                        <p>Tickets Sold</p>
                                    </div>
                                    <div class="icon">
                                        <i class="fa fa-ticket-alt"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                </section>
                <!-- Content End -->
            </div>
            <!-- Content Wrapper End -->

            <!-- Footer -->
            <?php include '../adapter/footer.php'; ?>  

        </div>
        <!-- Page Wrapper End -->

        <!-- JavaScript -->
        <?php include '../../config/site_js_links.php'; ?>
        <script>
            $(function () {
                showMenuSelected("#dashboard", "");
            })
        </script>
        <!-- JavaScript -->

    </body>
</html>
