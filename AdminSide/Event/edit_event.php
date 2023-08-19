<?php
include '../../config/connection.php';
include '../../config/common_functions.php';
include '../../dataEncryption/decryption.php';

$conn = connection::getInstance()->getCon();

if (isset($_GET['eventId'])) {
    //Decryption
    $decryption = new decryption("eventEncryption");
    $eventId = $decryption->decrypt($_GET['eventId']);
    $eventData = getEventDataById($conn, $eventId);
    $displayStatus = getStatus($conn, $eventData['statusId']);
    $displayCategory = getCategories($conn, $eventData['categoryId']);
}


if (isset($_POST['editEvent'])) {
    $eventId = $_POST['eventId'];
    $eventName = $_POST['eventName'];
    $location = $_POST['location'];
    $eventDsc = $_POST['eventDsc'];
    $eventStartDate = $_POST['eventStartDate'];
    $eventEndDate = $_POST['eventEndDate'];
    $price = $_POST['price'];
    $categoryId = $_POST['category'];
    $statusId = $_POST['status'];

    //Get the input file name
    $fileName = isset($_FILES['eventImg']['name']) ? basename($_FILES['eventImg']['name']) : '';
    $targetDir = "../../pictures/";
    $targetFilePath = $targetDir . $fileName;
    $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);
    
    $query = "UPDATE `event` SET `statusId` = :statusId, 
             `categoryId` = :categoryId, `eventName` = :eventName, 
             `location` = :location, `description` = :description,
             `image` = :image, `startDate` = :startDate,
             `endDate` = :endDate, `price` = :price
              WHERE `eventId` = :eventId";

    try {
        move_uploaded_file($_FILES['eventImg']['tmp_name'], $targetFilePath);
        $conn->beginTransaction();

        $stmtDetails = $conn->prepare($query);
        $stmtDetails->bindParam(':statusId', $statusId, PDO::PARAM_INT);
        $stmtDetails->bindParam(':categoryId', $categoryId, PDO::PARAM_INT);
        $stmtDetails->bindParam(':eventName', $eventName, PDO::PARAM_STR);
        $stmtDetails->bindParam(':location', $location, PDO::PARAM_STR);
        $stmtDetails->bindParam(':description', $eventDsc, PDO::PARAM_STR);
        $stmtDetails->bindParam(':image', $fileName, PDO::PARAM_STR);
        $stmtDetails->bindParam(':startDate', $eventStartDate, PDO::PARAM_STR);
        $stmtDetails->bindParam(':endDate', $eventEndDate, PDO::PARAM_STR);
        $stmtDetails->bindParam(':price', $price, PDO::PARAM_INT);
        $stmtDetails->bindParam(':eventId', $eventId, PDO::PARAM_STR);

        $stmtDetails->execute();

        $conn->commit();
        header('Location: view_all_events.php?target=Event&action=update&success=1');
        exit;
    } catch (PDOException $ex) {
        $conn->rollback();
        echo $ex->getMessage();
        echo $ex->getTraceAsString();
        header('Location: view_all_events.php?target=Event&action=update&success=0');
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <?php include_once '../../config/site_css_links.php'; ?>
        <title>Edit event</title>
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
                                <h1>Update event</h1>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- Main content (ADD User) -->
                <section class="content">
                    <div class="card card-outline card-primary rounded-0 shadow">
                        <div class="card-header">
                            <h3 class="card-title">Edit event <b class="ml-2">No: <?= $eventData['eventId'] ?></b></h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <form method="post" enctype="multipart/form-data">
                                <div class="row">

                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-10">
                                        <label>Event Name</label>
                                        <input type="text" id="eventName" name="eventName" required="required"
                                               value="<?= $eventData['eventName'] ?>"
                                               class="form-control form-control-sm rounded-0" />
                                        <span id="eventNameFeedback"></span>
                                    </div>

                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-10">
                                        <label>Location</label>
                                        <input type="text" id="location" name="location" required="required"
                                               value="<?= $eventData['location'] ?>"
                                               class="form-control form-control-sm rounded-0" />
                                        <span id="locationFeedback"></span>
                                    </div>

                                    <div class="col-lg-3 col-md-6 col-sm-6 col-xs-10">
                                        <label>Event Picture</label>
                                        <input type="file" id="eventImg" name="eventImg" required="required"
                                               class="form-control form-control-sm rounded-0" />
                                        <span id="eventImgFeedback"></span>
                                    </div>

                                    <div class="col-lg-7 col-md-6 col-sm-6 col-xs-10">
                                        <label>Description</label>
                                        <input type="text" id="eventDsc" name="eventDsc" required="required"
                                               value="<?= $eventData['description'] ?>"
                                               class="form-control form-control-sm rounded-0" />
                                        <span id="eventDscFeedback"></span>
                                    </div>

                                    <div class="col-lg-2 col-md-4 col-sm-4 col-xs-10">
                                        <label>Category</label>
                                        <select id="category" name="category" class="form-control form-control-sm rounded-0" required>
                                            <?php
                                            echo $displayCategory;
                                            ?>
                                        </select>
                                        <span id="categoryFeedback"></span>
                                    </div>

                                    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-10">
                                        <label>Event Start-Date</label>
                                        <div class="input-group date"  id="eventStartDateGroup" data-target-input="nearest">
                                            <input type="text" id="eventStartDate" 
                                                   class="form-control form-control-sm rounded-0 datetimepicker-input" 
                                                   data-target="#eventStartDate" name="eventStartDate" 
                                                   value="<?= $eventData['startDate'] ?>"/>
                                            <div class="input-group-append" 
                                                 data-target="#eventStartDate" 
                                                 data-toggle="datetimepicker">
                                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                            </div>
                                            <span id="eventStartDateFeedback"></span>
                                        </div>
                                    </div>

                                    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-10">
                                        <label>Event End-Date</label>
                                        <div class="input-group date" id="eventEndDateGroup" data-target-input="nearest">
                                            <input type="text" id="eventEndDate" 
                                                   class="form-control form-control-sm rounded-0 datetimepicker-input" 
                                                   data-target="#eventEndDate" name="eventEndDate" 
                                                   value="<?= $eventData['endDate'] ?>"/>
                                            <div class="input-group-append" 
                                                 data-target="#eventEndDate" 
                                                 data-toggle="datetimepicker">
                                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                            </div>
                                            <span id="eventEndDateFeedback"></span>
                                        </div>
                                    </div>

                                    <!--                                    <div class="col-lg-2 col-md-4 col-sm-4 col-xs-10">
                                                                            <label>Capacity</label>
                                                                            <input type="number" id="capacity" 
                                                                                   name="capacity" required="required"
                                                                                   min="10" max="100"
                                                                                   class="form-control form-control-sm rounded-0"
                                                                                   placeholder=""/>
                                                                            <span id="capacityFeedback"></span>
                                                                        </div>-->

                                    <div class="col-lg-2 col-md-4 col-sm-4 col-xs-10">
                                        <label>Price (Per Ticket)</label>
                                        <input type="number" id="price" 
                                               name="price" required="required"
                                               class="form-control form-control-sm rounded-0" 
                                               value="<?= $eventData['price'] ?>"/>
                                        <span id="priceFeedback"></span>
                                    </div>

                                    <div class="col-lg-2 col-md-4 col-sm-4 col-xs-10">
                                        <label>Status</label>
                                        <select id="status" name="status" class="form-control form-control-sm rounded-0" required>
                                            <?php
                                            echo $displayStatus;
                                            ?>
                                        </select>
                                        <span id="statusFeedback" name="statusFeedback"></span>
                                    </div>
                                </div>
                                <div class="clearfix">&nbsp;</div>
                                <div class="row">
                                    <div class="col-lg-11 col-md-11 col-sm-11 col-xs-2">&nbsp;</div>
                                    <div class="col-lg-1 col-md-1 col-sm-1 col-xs-2">
                                        <button type="submit" id="editEvent" 
                                                name="editEvent" class="btn btn-primary btn-sm btn-flat btn-block">Update</button>
                                    </div>
                                </div>

                                <!--Hidden Input-->
                                <input type="hidden" name="eventId" value="<?= $eventData['eventId'] ?>"/>
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
        <?php include_once '../../config/site_js_links.php'; ?>

        <!-- JavaScript -->
        <script src="../../plugins/moment/moment.min.js" type="text/javascript"></script>
        <script src="../../plugins/daterangepicker/daterangepicker.js" type="text/javascript"></script>
        <script src="../../plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js" type="text/javascript"></script>
        <script>
            $(function () {
                showMenuSelected("#events", "#add_events");
            })
            $('#event_start_date').datetimepicker({
                format: 'L'
            });
            $('#event_end_date').datetimepicker({
                format: 'L'
            })
        </script>
        <!-- JavaScript -->

    </body>
</html>