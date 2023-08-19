//Global functions
function isInputEmpty(input) {
    var isEmpty = false;
    if (input === "") {
        isEmpty = true;
    }
    return isEmpty;
}
//Global functions end here 


/*       User information validation start here            */
//Username validation start here
const usernameInput = document.getElementById('username');
const usernameFeedback = document.getElementById('usernameFeedback');


usernameInput.addEventListener('input', () => {
    //variables and array
    const username = usernameInput.value.trim();
    var errors = [];

    //format checking
    const isAlphabet = /[a-zA-Z]/.test(username);
    const isDigit = /\d/.test(username);
    const isEmpty = isInputEmpty(username);


    //validations
    if (isEmpty === true) {
        errors.push("User name is required")
    } else if (username.length < 6) {
        errors.push("User name must be at least 6 characters long");
    } else if (!isAlphabet || !isDigit) {
        errors.push("Username should contain at least 1 letter and 1 number")
    }

    //display error if the error message is not empty
    if (errors.length > 0) {
        usernameFeedback.textContent = errors;
        usernameInput.classList.remove('is-valid');
        usernameInput.classList.add('is-invalid');
        usernameFeedback.classList.add('invalid-feedback');
    } else {
        usernameFeedback.textContent = '';
        usernameInput.classList.remove('is-invalid');
        usernameInput.classList.add('is-valid');
        usernameFeedback.classList.add('invalid-feedback');
    }
    checkFormValidity();

});
//Username validation end here


//Email validation end here
const emailInput = document.getElementById('email');
const emailfeedback = document.getElementById('emailFeedback');

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
        emailfeedback.textContent = errors;
        emailInput.classList.remove('is-valid');
        emailInput.classList.add('is-invalid');
        emailfeedback.classList.add('invalid-feedback');
    } else {
        emailfeedback.textContent = '';
        emailInput.classList.remove('is-invalid');
        emailInput.classList.add('is-valid');
        emailfeedback.classList.add('valid-feedback');
    }
    checkUserFormValidity();

});
//Email validation end here


//Phone validation start here
const phoneInput = document.getElementById("phone");
const phoneFeedback = document.getElementById("phoneFeedback");

phoneInput.addEventListener('input', () => {
    const phone = phoneInput.value.trim();
    var errors = [];

    const isEmpty = isInputEmpty(phone);
    var myrPhoneFormat = /^(\+?6?01)[0-46-9]-*[0-9]{7,8}$/.test(phone);

    if (isEmpty === true) {
        errors.push("Phone number is required'")
    } else if (!myrPhoneFormat) {
        errors.push("Phone format is invalid")
    }

    if (errors.length > 0) {
        phoneFeedback.textContent = errors;
        phoneInput.classList.remove('is-valid');
        phoneInput.classList.add('is-invalid');
        phoneFeedback.classList.add('invalid-feedback');
    } else {
        phoneFeedback.textContent = '';
        phoneInput.classList.remove('is-invalid');
        phoneInput.classList.add('is-valid');
        phoneFeedback.classList.add('valid-feedback');
    }
    checkUserFormValidity();

});
//Phone validation end here 


//password validation start here
const passwordInput = document.getElementById("password");
const passwordFeedback = document.getElementById("passwordFeedback");

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
        passwordFeedback.textContent = errors.join("\n"); // join errors with a line break
        passwordInput.classList.remove("is-valid");
        passwordInput.classList.add("is-invalid");
        passwordFeedback.classList.add("invalid-feedback");
    } else {
        passwordFeedback.textContent = "";
        passwordInput.classList.remove("is-invalid");
        passwordInput.classList.add("is-valid");
        passwordFeedback.classList.add("valid-feedback");
    }
    checkUserFormValidity();

});
//password validation end here



//confirm password validation start here
const confirmPwdInput = document.getElementById("confirmPassword");
const confirmPwdFeedback = document.getElementById("confirmPasswordFeedback");

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
        confirmPwdFeedback.textContent = errors.join("\n"); // join errors with a line break
        confirmPwdInput.classList.remove("is-valid");
        confirmPwdInput.classList.add("is-invalid");
        confirmPwdFeedback.classList.add("invalid-feedback");
    } else {
        confirmPwdFeedback.textContent = "";
        confirmPwdInput.classList.remove("is-invalid");
        confirmPwdInput.classList.add("is-valid");
        confirmPwdFeedback.classList.add("valid-feedback");
    }
    checkUserFormValidity();

});
//confirm password validation end here

const roleSelect = document.getElementById("role");
const roleSelectFeedback = document.getElementById("roleFeedback");

// Adminside -> add user -> role selection list validation start here
roleSelect.addEventListener('input', () => {
    role = roleSelect.value.trim();
    var errors = [];

    if (isInputEmpty(role)) {
        errors.push("Please select a role!");
    }
    if (errors.length > 0) {
        roleSelectFeedback.textContent = errors.join("\n"); // join errors with a line break
        roleSelect.classList.remove("is-valid");
        roleSelect.classList.add("is-invalid");
        roleSelectFeedback.classList.add("invalid-feedback");
    } else {
        roleSelectFeedback.textContent = "";
        roleSelect.classList.remove("is-invalid");
        roleSelect.classList.add("is-valid");
        roleSelectFeedback.classList.add("valid-feedback");
    }
    checkUserFormValidity();

});
//role selection list validation end here
/*       User information validation end here            */



//Admin side -> user adding form validity
const addBtn = document.getElementById("addUser");

function checkUserFormValidity() {
    const isValidUsername = usernameInput.classList.contains('is-valid');
    const isValidEmail = emailInput.classList.contains('is-valid');
    const isValidPhone = phoneInput.classList.contains('is-valid');
    const isValidPassword = passwordInput.classList.contains('is-valid');
    const isValidConfirmPwd = confirmPwdInput.classList.contains('is-valid');
    const isValidRole = roleSelect.classList.contains('is-valid');

    // enable submit button if all input fields are valid
    if (isValidUsername && isValidEmail && isValidPhone && isValidPassword && isValidConfirmPwd && isValidRole) {
        addBtn.disabled = false;
    } else {
        addBtn.disabled = true;
    }
}



