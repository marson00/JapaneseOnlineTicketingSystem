//Global functions
function isInputEmpty(input) {
    var isEmpty = false;
    if (input === "") {
        isEmpty = true;
    }
    return isEmpty;
}
//Global functions end here 

//email validation.
const emailInput = document.getElementById('email');
const emailfeedback = document.getElementById('emailFeedback');
const emailOutline = document.getElementById("emailOutline");

emailInput.addEventListener('input', () => {
    const email = emailInput.value.trim();
    var errors = [];

    const isEmpty = isInputEmpty(email);
    const isValid = /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);

    if (isEmpty === true) {
        errors.push("Email should not be empty!");
    } else if (!isValid) {
        errors.push("Email format is invalid!");
    }

    if (errors.length > 0) {
        emailOutline.classList.remove("mb-3");
        emailOutline.classList.add("mb-5");
        emailfeedback.textContent = errors;
        emailInput.classList.remove('is-valid');
        emailInput.classList.add('is-invalid');
        emailfeedback.classList.add('invalid-feedback');
    } else {
        emailOutline.classList.remove("mb-5");
        emailOutline.classList.add("mb-3");
        emailfeedback.textContent = '';
        emailInput.classList.remove('is-invalid');
        emailInput.classList.add('is-valid');
        emailfeedback.classList.add('valid-feedback');
    }

});
//Email validation end here




//username validation
const usernameInput = document.getElementById("username");
const usernameFeedback = document.getElementById("usernameFeedback");
const usernameOutline = document.getElementById("usernameOutline");

usernameInput.addEventListener('input', () => {
    const username = usernameInput.value.trim();
    const isAlphabet = /[a-zA-Z]/.test(username);
    const isDigit = /\d/.test(username);
    var errors = [];

    const isEmpty = isInputEmpty(username);

    if (isEmpty === true) {
        errors.push("Please enter a username!");
    } else if (username.length < 6) {
        errors.push("User name must be at least 6 characters long");
    } else if (!isAlphabet || !isDigit) {
        errors.push("Username should contain at least 1 letter and 1 number")
    }

    //display error if the error message is not empty
    if (errors.length > 0) {
        usernameOutline.classList.remove("mb-3");
        usernameOutline.classList.add("mb-5");
        usernameFeedback.textContent = errors;
        usernameInput.classList.remove('is-valid');
        usernameInput.classList.add('is-invalid');
        usernameFeedback.classList.add('invalid-feedback');
    } else {
        usernameOutline.classList.remove("mb-5");
        usernameOutline.classList.add("mb-3");
        usernameFeedback.textContent = '';
        usernameInput.classList.remove('is-invalid');
        usernameInput.classList.add('is-valid');
        usernameFeedback.classList.add('invalid-feedback');
    }
});



//password validation start here
const passwordInput = document.getElementById("password");
const passwordFeedback = document.getElementById("pwdFeedback");
const passwordOutline = document.getElementById("pwdOutline");

passwordInput.addEventListener('input', () => {
    //variables
    const password = passwordInput.value.trim();
    var errors = [];

    //check empty
    const isEmpty = isInputEmpty(password);

    //check format 
    const isAlphabet = /[a-zA-Z]/.test(password);
    const isDigit = /\d/.test(password);
    const isSpecial = /[!@#$%^&*(),.?":{}|<>]/.test(password);

    //validation
    if (isEmpty === true) {
        errors.push("Password is required");
    } else if (password.length < 8) {
        errors.push("Password should be at least 8 characters long \n");
    } else if (!isAlphabet || !isDigit || !isSpecial) {
        errors.push("Password should contain at least 1 letter, 1 number and 1 special character");
    }


    //display error if error message is not empty
    if (errors.length > 0) {
        passwordOutline.classList.remove("mb-3");
        passwordOutline.classList.add("mb-5");
        passwordFeedback.textContent = errors.join("\n"); // join errors with a line break
        passwordInput.classList.remove("is-valid");
        passwordInput.classList.add("is-invalid");
        passwordFeedback.classList.add("invalid-feedback");
    } else {
        passwordOutline.classList.remove("mb-5");
        passwordOutline.classList.add("mb-3");
        passwordFeedback.textContent = "";
        passwordInput.classList.remove("is-invalid");
        passwordInput.classList.add("is-valid");
        passwordFeedback.classList.add("valid-feedback");
    }

});
//password validation end here



//confirm password validation start here
const confirmPwdInput = document.getElementById("confirmPassword");
const confirmPwdFeedback = document.getElementById("confirmPwdFeedback");
const confirmPwdOutline = document.getElementById("cpwdOutline");

confirmPwdInput.addEventListener('input', () => {
    const confirmPwd = confirmPwdInput.value.trim();
    const password = passwordInput.value.trim();
    var errors = [];
    const isEmpty = isInputEmpty(confirmPwd);

    //validations
    if (isEmpty === true) {
        errors.push("Field cannot be empty!");
    } else if (password !== confirmPwd) {
        errors.push("Password is not same, please re-enter!");
    }

    if (errors.length > 0) {
        confirmPwdOutline.classList.remove("mb-3");
        confirmPwdOutline.classList.add("mb-5");
        confirmPwdFeedback.textContent = errors.join("\n"); // join errors with a line break
        confirmPwdInput.classList.remove("is-valid");
        confirmPwdInput.classList.add("is-invalid");
        confirmPwdFeedback.classList.add("invalid-feedback");
    } else {
        confirmPwdOutline.classList.remove("mb-5");
        confirmPwdOutline.classList.add("mb-3");
        confirmPwdFeedback.textContent = "";
        confirmPwdInput.classList.remove("is-invalid");
        confirmPwdInput.classList.add("is-valid");
        confirmPwdFeedback.classList.add("valid-feedback");
    }

});
//confirm password validation end here

const registerBtn = document.getElementById("registerBtn");

//registerBtn.addEventListener("click", function () {
//    const isValidUsername = usernameInput.classList.contains('is-valid');
//    const isValidEmail = emailInput.classList.contains('is-valid');
//    const isValidPassword = passwordInput.classList.contains('is-valid');
//    const isValidConfirmPwd = confirmPwdInput.classList.contains('is-valid');
//
//    if (isValidUsername && isValidEmail && isValidPassword && isValidConfirmPwd) {
//        alert("NIAO");
//    }
//});

