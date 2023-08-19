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
const vCardNumInput = document.getElementById('cardNumV');
const vCardNameInput = document.getElementById('cardNameV');
const vCardMonthInput = document.getElementById('cardExpMonthV');
const vCardYearInput = document.getElementById('cardExpYearV');
const vCardCvvInput = document.getElementById('cardCvvV');
const vSubmit = document.getElementById("confirmPaymentV");

//feedbacks 
const vCardNumFeedback = document.getElementById('cardNumVFeedback');
const vCardNameFeedback = document.getElementById('cardNameVFeedback');
const vCardMonthFeedback = document.getElementById('cardMonthVFeedback');
const vCardYearFeedback = document.getElementById('cardYearVFeedback');
const vCardCvvFeedback = document.getElementById('cvvVFeedback');

//validate card number
vCardNumInput.addEventListener('input', () => {
    const cardNumValue = vCardNumInput.value.toString().trim();
    const isEmpty = isInputEmpty(cardNumValue);
    const isDigitAndSpace = /^[\d\s]+$/.test(cardNumValue);
    //first digit must equals 4
    //total must have 16 digits
    //replace space with flag g before run regular expression
    const isVisaCard = /^4\d{15}$/.test(cardNumValue.replace(/\s/g, ''));
    var errors = [];

    if (isEmpty === true) {
        errors.push("Please enter your card number!");
    } else if (isDigitAndSpace === false) {
        errors.push("Only allow for digit!");
    } else if (isVisaCard === false) {
        errors.push("Invalid Visa Card Format!");
    }

    if (errors.length > 0) {
        vCardNumFeedback.textContent = errors;
        vCardNumInput.classList.remove('is-valid');
        vCardNumInput.classList.add('is-invalid');
        vCardNumFeedback.classList.add('invalid-feedback');
    } else {
        vCardNumFeedback.textContent = "";
        vCardNumInput.classList.remove('is-invalid');
        vCardNumInput.classList.add('is-valid');
        vCardNumFeedback.classList.add('valid-feedback');
    }
    checkVisaFormValidity();
});

//validate card name
vCardNameInput.addEventListener('input', () => {
    const cardNameValue = vCardNameInput.value.toString().trim();
    const isEmpty = isInputEmpty(cardNameValue);
    const isLetterAndSpace = /^[a-zA-Z\s]+$/.test(cardNameValue);
    var errors = [];

    if (isEmpty === true) {
        errors.push("Please enter your card number!");
    } else if (isLetterAndSpace === false) {
        errors.push("Only allow letters and space");
    }

    if (errors.length > 0) {
        vCardNameFeedback.textContent = errors;
        vCardNameInput.classList.remove('is-valid');
        vCardNameInput.classList.add('is-invalid');
        vCardNameFeedback.classList.add('invalid-feedback');
    } else {
        vCardNameFeedback.textContent = "";
        vCardNameInput.classList.remove('is-invalid');
        vCardNameInput.classList.add('is-valid');
        vCardNameFeedback.classList.add('valid-feedback');
    }
    checkVisaFormValidity();
});

//validate card year
vCardYearInput.addEventListener('input', () => {
    const cardYearValue = vCardYearInput.value.toString().trim();
    const cardMonthValue = vCardMonthInput.value.toString().trim();
    const isEmpty = isInputEmpty(cardYearValue);
    const isDigit = /^[\d]+$/.test(cardYearValue);

    const currentYear = new Date().getFullYear().toString(); // get current year
    const currentMonth = new Date().getMonth() + 1;
    const currentMonthFormatted = currentMonth.toLocaleString('en-US', {minimumIntegerDigits: 2, useGrouping: false});
    var errors = [];
    
    if(isEmpty === true){
        errors.push("Please enter your card expired year");
    }else if(isDigit === false){
        errors.push("Please enter digit only");
    }else if(cardYearValue < currentYear){
        errors.push("Invalid expired year");
    }


    if (errors.length > 0) {
        vCardYearFeedback.textContent = errors;
        vCardYearInput.classList.remove('is-valid');
        vCardYearInput.classList.add('is-invalid');
        vCardYearFeedback.classList.add('invalid-feedback');
        vCardMonthInput.disabled = true;
    } else {
        vCardYearFeedback.textContent = "";
        vCardYearInput.classList.remove('is-invalid');
        vCardYearInput.classList.add('is-valid');
        vCardYearFeedback.classList.add('valid-feedback');
        vCardMonthInput.disabled = false;
    }
    checkVisaFormValidity();
});

