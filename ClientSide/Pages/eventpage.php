<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->

<?php
require_once '../../config/connection.php';
require_once '../../dataEncryption/encryption.php';
require_once '../../dataEncryption/decryption.php';

$conn = connection::getInstance()->getCon();

if (isset($_GET['categoryId'])) {
    //Decryption
    $decryption = new decryption("eventEncryption");
    $categoryId = $decryption->decrypt($_GET['categoryId']);
}
?>
<html>
    <head>  
        <title>Event</title>
        <?php include_once '../../config/client_css_links.php'; ?>
        <style>
            body{
                overflow: none;
            }
            .carousel-control-prev,
            .carousel-control-next {
                z-index: 1;
            }

            .card-body {
                position: relative;
                z-index: 2;
            }
            @media (max-width: 767px) {
                .carousel-inner .carousel-item > div {
                    display: none;
                }
                .carousel-inner .carousel-item > div:first-child {
                    display: block;
                }
            }

            .carousel-inner .carousel-item.active,
            .carousel-inner .carousel-item-next,
            .carousel-inner .carousel-item-prev {
                display: flex;
            }

            /* medium and up screens */
            @media (min-width: 768px) {

                .carousel-inner .carousel-item-end.active,
                .carousel-inner .carousel-item-next {
                    transform: translateX(25%);
                }

                .carousel-inner .carousel-item-start.active,
                .carousel-inner .carousel-item-prev {
                    transform: translateX(-25%);
                }
            }

            .carousel-inner .carousel-item-end,
            .carousel-inner .carousel-item-start {
                transform: translateX(0);
            }
        </style>
    </head>
    <body>
        <!-- Top navigation -->
        <?php include_once '../adapter/topNav.php'; ?>

        <!-- Event start here -->
        <?php
        if ($categoryId != null) {
            $eventQuery = "SELECT * FROM event WHERE categoryId = :categoryId";
            $eventStmt = $conn->prepare($eventQuery);
            $eventStmt->bindParam(':categoryId', $categoryId);
            $eventStmt->execute();
            $events = $eventStmt->fetchAll(PDO::FETCH_ASSOC);
            ?>
            <div class="container-fluid my-5 w-100" >

                <?php
                foreach ($cats as $cat) {
                    if ($cat['categoryId'] == $categoryId) {
                        echo "<h1 class='fw-bold ms-5'>" . $cat['categoryTitle'] . "</h1>";
                    }
                }
                ?>

                <div class="container text-center my-5">
                    <div class="row mx-auto my-auto justify-content-center">
                        <?php if (count($events) > 4) { ?>
                            <div id="recipeCarousel" class="carousel slide " data-bs-ride="carousel">
                                <div class="carousel-inner shadow-5" role="listbox">
                                    <?php
                                    $i = 0;
                                    foreach ($events as $event) {
                                        ?>
                                        <div class="carousel-item <?php echo $i == 0 ? 'active' : ''; ?>">
                                            <div class="col-md-3 shadow-5">
                                                <div class="card">
                                                    <div class="card-img position-relative bg-white">
                                                        <img src="../../pictures/<?php echo $event['image'] . "?text=" . $event['eventId'] ?>" class="img-fluid <?= ($event['statusId'] != 1 || $event['quantityLeft'] == 0) ? 'opacity-25' : '' ?>" style="width: 100%; height:200px;">
                                                        <?= $event['statusId'] != 1 ? '<div class="position-absolute top-50 start-50 translate-middle text-center text-danger h2 fw-bold">Event Ended</div>' : '' ?>
                                                        <?= ($event['statusId'] == 1 && $event['quantityLeft'] == 0) ? '<div class="position-absolute top-50 start-50 translate-middle text-center text-danger h2 fw-bold">Ticket Sold Out</div>' : '' ?>
                                                    </div>
                                                </div>
                                                <div class="card-body my-5 ">
                                                    <div class="m-3"><h4><b><?php echo $event['eventName'] ?></b></h4></div>
                                                    <button type="button" class="btn btn-danger btn-rounded fw-semibold mb-3" data-bs-toggle="modal" data-bs-target="#eventModal<?= $event['eventId'] ?>">
                                                        View Details
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <?php
                                        $i++;
                                    }
                                    ?>
                                </div>

                                <a class="carousel-control-prev bg-transparent w-aut mb-10" href="#recipeCarousel" role="button" data-bs-slide="prev">
                                    <span class="carousel carousel-control-prev-icon" aria-hidden="true" style="color:red"></span>
                                </a>
                                <a class="carousel-control-next bg-transparent w-aut mb-10" href="#recipeCarousel" role="button" data-bs-slide="next">
                                    <span class="carousel carousel-control-next-icon" aria-hidden="true" style="color:red"></span>
                                </a>
                            </div>
                        <?php } else { ?>
                            <?php
                            foreach ($events as $event) {
                                ?>
                                <div class="col-md-3 p-0 shadow-5">
                                    <div class="card">
                                        <div class="card-img position-relative bg-white">
                                            <img src="../../pictures/<?php echo $event['image'] . "?text=" . $event['eventId'] ?>" class="img-fluid <?= ($event['statusId'] != 1 || $event['quantityLeft'] == 0) ? 'opacity-25' : '' ?>" style="width: 100%; height:200px;">
                                            <?= $event['statusId'] != 1 ? '<div class="position-absolute top-50 start-50 translate-middle text-center text-danger h2 fw-bold">Event Ended</div>' : '' ?>
                                            <?= ($event['statusId'] == 1 && $event['quantityLeft'] == 0) ? '<div class="position-absolute top-50 start-50 translate-middle text-center text-danger h2 fw-bold">Ticket Sold Out</div>' : '' ?>
                                        </div>
                                    </div>
                                    <div class="card-body my-5">
                                        <div class="m-3"><h4><b><?php echo $event['eventName'] ?></b></h4></div>
                                        <button type="button" class="btn btn-danger btn-rounded fw-semibold mb-3" data-bs-toggle="modal" data-bs-target="#eventModal<?= $event['eventId'] ?>">
                                            View Details
                                        </button>
                                    </div>
                                </div>
                                <?php
                            }
                            ?>
                        <?php } ?>
                    </div>
                </div>
            </div>
        <?php } ?>
        <!-- Event end here -->

        <!---------------------------------------Modal Part---------------------------------------->

        <!-- Event modal -->
        <?php
        foreach ($events as $event) {
            ?>
            <div class="modal fade" id="eventModal<?php echo $event['eventId'] ?>" tabindex="-1" aria-labelledby="eventModalLabel<?php echo $event['eventId'] ?>" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title fw-bold" id="eventModalLabel<?php echo $event['eventId'] ?>"><?php echo $event['eventName'] ?></h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="section pd-3">
                                <h5 class="text-danger fw-bold">Event information</h5>
                                <div class="text-center mb-3 position-relative">
                                    <img src="../../pictures/<?php echo $event['image'] ?>" class="img-fluid <?= ($event['statusId'] != 1 || $event['quantityLeft'] == 0) ? 'opacity-25' : '' ?>" alt=" <?php echo $event['eventName'] ?> Image">
                                    <?= $event['statusId'] != 1 ? '<div class="position-absolute top-50 start-50 translate-middle text-center text-danger h2 fw-bold">Event Ended</div>' : '' ?>
                                    <?= ($event['statusId'] == 1 && $event['quantityLeft'] == 0) ? '<div class="position-absolute top-50 start-50 translate-middle text-center text-danger h2 fw-bold">Ticket Sold Out</div>' : '' ?>
                                </div>
                                <p><b>Event Date:</b><span class="float-end"><?php echo $event['startDate'] . " - " . $event['endDate'] ?></span></p>
                                <p><b>Location: </b><span class="float-end"><?php echo $event['location'] ?></span></p>
                                <p><b>Price (RM): </b><span class="float-end"><?php echo "RM " . $event['price'] ?></span></p>
                                <p><b>Quantity Left: </b><span class="float-end"><?php echo $event['quantityLeft'] ?></span></p>
                                <p><b>Description: </b><span class="float-end"><?php echo $event['description'] ?></span></p>

                                <!-- Add more details here as needed -->
                            </div>
                        </div>


                        <div class="modal-footer">
                            <?php
                            if ($event['quantityLeft'] < 1 || $event['statusId'] != 1) {
                                ?>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <?php
                            } else {
                                ?>
                                <a class="btn btn-danger btn-small btn-flat fw-bold" href="/JapaneseOnlineTicketingSystem/ClientSide/Pages/purchase.php?eventId=<?php echo $dataEncryption->encrypt($event['eventId']) ?>">
                                    <span class="mr-2">Purchase</span>
                                </a>
                                <?php
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
            <?php
        }
        ?>



        <!-- Footer -->
        <?php include_once '../adapter/footer.php'; ?>

        <!-- MDB -->
        <?php include_once '../../config/client_js_links.php'; ?>
        <script>
            let items = document.querySelectorAll('.carousel .carousel-item');

            items.forEach((el) => {
                const minPerSlide = 4;
                let next = el.nextElementSibling;
                for (var i = 1; i < minPerSlide; i++) {
                    if (!next) {
                        // wrap carousel by using first child
                        next = items[0];
                    }
                    let cloneChild = next.cloneNode(true);
                    el.appendChild(cloneChild.children[0]);
                    next = next.nextElementSibling;
                }
            });

            let carousel = document.querySelector('.carousel');
            carousel.addEventListener('slide.bs.carousel', function (event) {
                let activeItem = event.relatedTarget;
                let items = carousel.querySelectorAll('.carousel-item');
                items.forEach((el) => {
                    el.classList.remove('active');
                });
                activeItem.classList.add('active');
            });

        </script>
    </body>
</html>