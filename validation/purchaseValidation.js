//variables
const quantity = document.getElementById('purchaseQty');
const submit = document.getElementById('submitPayment');
const feedback = document.getElementById('qtyFeedback');

submit.addEventListener('click', function () {
    const qtyValue = quantity.value.toString().trim();

    if (qtyValue === "") {
        feedback.textContent = "You need to select at least one ticket";
        quantity.classList.add('is-invalid');
        quantity.classList.remove('is-valid');
        feedback.classList.add('invalid-feedback');
    } else if (qtyValue <= 0) {
        feedback.textContent = "Please enter a logical value";
        quantity.classList.add('is-invalid');
        quantity.classList.remove('is-valid');
        feedback.classList.add('invalid-feedback');
    } else if (qtyValue > 5) {
        feedback.textContent = "1 person can purchase up to 5 tickets";
        quantity.classList.add('is-invalid');
        quantity.classList.remove('is-valid');
        feedback.classList.add('invalid-feedback');
    } else 
        if (qtyValue > quantityLeft) {
        if (quantityLeft === 1) {
            feedback.textContent = "Only " + quantityLeft + " ticket left!";
        } else {
            feedback.textContent = "Only " + quantityLeft + " tickets left!";
        }
        quantity.classList.add('is-invalid');
        quantity.classList.remove('is-valid');
        feedback.classList.add('invalid-feedback');
    } else {
        feedback.textContent = "";
        quantity.classList.add('is-valid');
        quantity.classList.remove('is-invalid');
        feedback.classList.add('valid-feedback');
    }
});

