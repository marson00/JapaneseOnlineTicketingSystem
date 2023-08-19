//Global functions
function isInputEmpty(input) {
    var isEmpty = false;
    if (input === "") {
        isEmpty = true;
    }
    return isEmpty;
}
//Global functions end here 


//inputs
const mCardNumInput = document.getElementById('cardNumM');
const mCardNameInput = document.getElementById('cardNameM');
const mCardMonthInput = document.getElementById('cardExpMonthM');
const mCardYearInput = document.getElementById('cardExpYearM');
const mCardCvvInput = document.getElementById('cardCvvM');
const mSubmit = document.getElementById('confirmPaymentM');

//feedbacks 
const mCardNumFeedback = document.getElementById('cardNumMFeedback');
const mCardNameFeedback = document.getElementById('cardNameMFeedback');
const mCardMonthFeedback = document.getElementById('mCardMonthFeedback');
const mCardYearFeedback = document.getElementById('mCardYearFeedback');
const mCardCvvFeedback = document.getElementById('mCardCvvFeedback');

mCardNumInput.addEventListener('input', () => {
    const cardNumValue = mCardNumInput.value.toString().trim();
    const isEmpty = isInputEmpty(cardNumValue);
    const isDigitAndSpace = /^[\d\s]+$/.test(cardNumValue);
    //first digit must equals 4
    //total must have 16 digits
    //replace space with flag g before run regular expression
    const isVisaCard = /^5\d{15}$/.test(cardNumValue.replace(/\s/g, ''));
    var errors = [];

    if (isEmpty === true) {
        errors.push("Please enter your card number!");
    } else if (isDigitAndSpace === false) {
        errors.push("Only allow for digit!");
    } else if (isVisaCard === false) {
        errors.push("Invalid Master Card Format!");
    }

    if (errors.length > 0) {
        mCardNumFeedback.textContent = errors;
        mCardNumInput.classList.remove('is-valid');
        mCardNumInput.classList.add('is-invalid');
        mCardNumFeedback.classList.add('invalid-feedback');
    } else {
        mCardNumFeedback.textContent = "";
        mCardNumInput.classList.remove('is-invalid');
        mCardNumInput.classList.add('is-valid');
        mCardNumFeedback.classList.add('valid-feedback');
    }
    checkMasterFormValidity();
});

mCardNameInput.addEventListener('input', () => {
    const cardNameValue = mCardNameInput.value.toString().trim();
    const isEmpty = isInputEmpty(cardNameValue);
    const isLetterAndSpace = /^[a-zA-Z\s]+$/.test(cardNameValue);
    var errors = [];

    if (isEmpty === true) {
        errors.push("Please enter your card number!");
    } else if (isLetterAndSpace === false) {
        errors.push("Only allow letters and space");
    }

    if (errors.length > 0) {
        mCardNameFeedback.textContent = errors;
        mCardNameInput.classList.remove('is-valid');
        mCardNameInput.classList.add('is-invalid');
        mCardNameFeedback.classList.add('invalid-feedback');
    } else {
        mCardNameFeedback.textContent = "";
        mCardNameInput.classList.remove('is-invalid');
        mCardNameInput.classList.add('is-valid');
        mCardNameFeedback.classList.add('valid-feedback');
    }
    checkMasterFormValidity();
});

mCardYearInput.addEventListener('input', () => {
    const cardYearValue = mCardYearInput.value.toString().trim();
    const cardMonthValue = mCardMonthInput.value.toString().trim();
    const isEmpty = isInputEmpty(cardYearValue);
    const isDigit = /^[\d]+$/.test(cardYearValue);

    const currentYear = new Date().getFullYear().toString(); // get current year
    const currentMonth = new Date().getMonth() + 1;
    const currentMonthFormatted = currentMonth.toLocaleString('en-US', {minimumIntegerDigits: 2, useGrouping: false});
    var errors = [];

    if (isEmpty === true) {
        errors.push("Please enter your card expired year");
    } else if (isDigit === false) {
        errors.push("Please enter digit only");
    } else if (cardYearValue < currentYear) {
        errors.push("Invalid expired year");
    }


    if (errors.length > 0) {
        mCardYearFeedback.textContent = errors;
        mCardYearInput.classList.remove('is-valid');
        mCardYearInput.classList.add('is-invalid');
        mCardYearFeedback.classList.add('invalid-feedback');
        mCardMonthInput.disabled = true;
    } else {
        mCardYearFeedback.textContent = "";
        mCardYearInput.classList.remove('is-invalid');
        mCardYearInput.classList.add('is-valid');
        mCardYearFeedback.classList.add('valid-feedback');
        mCardMonthInput.disabled = false;
    }
    checkMasterFormValidity();
});

