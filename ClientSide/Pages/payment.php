<!DOCTYPE html>
<html>
    <head>
        <title>Payment</title>
        <?php include_once '../../config/client_css_links.php'; ?>
    </head>
    <body>
        <!-- Top Navigation Bar -->
        <?php include_once '../adapter/topNav.php'; ?>

        <?php
        $isSuccess = false;
        if (isset($_POST['confirmPaymentV'])) {
            handlePaymentConfirmation($conn, "visa");
            $isSuccess = true;
        } else if (isset($_POST['confirmPaymentM'])) {
            handlePaymentConfirmation($conn, "master");
            $isSuccess = true;
        }

        function handlePaymentConfirmation($conn, $cardTypeInput) {
            $cardTypeLetter = $cardTypeInput == "visa" ? 'V' : 'M';
            $userId = $_POST["hiddenUserId{$cardTypeLetter}"];
            $buyerUsername = $_POST["hiddenUserName{$cardTypeLetter}"];
            $eventId = $_POST["hiddenEventId{$cardTypeLetter}"];
            $qty = $_POST["hiddenQty{$cardTypeLetter}"];
            $totalPrice = $_POST["hiddentTotalPrice{$cardTypeLetter}"];
            $cardNum = $_POST["cardNum{$cardTypeLetter}"];
            $cardHolder = $_POST["cardName{$cardTypeLetter}"];
            $expMonth = $_POST["cardExpMonth{$cardTypeLetter}"];
            $expYear = $_POST["cardExpYear{$cardTypeLetter}"];
            $cvv = $_POST["cardCvv{$cardTypeLetter}"];
            $cardType = $cardTypeInput;

            //insert order first
            addOrder($conn, $userId, $eventId, $qty, $totalPrice);

            //get the order id inserted
            $orderIdLatest = getLatestOrderId($conn);

            //insert the ticket holder & order detail
            for ($i = 0; $i < $qty; $i++) {
                $ticketId = getTicketId($conn, $eventId);
                addTicketHolder($conn, $buyerUsername, $ticketId);
                addOrderDetail($conn, $orderIdLatest, $ticketId);
            }

            //Update event qty left
            $eventData = getEventDataById($conn, $eventId);
            $qtyLeft = $eventData['quantityLeft'] - $qty;
            updateQtyLeft($conn, $qtyLeft, $eventId);

            //add card 
            addCard($conn, $cardHolder, $cardNum, $expMonth, $expYear, $cvv, $cardType);

            //get card id
            $cardIdLatest = getLatestCardId($conn);

            //add payment
            addPayment($conn, $orderIdLatest, $cardIdLatest);

            //remove all the session related data
            unset($_SESSION['eventId']);
            unset($_SESSION['purchaseQty']);
            unset($_SESSION['totalPrice']);
        }

        function addOrder($conn, $userId, $eventId, $qty, $totalPrice) {
            $query = "INSERT INTO `order` (custId, eventId, purchaseQty, totalPrice, orderedDate)
              VALUES (:custId, :eventId, :purchaseQty, :totalPrice, NOW())";
            ;

            $conn->beginTransaction();
            $stmt = $conn->prepare($query);
            $stmt->bindValue(':custId', $userId, PDO::PARAM_INT);
            $stmt->bindValue(':eventId', $eventId, PDO::PARAM_INT);
            $stmt->bindValue(':purchaseQty', $qty, PDO::PARAM_INT);
            $stmt->bindValue(':totalPrice', $totalPrice, PDO::PARAM_INT);
            $stmt->execute();
            $conn->commit();
        }

        function addTicketHolder($conn, $holder, $ticketId) {
            $query = "UPDATE ticket SET holder = :holder 
              WHERE ticketId = :ticketId ";

            $conn->beginTransaction();
            $stmt = $conn->prepare($query);
            $stmt->bindValue(':holder', $holder, PDO::PARAM_STR);
            $stmt->bindValue(':ticketId', $ticketId, PDO::PARAM_INT);
            $stmt->execute();
            $conn->commit();
        }

        function addOrderDetail($conn, $orderId, $ticketId) {
            $query = "INSERT INTO order_detail (orderId, ticketId)
              VALUES (:orderId, :ticketId)";

            $conn->beginTransaction();
            $stmt = $conn->prepare($query);
            $stmt->bindValue(':orderId', $orderId, PDO::PARAM_INT);
            $stmt->bindValue(':ticketId', $ticketId, PDO::PARAM_INT);
            $stmt->execute();
            $conn->commit();
        }

        function addCard($conn, $holder, $cardNum, $expMonth, $expYear, $cvv, $cardType) {
            $query = "INSERT INTO card (holderName, cardNum, expMonth, expYear, cvv, cardType)
              VALUES (:holderName, :cardNum, :expMonth, :expYear, :cvv, :cardType)";

            $conn->beginTransaction();
            $stmt = $conn->prepare($query);
            $stmt->bindValue(':holderName', $holder, PDO::PARAM_STR);
            $stmt->bindValue(':cardNum', $cardNum, PDO::PARAM_STR);
            $stmt->bindValue(':expMonth', $expMonth, PDO::PARAM_INT);
            $stmt->bindValue(':expYear', $expYear, PDO::PARAM_INT);
            $stmt->bindValue(':cvv', $cvv, PDO::PARAM_STR);
            $stmt->bindValue(':cardType', $cardType, PDO::PARAM_STR);
            $stmt->execute();
            $conn->commit();
        }

        function addPayment($conn, $orderId, $cardId) {
            $query = "INSERT INTO payment (orderId, cardId, paymentDate)
              VALUES (:orderId, :cardId, NOW())";

            $conn->beginTransaction();
            $stmt = $conn->prepare($query);
            $stmt->bindValue(':orderId', $orderId, PDO::PARAM_INT);
            $stmt->bindValue(':cardId', $cardId, PDO::PARAM_INT);
            $stmt->execute();
            $conn->commit();
        }

        function updateQtyLeft($conn, $qtyLeft, $eventId) {
            $query = "UPDATE event SET quantityLeft = :qtyLeft 
              WHERE eventId = :eventId ";

            $conn->beginTransaction();
            $stmt = $conn->prepare($query);
            $stmt->bindValue(':qtyLeft', $qtyLeft, PDO::PARAM_INT);
            $stmt->bindValue(':eventId', $eventId, PDO::PARAM_INT);
            $stmt->execute();
            $conn->commit();
        }
        ?>

        <!-- Pills navs -->
        <div class="container w-25 mb-5 border border-2 rounded-3 border-primary shadow-5 mt-5">
            <h2 class="w-full text-center mb-5" style="line-height: 0.1">
                <span class="bg-white px-3 fw-bold">Payment</span>
            </h2>

            <ul class="nav nav-pills nav-justified mb-3" id="ex1" role="tablist">
                <li class="nav-item" role="presentation">
                    <a
                        class="nav-link active"
                        id="visa"
                        data-mdb-toggle="pill"
                        href="#pills-visa"
                        role="tab"
                        aria-controls="pills-login"
                        aria-selected="true"
                        >Visa</a
                    >
                </li>
                <li class="nav-item" role="presentation">
                    <a
                        class="nav-link"
                        id="master"
                        data-mdb-toggle="pill"
                        href="#pills-master"
                        role="tab"
                        aria-controls="pills-register"
                        aria-selected="false"
                        >Master Card</a
                    >
                </li>
            </ul>
            <!-- Pills navs -->

            <!-- Pills content -->
            <div class="tab-content">
                <div class="tab-pane fade show active" id="pills-visa" role="tabpanel" aria-labelledby="tab-visa">
                    <form method="post" enctype="multipart/form-data">
                        <p class="fw-bold mb-4 pb-2">Visa Card:</p>

                        <div class="d-flex flex-row align-items-center mb-4 pb-1">
                            <img class="img-fluid" src="https://img.icons8.com/color/48/000000/visa.png" />
                            <div class="flex-fill ms-3">
                                <div class="form-outline">
                                    <input type="text" id="cardNumV" name="cardNumV" class="form-control form-control-lg"
                                           placeholder="**** **** **** ****" maxlength="20" required/>
                                    <span id="cardNumVFeedback"></span>
                                    <label class="form-label" for="cardNumV">Card Number</label>                                    
                                </div>
                            </div>
                        </div>

                        <div class="form-outline mb-4">
                            <input type="text" id="cardNameV" name="cardNameV" class="form-control form-control-lg"
                                   placeholder="Endao Marson"  required/>
                            <span id="cardNameVFeedback"></span>
                            <label class="form-label" for="cardNameV">Card Holder Name</label>
                        </div>

                        <div class="row mb-5">
                            <div class="col-4">
                                <div class="form-outline">
                                    <input type="text"  id="cardExpYearV" name="cardExpYearV" maxlength="4" class="form-control form-control-lg"
                                           placeholder="YYYY" required/>
                                    <span id="cardYearVFeedback"></span>
                                    <label class="form-label" for="cardExpYearV">Exp Year</label>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-outline">
                                    <input type="text"  id="cardExpMonthV" name="cardExpMonthV" maxlength="2" class="form-control form-control-lg"
                                           placeholder="MM" required/>
                                    <span id="cardMonthVFeedback" class=""></span>
                                    <label class="form-label" for="cardExpMonthV">Exp Month</label>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-outline">
                                    <input type="text" id="cardCvvV" name="cardCvvV" maxlength="3" class="form-control form-control-lg"
                                           placeholder="123" required/>
                                    <span id="cvvVFeedback"></span>
                                    <label class="form-label" for="cardCvvV">Cvv</label>
                                </div>
                            </div>
                        </div>

                        <!-- Submit button -->
                        <button type="submit" class="btn btn-primary btn-lg btn-block mb-4 fw-bold" id="confirmPaymentV" name="confirmPaymentV">Confirm</button>

                        <!-- Hidden -->
                        <input type="hidden" name="hiddenUserIdV" value="<?= $userIdSession ?? ""; ?>"/>
                        <input type="hidden" name="hiddenUserNameV" value="<?= $usernameSession ?? ""; ?>"/>
                        <input type="hidden" name="hiddenEventIdV" value="<?= $_SESSION['eventId'] ?? ""; ?>"/>
                        <input type="hidden" name="hiddenQtyV" value="<?= $_SESSION['purchaseQty'] ?? ""; ?>"/>
                        <input type="hidden" name="hiddentTotalPriceV" value="<?= $_SESSION['totalPrice'] ?? ""; ?>"/>    
                    </form>
                </div>                        
                <div class="tab-pane fade" id="pills-master" role="tabpanel" aria-labelledby="tab-master">
                    <form method="post" enctype="multipart/form-data">
                        <p class="fw-bold mb-4 pb-2">Master Card:</p>

                        <div class="d-flex flex-row align-items-center mb-4 pb-1">
                            <img class="img-fluid" src="https://img.icons8.com/color/48/000000/mastercard-logo.png" />
                            <div class="flex-fill ms-3">
                                <div class="form-outline">
                                    <input type="text" id="cardNumM" name="cardNumM" class="form-control form-control-lg"
                                           placeholder="**** **** **** ****" maxlength="20" required/>
                                    <span id="cardNumMFeedback"></span>
                                    <label class="form-label" for="cardNumM">Card Number</label>
                                </div>
                            </div>
                        </div>

                        <div class="form-outline mb-4">
                            <input type="text" id="cardNameM" name="cardNameM" class="form-control form-control-lg"
                                   placeholder="Endao Marson" required/>
                            <span id="cardNameMFeedback"></span>
                            <label class="form-label" for="cardNameM">Card Holder Name</label>
                        </div>

                        <div class="row mb-5">
                            <div class="col-4">
                                <div class="form-outline">
                                    <input type="text"  id="cardExpYearM" name="cardExpYearM" maxlength="4" class="form-control form-control-lg"
                                           placeholder="YYYY" required/>
                                    <span id="mCardYearFeedback"></span>
                                    <label class="form-label" for="cardExpYearM">Exp Year</label>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-outline">
                                    <input type="text"  id="cardExpMonthM" name="cardExpMonthM" maxlength="2" class="form-control form-control-lg"
                                           placeholder="MM" required/>
                                    <span id="mCardMonthFeedback"></span>
                                    <label class="form-label" for="cardExpMonthM">Exp Month</label>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-outline">
                                    <input type="text" id="cardCvvM" name="cardCvvM" maxlength="3" class="form-control form-control-lg"
                                           placeholder="123" required/>
                                    <span id="mCardCvvFeedback"></span>
                                    <label class="form-label" for="cardCvvM">Cvv</label>
                                </div>
                            </div>
                        </div>

                        <!-- Submit button -->                       
                        <button type="submit" class="btn btn-primary btn-lg btn-block mb-4 fw-bold" id="confirmPaymentM" name="confirmPaymentM">Confirm</button>

                        <!-- Hidden -->
                        <input type="hidden" name="hiddenUserIdM" value="<?= $userIdSession; ?>"/>
                        <input type="hidden" name="hiddenUserNameM" value="<?= $usernameSession; ?>"/>
                        <input type="hidden" name="hiddenEventIdM" value="<?= $_SESSION['eventId']; ?>"/>
                        <input type="hidden" name="hiddenQtyM" value="<?= $_SESSION['purchaseQty']; ?>"/>
                        <input type="hidden" name="hiddentTotalPriceM" value="<?= $_SESSION['totalPrice']; ?>"/>
                    </form>
                </div>
            </div>
        </div>
        <!-- Pills content -->

        <!-- Footer -->
        <?php include_once '../adapter/footer.php'; ?>

        <!-- MDB -->
        <?php include_once '../../config/client_js_links.php'; ?>

        <!-- Custom Script -->
        <script src="../../validation/visaValidation.js" type="text/javascript"></script>
        <script src="../../validation/masterValidation.js" type="text/javascript"></script>
        <script type="text/javascript">
            function showSuccess() {
                Swal.fire({
                    position: 'center',
                    icon: 'success',
                    title: 'Thanks',
                    text: 'Successfully bought event!',
                    showConfirmButton: false,
                    timer: 1500
                }).then(() => {
                    setTimeout(() => {
                        window.location.href = 'homepage.php';
                    }, 500);
                });
            }
            // Get the two input fields
            const visaCardNumInput = document.getElementById('cardNumV');
            const masterCardNumInput = document.getElementById('cardNumM');
            // Function to add event listener to an input field
            function cardNumSpacing(input) {
                input.addEventListener('input', function (e) {
                    // Get the current value of the input field
                    let currentValue = e.target.value;
                    // Remove any spaces from the current value
                    currentValue = currentValue.replace(/\s/g, '');
                    // Add a space after every fourth character
                    const formattedValue = currentValue.replace(/(\d{4})/g, '$1 ');
                    // Update the value of the input field with the formatted value
                    e.target.value = formattedValue;
                    console.log(visaCardNumInput.value.toString().trim());
                });
            }
            // Call the function for each input field
            cardNumSpacing(visaCardNumInput);
            cardNumSpacing(masterCardNumInput);

<?php if ($isSuccess) { ?>
                showSuccess();
<?php } ?>
        </script>
    </body>
</html>