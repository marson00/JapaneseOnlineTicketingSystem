<link href="../CssPages/footer.css" rel="stylesheet" type="text/css"/>
<link href="../CssPages/navigationbar.css" rel="stylesheet" type="text/css"/>

<?php
require_once '../../session/sessionStart.php';
require_once '../../config/connection.php';
require_once '../../dataEncryption/encryption.php';
require_once '../../config/common_functions.php';

$conn = connection::getInstance()->getCon();

$dataEncryption = new encryption("eventEncryption");

if (isset($_POST['saveBtn'])) {
    $email = $_POST['email'];
    $username = $_POST['username'];
    $phone = $_POST['phone'];
    
    if(!empty($email)){
        $query = "UPDATE `user` SET `email` = :email 
              WHERE `userId` = :userId;";
        
        $conn->beginTransaction();
        $stmtDetails = $conn->prepare($query);
        $stmtDetails->bindParam(':email', $email, PDO::PARAM_STR);
        $stmtDetails->bindParam(':userId', $userIdSession, PDO::PARAM_INT);
        
        $stmtDetails->execute();
        $conn->commit();
    }
    
    if(!empty($username)){
        $query = "UPDATE `user` SET `username` = :username
              WHERE `userId` = :userId;";
        
        $conn->beginTransaction();
        $stmtDetails = $conn->prepare($query);
        $stmtDetails->bindParam(':username', $username, PDO::PARAM_STR);
        $stmtDetails->bindParam(':userId', $userIdSession, PDO::PARAM_INT);
        
        $stmtDetails->execute();
        $conn->commit();
    }
    
    if(!empty($phone)){
        $query = "UPDATE `user` SET `phone` = :phone
              WHERE `userId` = :userId;";
        
        $conn->beginTransaction();
        $stmtDetails = $conn->prepare($query);
        $stmtDetails->bindParam(':phone', $phone, PDO::PARAM_STR);
        $stmtDetails->bindParam(':userId', $userIdSession, PDO::PARAM_INT);
        
        $stmtDetails->execute();
        $conn->commit();
    }
}
?>
<!-- Top navigation -->
<nav class="navbar navbar-expand-lg sticky-lg-top bg-white fw-bold shadow-5 ">
    <img src="../Pictures/japan_logo.png" class="img-fluid ps-3" alt="" style="width:10%" class="p-0 m-0"/>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="" role="button" ><i class="fa fa-bars" aria-hidden="true"></i></span>
    </button>

    <div class="collapse navbar-collapse nav-left" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto">
            <li class="nav-item active">
                <button type="button" class="btn btn-danger btn-rounded fw-semibold ms-4">
                    <i class="fa fa-house pe-3"></i><a class="text-white" href="homepage.php">Home</a>
                </button>
            </li>
            <li class="nav-item dropdown">
                <button type="button" class="btn btn-danger btn-rounded fw-semibold ms-3 dropdown-toggle" data-bs-toggle="dropdown">
                    <i class="fa fa-calendar pe-3"></i><a class="text-white" href="eventPage.php">Event</a>
                </button>
                <div class="dropdown-menu" style="min-width: 250px;">
                    <?php
                    $catQuery = "SELECT * FROM category";

                    $catStmt = $conn->prepare($catQuery);
                    $catStmt->execute();
                    $cats = $catStmt->fetchAll(PDO::FETCH_ASSOC);

                    foreach ($cats as $cat) {
                        echo "<a class='dropdown-item' href='eventpage.php?categoryId=" . $dataEncryption->encrypt($cat['categoryId']) . "'>" . $cat['categoryTitle'] . "</a>";
                    }
                    ?>
                </div>
            </li>
            <!--            <li class="nav-item">
                            <a class="nav-link ps-5 text-dark" href="aboutuspage.php">About Us</a>
                        </li>-->

        </ul>
    </div>
    <div class="collapse navbar-collapse nav-right" id="navbarSupportedContent">
        <ul class="navbar-nav ms-auto">
            <li class="nav-item">
                <!--<a class="nav-link ps-5 pe-5 text-dark" data-mdb-toggle="modal" data-mdb-target="#historyModal"><i class="fa fa-history"></i></a>-->
                <button type="button" class="btn btn-danger btn-rounded fw-semibold me-3" data-mdb-toggle="modal" data-mdb-target="#historyModal">
                    <i class="fa fa-history pe-3"></i> History
                </button>
            </li>
            <li class="nav-item">
                <button type="button" class="btn btn-danger btn-rounded fw-semibold me-3" data-mdb-toggle="modal" data-mdb-target="#profileModal">
                    <i class="fa fa-user pe-3"></i> <?= $usernameSession ? $usernameSession : 'Profile'; ?>
                </button>
            </li>
            <li class="nav-item">
                <a class="text-white" href="../../session/sessionEnd.php">
                    <button type="button" class="btn btn-info btn-rounded fw-semibold me-3" id="logout">
                        <i class="fa fa-sign-out-alt pe-3"></i>Logout
                    </button>
                </a>
            </li>
        </ul>
    </div>
    <!--                <div class="collapse navbar-collapse nav-right" id="navbarSupportedContent">
                        <ul class="navbar-nav ms-auto">
                            <li class="nav-item">
                                <a class="nav-link ps-5" href="registerpage.php" style="font-size:20px; color: black;">Register</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link ps-5 pe-5"  href="loginpage.php" style="font-size:20px; color: black;">Login</a>
                            </li>
                        </ul>
                    </div>-->
