//Global functions
function isInputEmpty(input) {
    var isEmpty = false;
    if (input === "") {
        isEmpty = true;
    }
    return isEmpty;
}
//Global functions end here 


//Username validation start here
const usernameInput = document.getElementById('username');
const usernameFeedback = document.getElementById('usernameFeedback');
const button = document.getElementById("saveBtn");


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
        button.disabled = true;
    } else {
        usernameFeedback.textContent = '';
        usernameInput.classList.remove('is-invalid');
        usernameInput.classList.add('is-valid');
        usernameFeedback.classList.add('invalid-feedback');
        button.disabled = false;
    }
});

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
        button.disabled = true;
    } else {
        emailfeedback.textContent = '';
        emailInput.classList.remove('is-invalid');
        emailInput.classList.add('is-valid');
        emailfeedback.classList.add('valid-feedback');
        button.disabled = false;
    }

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
        button.disabled = true;
    } else {
        phoneFeedback.textContent = '';
        phoneInput.classList.remove('is-invalid');
        phoneInput.classList.add('is-valid');
        phoneFeedback.classList.add('valid-feedback');
        button.disabled = false;
    }

});
//Phone validation end here 


