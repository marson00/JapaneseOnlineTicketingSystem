//Global variables & function
let otpReturn = "";
function isInputEmpty(input) {
    var isEmpty = false;
    if (input === "") {
        isEmpty = true;
    }
    return isEmpty;
}

//buttons
const submitEmailBtn = document.getElementById('submitBtn');
const resetBtn = document.getElementById('resetBtn');
const otpSubmitBtn = document.getElementById('otpSubmit');
const requestOtpBtn = document.getElementById('requestOTPButton');

//the form group
const otpFormGroup = document.getElementById('otp');
const newPwdFormGroup = document.getElementById('newPwd');

//input
const emailInput = document.getElementById('emailInput');
const otpInput = document.getElementById('otpInput');
const newPwdInput = document.getElementById('newPwdInput');

//feedback message
const emailFeedback = document.getElementById('emailFeedback');
const otpFeedback = document.getElementById('otpFeedback');
const newPwdFeedback = document.getElementById('newPwdFeedback');


//Submit email 
submitEmailBtn.addEventListener('click', function () {
    // Get the values from the input fields
    var count = 0;
    const email = emailInput.value.toString().trim();
    const isEmpty = isInputEmpty(email);
    const isValid = /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);

    //use to make request to server-side 
    var xhttp = new XMLHttpRequest();
//    //handle the response data
    xhttp.onreadystatechange = function () {
        //if = 4, means response is sent back
        //if = 200, means response is success
        if (this.readyState === 4 && this.status === 200) {
            // Handle the response from the PHP script
            count = this.responseText;

            //check empty
            if (isEmpty !== true) {
                //check format
                if (isValid) {
                    //if count > 0 means exist, than move on 
                    //if count == 0, means not exist, re-enter
                    if (count > 0) {
                        //clear the error feedback message & style, and disable the input field
                        emailFeedback.textContent = "";
                        emailInput.classList.remove('is-invalid');
                        emailInput.disabled = true;

                        otpFormGroup.classList.remove('d-none');
                        otpSubmitBtn.classList.remove('d-none');
                        submitEmailBtn.classList.add('d-none');
                        submitEmailBtn.disabled = true;
                    } else {
                        emailFeedback.textContent = "This email is not exist, please re-enter an valid email";
                        emailInput.classList.remove('is-valid');
                        emailInput.classList.add('is-invalid');
                        emailFeedback.classList.add('invalid-feedback');
                    }
                } else {
                    emailFeedback.textContent = "This is not a valid email format";
                    emailInput.classList.remove('is-valid');
                    emailInput.classList.add('is-invalid');
                    emailFeedback.classList.add('invalid-feedback');
                }
            } else {
                emailFeedback.textContent = "Please enter an email";
                emailInput.classList.remove('is-valid');
                emailInput.classList.add('is-invalid');
                emailFeedback.classList.add('invalid-feedback');
            }
        }
    };

    //specity the action type and the location of the php script, 
    xhttp.open("GET", "/JapaneseOnlineTicketingSystem/checkExist/checkEmail.php?email=" + email, true);
    xhttp.send();
});

//second button for requesting OTP
requestOtpBtn.addEventListener('click', function () {
    const email = emailInput.value.toString().trim();

// Create a new XMLHttpRequest object 
    var xhr = new XMLHttpRequest();

// Set up the request
    xhr.open('GET', '/JapaneseOnlineTicketingSystem/config/sendOTP.php?email=' + email);

// Set up the callback function for when the response is received
//receive the OTP 
    xhr.onload = function () {
        if (xhr.status === 200) {
            // If request was successful, assign the returned otp value to the global variable
            otpReturn = xhr.responseText;
            if (otpReturn !== "") {
                otpInput.disabled = false;
                otpSubmitBtn.classList.remove('disabled');
            }
        } else {
            // Request failed
            console.error('Request failed. Status: ' + xhr.status);
        }
    };

    //Set up the callback function for when an error occurs
    xhr.onerror = function () {
        console.error('An error occurred while sending the request.');
    };
    // Send the request to the php script
    xhr.send();
});