</nav>

<!---------------------------------------Modal Part---------------------------------------->

<div class="modal fade" id="profileModal" tabindex="-1" aria-labelledby="profileModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-danger">
                <h5 class="modal-title fw-bold text-white" id="exampleModalLabel">Profile <i class="fa fa-user"></i></h5>
                <button type="button" class="btn-close btn-close-white" data-mdb-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post" enctype="multipart/form-data">
                <div class="modal-body">

                    <div class="modal-body">
                        <div class="form-outline mb-4">
                            <input type="email" class="form-control form-control-lg" id="email" name="email"">
                            <span id="emailFeedback"></span>
                            <label for="email" class="form-label">Email address : </label>
                        </div>
                        <div class="form-outline mb-4">
                            <input type="text" class="form-control form-control-lg" id="username" name="username"" >
                            <span id="usernameFeedback" class="mb-4"></span>
                            <label for="username" class="form-label">Username : </label>
                        </div>
                        <div class="form-outline mb-4">
                            <input type="tel" class="form-control form-control-lg" id="phone" name="phone"">
                            <span id="phoneFeedback"></span>
                            <label for="phone" class="form-label">Phone Number : </label>
                        </div>

                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary me-auto" data-mdb-dismiss="modal">Close</button>
                    <button type="submit" id="saveBtn" name="saveBtn" class="btn btn-danger fw-bold">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!--HISTORY MODAL -->
<div id="historyModal" class="modal fade">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header bg-danger">
                <h5 class="modal-title fw-bold text-white" id="historyModal">Purchase History <i class="fa fa-history"></i></h5>
                <button type="button" class="btn-close btn-close-white" data-mdb-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-lg-3">

                <?php
                $tickets = getHistoryData($conn, $userIdSession);

                if ($tickets != null) {
                    foreach ($tickets as $ticket) {
                        ?>
                        <div class="card mt-3">
                            <div class="row card-body">
                                <div class="col-6 position-relative d-inline-block">
                                    <img src="../../pictures/<?= $ticket['image'] ?>" class="img-fluid w-100 <?= $ticket['statusId'] != 1 ? 'opacity-25' : '' ?>" style="height: 200px;">
                                    <?= $ticket['statusId'] != 1 ? '<div class="position-absolute top-50 start-50 translate-middle text-center text-danger h1 fw-bold">Event Ended</div>' : '' ?>
                                </div>
                                <div class="col-6 text-dark position-relative">
                                    <i class="fa-solid <?= $ticket['statusId'] == 1 ? 'fa-circle-check text-success' : 'fa-circle-xmark text-danger' ?> float-end"></i>
                                    <div class="mb-3 fw-bold h3"><?= $ticket['eventName'] ?></div>
                                    <div class="mb-1 fw-light">Event Date: <?= $ticket['startDate'] ?> - <?= $ticket['endDate'] ?></div>
                                    <div class="mb-1 fw-light">Location: <?= $ticket['location'] ?></div>
                                    <div class="mb-1 fw-light">Purchased At: <?= $ticket['orderedDate'] ?></div>
                                    <button class="btn btn-secondary w-100 fw-bold position-absolute bottom-0 start-50 translate-middle-x"><?= $ticket['ticketCode'] ?></button>
                                </div>
                            </div>
                        </div>

                        <?php
                    }
                } else {
                    ?>
                    <div class="card text-center p-5 fw-bold h4 m-3 bg-secondary text-white">No Event Added</div>
                <?php } ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary ms-auto" data-mdb-dismiss="modal">Close</button>
            </div>
            <script src="../../validation/profileValidation.js" type="text/javascript"></script>
        </div>
    </div>
</div>