$(document).ready({

});

//Global functions
function isInputEmpty(input) {
    var isEmpty = false;
    if (input === "") {
        isEmpty = true;
    }
    return isEmpty;
}
//Global functions end here 


//event name validation
const eventNameInput = document.getElementById("eventName");
const eventNameFeedback = document.getElementById("eventNameFeedback");



eventNameInput.addEventListener('input', () => {
    eventName = eventNameInput.value.trim();
    var errors = [];

    const onlyLetter = /^[a-zA-Z]+$/.test(eventName);
    const isEmpty = isInputEmpty(eventName);

    if (isEmpty === true) {
        errors.push("Please enter an event name!");
    }

    if (errors.length > 0) {
        eventNameFeedback.textContent = errors;
        eventNameInput.classList.remove("is-valid");
        eventNameInput.classList.add("is-invalid");
        eventNameFeedback.classList.add("invalid-feedback");
    } else {
        eventNameFeedback.textContent = "";
        eventNameInput.classList.remove("is-invalid");
        eventNameInput.classList.add("is-valid");
        eventNameFeedback.classList.add("valid-feedback");
    }
    checkEventFormValidity();
});


//Location validations
const locationInput = document.getElementById("location");
const locationFeedback = document.getElementById("locationFeedback");

locationInput.addEventListener('input', () => {
    const location = locationInput.value.trim();
    var errors = [];

    const isEmpty = isInputEmpty(location);

    if (isEmpty === true) {
        errors.push("Please enter a location!");
    }

    if (errors.length > 0) {
        locationFeedback.textContent = errors;
        locationInput.classList.remove("is-valid");
        locationInput.classList.add("is-invalid");
        locationFeedback.classList.add("invalid-feedback");
    } else {
        locationFeedback.textContent = "";
        locationInput.classList.remove("is-invalid");
        locationInput.classList.add("is-valid");
        locationFeedback.classList.add("valid-feedback");
    }
    checkEventFormValidity();
});


//Image validation
const eventImgInput = document.getElementById("eventImg");
const eventImgFeedback = document.getElementById("eventImgFeedback");

eventImgInput.addEventListener('input', () => {
    eventImg = eventImgInput.value.trim();
    eventImgType = eventImgInput.files[0];
    var errors = [];

    const isEmpty = isInputEmpty(eventImg);
    const fileType = eventImgType.type;

    if (!eventImg) {
        errors.push("Please upload an event image!");
    }

    if (fileType !== "image/jpeg" && fileType !== "image/png") {
        errors.push("Please upload a JPEG or PNG image!");
    }

    if (errors.length > 0) {
        eventImgFeedback.textContent = errors;
        eventImgInput.classList.remove("is-valid");
        eventImgInput.classList.add("is-invalid");
        eventImgFeedback.classList.add("invalid-feedback");
    } else {
        eventImgFeedback.textContent = "";
        eventImgInput.classList.remove("is-invalid");
        eventImgInput.classList.add("is-valid");
        eventImgFeedback.classList.add("valid-feedback");
    }
    checkEventFormValidity();
});


//description validation
const descriptionInput = document.getElementById("eventDsc");
const descriptionFeedback = document.getElementById("eventDscFeedback");

descriptionInput.addEventListener('input', () => {
    const description = descriptionInput.value.trim();
    var errors = [];

    const isEmpty = isInputEmpty(description);

    if (isEmpty === true) {
        errors.push("Please enter an event description");
    }

    if (errors.length > 0) {
        descriptionFeedback.textContent = errors;
        descriptionInput.classList.remove("is-valid");
        descriptionInput.classList.add("is-invalid");
        descriptionFeedback.classList.add("invalid-feedback");
    } else {
        descriptionFeedback.textContent = "";
        descriptionInput.classList.remove("is-invalid");
        descriptionInput.classList.add("is-valid");
        descriptionFeedback.classList.add("valid-feedback");
    }
    checkEventFormValidity();
});

