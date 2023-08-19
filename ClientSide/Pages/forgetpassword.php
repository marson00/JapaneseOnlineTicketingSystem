<?php
require_once '../../config/connection.php';

$conn = connection::getInstance()->getCon();

//session_start();
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Forget Password Page</title>
        <?php include_once '../../config/client_css_links.php'; ?>
    </head>
    <body>
    <body>
        <div class="vh-100" style="background-color: #9A616D;">
            <div class="container py-5 h-100">
                <div class="row d-flex justify-content-center align-items-center h-100">
                    <div class="col col-xl-6">
                        <div class="card" style="border-radius: 1rem;">
                            <div class="card-header">
                                 <h5 class="card-title">Reset Password</h5>
                            </div>
                            <div class="card-body">
                                <form>
                                    <div class="form-group">
                                        <label for="emailInput">Email address</label>
                                        <input type="email" class="form-control" id="emailInput" placeholder="Enter email">
                                        <span id="emailFeedback"></span>
                                    </div>
                                    <div class="form-group d-none mt-3" id="otp">
                                        <label for="otpInput">Enter the OTP</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control mr-5" id="otpInput" placeholder="Enter OTP" disabled>
                                            <span id="otpFeedback"></span>
                                            <div class="input-group-append">
                                                <button class="btn btn-warning rounded-5 " type="button" id="requestOTPButton">Request OTP</button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group d-none mt-3" id="newPwd">
                                        <label for="newPwdInput">Enter your new password</label>
                                        <input type="password" class="form-control" id="newPwdInput" placeholder="Enter new password">
                                        <span id="newPwdFeedback"></span>
                                    </div>
                                </form>
                            </div>
                            <div class="card-footer">
                                <button type="button" class="btn btn-primary" id="submitBtn">Submit email</button>
                                <button type="button" class="btn btn-primary d-none disabled" id="otpSubmit">Submit OTP</button>
                                <button type="button" class="btn btn-primary d-none disabled" id="resetBtn">Reset</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- MDB -->
        <?php include_once '../../config/client_js_links.php'; ?>
        <!-- Custom scripts -->
        <script src="../../validation/forgetpassword.js" type="text/javascript"></script>
    </body>
</body>
</html>

