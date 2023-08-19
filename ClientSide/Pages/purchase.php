<?php
require_once '../../config/connection.php';
require_once '../../config/common_functions.php';
require_once '../../dataEncryption/decryption.php';
require_once '../../session/sessionStart.php';

$conn = connection::getInstance()->getCon();

if (isset($_GET['eventId'])) {
    //Decryption
    $decryption = new decryption("eventEncryption");
    $eventId = $decryption->decrypt($_GET['eventId']);
    $eventData = getEventDataById($conn, $eventId);
}

if (isset($_POST['submitPayment'])) {

    $_SESSION['eventId'] = $_POST['hiddenEventId'];
    $_SESSION['purchaseQty'] = $_POST['purchaseQty'];
    $_SESSION['totalPrice'] = $_POST['hiddenTotalPrice'];
    
    header('Location: http://localhost/JapaneseOnlineTicketingSystem/ClientSide/Pages/payment.php' . $url);
    exit;
}
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Purchase Event</title>
        <?php include_once '../../config/client_css_links.php'; ?>
    </head>
    <body>
        <!-- Top Navigation Bar -->
        <?php include_once '../adapter/topNav.php'; ?>

        <!-- content -->
        <section>
            <div class="container py-3 w-75">
                <div class="row d-flex justify-content-center">
                    <div class="col-md-9 col-lg-7 col-xl-5">
                        <div class="card">
                            <img src="http://localhost/JapaneseOnlineTicketingSystem/pictures/<?= $eventData['image'] ?>"
                                 class="card-img-top" alt="Event Image" />
                            <div class="card-body">
                                <div class="card-title d-flex justify-content-between mb-0 fw-bold">
                                    <p class="text-muted mb-0"><?= $eventData['eventName'] ?></p>
                                    <p class="mb-0">RM <?= $eventData['price'] ?></p>
                                </div>
                            </div>
                            <div class="rounded-bottom border-bottom border-3 border-secondary" style="background-color: #eee;">
                                <form method="post" enctype="multipart/form-data">
                                    <div class="card-body">
                                        <p class="mb-4 fw-bold">Select Your Ticket Quantity: <span class="float-end fw-normal"><?= $eventData['quantityLeft'] ?> ticket(s) left</span></p>

                                        <div class="ccol-6 form-outline">
                                            <input type="number" id="purchaseQty" name="purchaseQty" class="form-control" min="1" max="5" required onkeyup="calculatePrice()"/>
                                            <label class="form-label" for="purchaseQty">Ticket Quantity</label>
                                            <span id="qtyFeedback"></span>
                                        </div>
                                        <span class="small float-end mb-3"><i>Maximum 5 tickets per purchase</i></span>

                                        <button class="btn btn-info btn-block fw-bold" type="button" id="totalPrice">RM 0.00</button>
                                        <button class="btn btn-danger btn-block fw-bold" type="submit" id="submitPayment" name="submitPayment">Proceed to Payment</button>
                                    </div>

                                    <!-- Hidden -->
                                    <input type="hidden" name="hiddenEventId" value="<?= $eventId ?>"/>
                                    <input type="hidden" id="hiddentEventPrice" name="hiddentEventPrice" value="<?= $eventData['price'] ?>"/>
                                    <input type="hidden" id="hiddenTotalPrice" name="hiddenTotalPrice" value=""/>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- content -->

        <!-- Footer -->
        <?php include_once '../adapter/footer.php'; ?>

        <!-- MDB -->
        <?php include_once '../../config/client_js_links.php'; ?>
        <script src="../../validation/purchaseValidation.js" type="text/javascript"></script>
    </body>
    <script>

        //get the qty left 
        const quantityLeft = <?php echo $eventData['quantityLeft'] ?> ;
        
        function calculatePrice() {
            var getPrice = document.getElementById('hiddentEventPrice').value;
            var getTicketNum = document.getElementById('purchaseQty').value;
            var price = parseFloat(getPrice);
            var total;

            if(getTicketNum > 0 && getTicketNum < 6){
                total = price * getTicketNum;
            }

            document.getElementById('totalPrice').innerHTML = "RM " + total.toFixed(2);
            document.getElementById('hiddenTotalPrice').value = total;
        }
        
        if(quantityLeft < 5){
             document.getElementById("purchaseQty").setAttribute("max", quantityLeft);
        }

    </script>

</html>