//validate card month
vCardMonthInput.addEventListener('input', () => {
    const cardMonthValue = vCardMonthInput.value.toString().trim();
    const cardYearValue = vCardYearInput.value.toString().trim();
    const isEmpty = isInputEmpty(cardMonthValue);
    const isDigit = /^[\d]+$/.test(cardMonthValue);
    //ensure got 2 digits
    const monthRegex = /^(0[1-9]|1[0-2])$/.test(cardMonthValue);

    //current year and month
    const currentYear = new Date().getFullYear().toString(); // get current year
    const currentMonth = new Date().getMonth() + 1;
    const currentMonthFormatted = currentMonth.toLocaleString('en-US', {minimumIntegerDigits: 2, useGrouping: false});
    var errors = [];
    
    if(isEmpty === true){
        errors.push("Please enter your card expired month");
    }else if(isDigit === false){
        errors.push("Please enter digit only!");
    }else if(monthRegex === false){
        errors.push("Please enter a logical value");
    }else if(cardYearValue === currentYear && cardMonthValue < currentMonthFormatted){
        errors.push("The value cannot before current time!");
    }


    if (errors.length > 0) {
        vCardMonthFeedback.textContent = errors;
        vCardMonthInput.classList.remove('is-valid');
        vCardMonthInput.classList.add('is-invalid');
        vCardMonthFeedback.classList.add('invalid-feedback');
    } else {
        vCardMonthFeedback.textContent = "";
        vCardMonthInput.classList.remove('is-invalid');
        vCardMonthInput.classList.add('is-valid');
        vCardMonthFeedback.classList.add('valid-feedback');
    }
    checkVisaFormValidity();
});

//validate card cvv
vCardCvvInput.addEventListener('input', () => {
    const cardCvvValue = vCardCvvInput.value.toString().trim();
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
        vCardCvvFeedback.textContent = errors;
        vCardCvvInput.classList.remove('is-valid');
        vCardCvvInput.classList.add('is-invalid');
        vCardCvvFeedback.classList.add('invalid-feedback');
    } else {
        vCardCvvFeedback.textContent = "";
        vCardCvvInput.classList.remove('is-invalid');
        vCardCvvInput.classList.add('is-valid');
        vCardCvvFeedback.classList.add('valid-feedback');
    }

    checkVisaFormValidity();
});

//const vCardNumInput = document.getElementById('cardNumV');
//const vCardNameInput = document.getElementById('cardNameV');
//const vCardMonthInput = document.getElementById('cardExpMonthV');
//const vCardYearInput = document.getElementById('cardExpYearV');
//const vCardCvvInput = document.getElementById('cardCvvV');
//const vSubmit = document.getElementById("confirmPaymentV");

function checkVisaFormValidity() {
    const isValidCardNum = vCardNumInput.classList.contains('is-valid');
    const isValidCardName = vCardNameInput.classList.contains('is-valid');
    const isValidCardMonth = vCardMonthInput.classList.contains('is-valid');
    const isValidCardYear = vCardYearInput.classList.contains('is-valid');
    const isValidCvv = vCardCvvInput.classList.contains('is-valid');
    // enable submit button if all input fields are valid
    if (isValidCardNum && isValidCardName && isValidCardMonth && isValidCardYear && isValidCvv) {
        vSubmit.disabled = false;
    } else {
        vSubmit.disabled = true;
    }
}