//role title validation
const roleTitleInput = document.getElementById("roleTitle");
const roleTitleFeedback = document.getElementById("roleTitleFeedback");
const addBtn = document.getElementById("addRole");
 addBtn.disabled = true;
  
roleTitleInput.addEventListener('input', () => {
    roleTitle = roleTitleInput.value.trim();
    var errors = [];

    if (roleTitle === "") {
        errors.push("Please enter a role title!");
    }

    if (errors.length > 0) {
        roleTitleFeedback.textContent = errors;
        roleTitleInput.classList.remove("is-valid");
        roleTitleInput.classList.add("is-invalid");
        roleTitleFeedback.classList.add("invalid-feedback");
        addBtn.disabled = false;
    } else {
        roleTitleFeedback.textContent = "";
        roleTitleInput.classList.remove("is-invalid");
        roleTitleInput.classList.add("is-valid");
        roleTitleFeedback.classList.add("valid-feedback");
        addBtn.disabled = false;
    }
});