//third button for submit OTP
otpSubmitBtn.addEventListener('click', function () {
    otpValue = otpInput.value.toString().trim();
    const isEmpty = isInputEmpty(otpValue);
    const isDigit = /\d/.test(otpValue);

//if the otp field is not empty
    if (isEmpty !== true) {
        //if the otp value only consist of digit 
        if (isDigit === true) {
            //if the otp entered is same with the sent otp
            if (otpValue === otpReturn) {
                //disable the input
                otpInput.disabled = true;
                //disable the otp submit button
                otpSubmitBtn.classList.add('d-none');
                otpSubmitBtn.disabled = true;
                //disable the error message if any
                otpFeedback.textContent = "";
                otpInput.classList.remove('is-invalid');
                otpFeedback.classList.remove('invalid-feedback');
                //review the password class & the reset password button
                newPwdFormGroup.classList.remove('d-none');
                resetBtn.classList.remove('d-none');
                resetBtn.classList.remove('disabled')
            } else {
                otpFeedback.textContent = "The OTP is incorrect";
                otpInput.classList.remove("is-valid");
                otpInput.classList.add("is-invalid");
                otpFeedback.classList.add("invalid-feedback");
            }
        } else {
            otpFeedback.textContent = "OTP must only contain digits";
            otpInput.classList.remove("is-valid");
            otpInput.classList.add("is-invalid");
            otpFeedback.classList.add("invalid-feedback");
        }
    } else {
        otpFeedback.textContent = "Please enter the OTP";
        otpInput.classList.remove("is-valid");
        otpInput.classList.add("is-invalid");
        otpFeedback.classList.add("invalid-feedback");
    }

//    newPwdInput.classList.remove('d-none');
//    resetBtn.classList.remove('d-none');
//    otpSubmitBtn.classList.add('d-none');
});

resetBtn.addEventListener('click', function () {
    const emailValue = emailInput.value.toString().trim();
    const newPwdValue = newPwdInput.value.toString().trim();
    const isEmpty = isInputEmpty(newPwdValue);

    //check format 
    const isAlphabet = /[a-zA-Z]/.test(newPwdValue);
    const isDigit = /\d/.test(newPwdValue);
    const isSpecial = /[!@#$%^&*(),.?":{}|<>]/.test(newPwdValue);

//check if the new password is empty or not
    if (isEmpty !== true) {
        //check if the password length is enough length or not
        if (newPwdValue.length > 8) {
            //check if the password format is correct or not
            if (isAlphabet && isDigit && isSpecial) {
                //update the password & make action based on the respond    
                const updateXhr = new XMLHttpRequest();

                // Set up the request
                updateXhr.open('GET', '/JapaneseOnlineTicketingSystem/config/updatePassword.php?password=' + newPwdValue + '&email=' + emailValue);
                updateXhr.onload = function () {
                    if (updateXhr.status === 200) {
                        //disable the error message if any
                        newPwdFeedback.textContent = "";
                        newPwdInput.classList.remove('is-invalid');
                        newPwdInput.classList.remove('invalid-feedback');
                        
                        
                        alert(updateXhr.responseText)
                        window.location.href = "/JapaneseOnlineTicketingSystem/ClientSide/Pages/login_page.php";
                    } else {
                        // Request failed
                        console.error('Request failed. Status: ' + updateXhr.status);
                    }
                };

                //Set up the callback function for when an error occurs
                updateXhr.onerror = function () {
                    console.error('An error occurred while sending the request.');
                };
                // Send the request to the php script
                updateXhr.send();
            } else {
                newPwdFeedback.textContent = "Password should contain at least 1 letter, 1 number and 1 special character";
                newPwdInput.classList.remove('is-valid');
                newPwdInput.classList.add('is-invalid');
                newPwdFeedback.classList.add('invalid-feedback');
            }
        } else {
            newPwdFeedback.textContent = "Password should be at least 8 characters long";
            newPwdInput.classList.remove('is-valid');
            newPwdInput.classList.add('is-invalid');
            newPwdFeedback.classList.add('invalid-feedback');
        }
    } else {
        newPwdFeedback.textContent = "Please enter your new password";
        newPwdInput.classList.remove('is-valid');
        newPwdInput.classList.add('is-invalid');
        newPwdFeedback.classList.add('invalid-feedback');
    }
});