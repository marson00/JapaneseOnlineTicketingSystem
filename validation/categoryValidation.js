//category 
const categoryTitleInput = document.getElementById("categoryTitle");
const categoryTitleFeedback = document.getElementById("categoryTitleFeedback");
const addBtn = document.getElementById("addCategory");
addBtn.disabled = true;

categoryTitleInput.addEventListener('input', () => {
    categoryTitle = categoryTitleInput.value.trim();
    var errors = [];

    if (categoryTitle === "") {
        errors.push("Please enter a category title!");
    }

    if (errors.length > 0) {
        categoryTitleFeedback.textContent = errors;
        categoryTitleInput.classList.remove("is-valid");
        categoryTitleInput.classList.add("is-invalid");
        categoryTitleFeedback.classList.add("invalid-feedback");
        addBtn.disabled = false;
    }else{
        categoryTitleFeedback.textContent = "";
        categoryTitleInput.classList.remove("is-invalid");
        categoryTitleInput.classList.add("is-valid");
        categoryTitleFeedback.classList.add("valid-feedback");
        addBtn.disabled = false;
    }
});