mCardMonthInput.addEventListener('input', () => {
    const cardMonthValue = mCardMonthInput.value.toString().trim();
    const cardYearValue = mCardYearInput.value.toString().trim();
    const isEmpty = isInputEmpty(cardMonthValue);
    const isDigit = /^[\d]+$/.test(cardMonthValue);
    //ensure got 2 digits
    const monthRegex = /^\d{2}$/.test(cardMonthValue);

    //current year and month
    const currentYear = new Date().getFullYear().toString(); // get current year
    const currentMonth = new Date().getMonth() + 1;
    const currentMonthFormatted = currentMonth.toLocaleString('en-US', {minimumIntegerDigits: 2, useGrouping: false});
    var errors = [];

    if (isEmpty === true) {
        errors.push("Please enter your card expired month");
    } else if (isDigit === false) {
        errors.push("Please enter digit only!");
    } else if (monthRegex === false) {
        errors.push("Please enter a logical value");
    } else if (cardYearValue === currentYear && cardMonthValue < currentMonthFormatted) {
        errors.push("The value cannot before current time!");
    }


    if (errors.length > 0) {
        mCardMonthFeedback.textContent = errors;
        mCardMonthInput.classList.remove('is-valid');
        mCardMonthInput.classList.add('is-invalid');
        mCardMonthFeedback.classList.add('invalid-feedback');
    } else {
        mCardMonthFeedback.textContent = "";
        mCardMonthInput.classList.remove('is-invalid');
        mCardMonthInput.classList.add('is-valid');
        mCardMonthFeedback.classList.add('valid-feedback');
    }
    checkMasterFormValidity();
});



mCardCvvInput.addEventListener('input', () => {
    const cardCvvValue = mCardCvvInput.value.toString().trim();
    const isEmpty = isInputEmpty(cardCvvValue);
    const isDigit = /^\d+$/.test(cardCvvValue);
    var errors = [];

    // Check if CVV is not empty and only contains digits
    if (isEmpty === true) {
        errors.push("Please enter your cvv number!");
    } else if (isDigit === false) {
        errors.push("Only accept digits");
    }

    if (errors.length > 0) {
        mCardCvvFeedback.textContent = errors;
        mCardCvvInput.classList.remove('is-valid');
        mCardCvvInput.classList.add('is-invalid');
        mCardCvvFeedback.classList.add('invalid-feedback');
    } else {
        mCardCvvFeedback.textContent = "";
        mCardCvvInput.classList.remove('is-invalid');
        mCardCvvInput.classList.add('is-valid');
        mCardCvvFeedback.classList.add('valid-feedback');
    }
    checkMasterFormValidity();
});

//const mCardNumInput = document.getElementById('cardNumM');
//const mCardNameInput = document.getElementById('cardNameM');
//const mCardMonthInput = document.getElementById('cardExpMonthM');
//const mCardYearInput = document.getElementById('cardExpYearM');
//const mCardCvvInput = document.getElementById('cardCvvM');
//const mSubmit = document.getElementById('confirmPaymentM');

function checkMasterFormValidity() {
    const isValidCardNum = mCardNumInput.classList.contains('is-valid');
    const isValidCardName = mCardNameInput.classList.contains('is-valid');
    const isValidCardMonth = mCardMonthInput.classList.contains('is-valid');
    const isValidCardYear = mCardYearInput.classList.contains('is-valid');
    const isValidCvv = mCardCvvInput.classList.contains('is-valid');
    
    // enable submit button if all input fields are valid
    if (isValidCardNum && isValidCardName && isValidCardMonth && isValidCardYear && isValidCvv) {
        mSubmit.disabled = false;
    } else {
        mSubmit.disabled = true;
    }
}