//category validation
const categoryInput = document.getElementById("category");
const categoryFeedback = document.getElementById("categoryFeedback");

categoryInput.addEventListener('input', () => {
    const category = categoryInput.value.trim();
    var errors = [];

    const isEmpty = isInputEmpty(category);

    if (isEmpty === true) {
        errors.push("Please select a category!");
    }


    if (errors.length > 0) {
        categoryFeedback.textContent = errors;
        categoryInput.classList.remove("is-valid");
        categoryInput.classList.add("is-invalid");
        categoryFeedback.classList.add("invalid-feedback");
    } else {
        categoryFeedback.textContent = "";
        categoryInput.classList.remove("is-invalid");
        categoryInput.classList.add("is-valid");
        categoryFeedback.classList.add("valid-feedback");
    }
    checkEventFormValidity();
});


//Start date validation
$('#eventStartDate').on('input', function () {
    var selectedDate = $(this).val();
    var errors = [];
    const eventStartDateInput = document.getElementById("eventStartDate");
    const eventStartDateFeedback = document.getElementById("eventStartDateFeedback");
    const eventStartDate = eventStartDateInput.value.trim();

    // Create a new Date object for the selected date
    var selectedDateTime = new Date(selectedDate).getTime();

    // Create a new Date object for the current date and time
    var currentDateTime = new Date().getTime();

    // Add 7 days in milliseconds to the current date and time
    var minDateTime = currentDateTime + (6 * 24 * 60 * 60 * 1000);

    if (selectedDate === "") {
        errors.push("Please select a date!");
    }
    if (selectedDateTime < currentDateTime) {
        errors.push("Please enter a logical date value");
    }
    if (!(selectedDateTime < currentDateTime)) {
        if (selectedDateTime < minDateTime) {
            errors.push("Selected date must be 1 week after current time.");
        }
    }

    if (errors.length > 0) {
        eventStartDateFeedback.textContent = errors;
        eventStartDateInput.classList.remove("is-valid");
        eventStartDateInput.classList.add("is-invalid");
        eventStartDateFeedback.classList.add("invalid-feedback");
    } else {
        eventStartDateFeedback.textContent = "";
        eventStartDateInput.classList.remove("is-invalid");
        eventStartDateInput.classList.add("is-valid");
        eventStartDateFeedback.classList.add("valid-feedback");
    }
    checkEventFormValidity();
});


//End date validation
$('#eventEndDate').on('input', function () {
    var selectedDate = $(this).val();
    var errors = [];
    const eventStartDateInput = document.getElementById("eventStartDate");
    const eventStartDate = new Date(eventStartDateInput.value.trim()).getTime()
    const eventEndDateInput = document.getElementById("eventEndDate");
    const eventEndDateFeedback = document.getElementById("eventEndDateFeedback");
    const eventEndDate = eventEndDateInput.value.trim();


    // Create a new Date object for the selected date
    var selectedDateTime = new Date(selectedDate).getTime();

    if (eventEndDate === "") {
        errors.push("Please select a date!");
    }
    if (selectedDateTime < eventStartDate) {
        errors.push("The event end date must be the same as or after the event start date.");
    }

    if (errors.length > 0) {
        eventEndDateFeedback.textContent = errors;
        eventEndDateInput.classList.remove("is-valid");
        eventEndDateInput.classList.add("is-invalid");
        eventEndDateFeedback.classList.add("invalid-feedback");
    } else {
        eventEndDateFeedback.textContent = "";
        eventEndDateInput.classList.remove("is-invalid");
        eventEndDateInput.classList.add("is-valid");
        eventEndDateFeedback.classList.remove("valid-feedback");
    }
    checkEventFormValidity();
});



//capacity validation
const capacityInput = document.getElementById("capacity");
const capacityFeedback = document.getElementById("capacityFeedback");

capacityInput.addEventListener('input', () => {
    const capacity = capacityInput.value.trim();
    var errors = [];

    const isEmpty = isInputEmpty(capacity);

    if (isEmpty) {
        errors.push("Please enter a capacity!");
    }
    if (!isEmpty) {
        if (capacity < 10) {
            errors.push("Capacity cannot less than 10!");
        }
        if (capacity <= 0) {
            errors.push("Please enter a logical value!");
        }
    }


    if (errors.length > 0) {
        capacityFeedback.textContent = errors;
        capacityInput.classList.remove("is-valid");
        capacityInput.classList.add("is-invalid");
        capacityFeedback.classList.add("invalid-feedback");
    } else {
        capacityFeedback.textContent = "";
        capacityInput.classList.remove("is-invalid");
        capacityInput.classList.add("is-valid");
        capacityFeedback.classList.add("valid-feedback");
    }
    checkEventFormValidity();
});


//Price validation
const priceInput = document.getElementById("price");
const priceFeedback = document.getElementById("priceFeedback");

priceInput.addEventListener('input', () => {
    price = priceInput.value.trim();
    var errors = [];

    const isEmpty = isInputEmpty(price);

    if (isEmpty) {
        errors.push("Please enter a price!");
    }

    if (!isEmpty) {
        if (price < 5) {
            errors.push("Minimum price must be RM5");
        }

        if (price <= 0) {
            errors.push("Please enter a logical price value!");
        }
    }

    if (errors.length > 0) {
        priceFeedback.textContent = errors;
        priceInput.classList.remove("is-valid");
        priceInput.classList.add("is-invalid");
        priceFeedback.classList.add("invalid-feedback");
    } else {
        priceFeedback.textContent = "";
        priceInput.classList.remove("is-invalid");
        priceInput.classList.add("is-valid");
        priceFeedback.classList.add("valid-feedback");
    }
    checkEventFormValidity();
});


//status validation
//because of unknown reason this thing won't run
const statusInput = document.getElementById("status");
const statusFeedback = document.getElementById("statusFeedback");

statusInput.addEventListener('input', () => {
    const status = statusInput.value.trim();
    var errors = [];

    const isEmpty = isInputEmpty(status);

    if (isEmpty) {
        errors.push("Please select a status!");
    }


    if (errors.length > 0) {
        statusFeedback.textContent = errors;
        statusInput.classList.remove("is-valid");
        statusInput.classList.add("is-invalid");
        statusFeedback.classList.add("invalid-feedback");
    } else {
        statusFeedback.textContent = "";
        statusInput.classList.remove("is-invalid");
        statusInput.classList.add("is-valid");
        statusFeedback.classList.add("valid-feedback");
    }
    checkEventFormValidity();
});


//form validation
const eventStartDateInput = document.getElementById("eventStartDate");
const eventEndDateInput = document.getElementById("eventEndDate");
const addBtn = document.getElementById("addEvent");
addBtn.disabled = true;

function checkEventFormValidity() {
    const isValidEventName = eventNameInput.classList.contains("is-valid");
    const isValidLocation = locationInput.classList.contains("is-valid");
    const isValidImg = eventImgInput.classList.contains("is-valid");
    const isValidDsc = descriptionInput.classList.contains("is-valid");
    const isValidCat = categoryInput.classList.contains("is-valid");
    const isValidStrtDate = eventStartDateInput.classList.contains("is-valid");
    const isValidEndDate = eventEndDateInput.classList.contains("is-valid");
    const isValidCapacity = capacityInput.classList.contains("is-valid");
    const isValidPrice = priceInput.classList.contains("is-valid");

    if (isValidEventName && isValidLocation && isValidImg && isValidDsc
            && isValidCat && isValidStrtDate && isValidEndDate
            && isValidCapacity && isValidPrice) {
        addBtn.disabled = false;
    } else {
        addBtn.disabled = true;
    }
}

