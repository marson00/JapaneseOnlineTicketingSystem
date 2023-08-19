//variables
const statusInput = document.getElementById("statusTitle");
const statusFeedback = document.getElementById("statusFeedback");
const addBtn = document.getElementById("addStatus");
addBtn.disabled = true;

//validation
statusInput.addEventListener('input', () => {
    var status = statusInput.value.trim();
    var errors = [];
    
    if(status === ""){
        errors.push("Please enter a status title!");
    }
    
    if(errors.length > 0){
        statusFeedback.textContent = errors;
        statusInput.classList.remove("is-valid");
        statusInput.classList.add("is-invalid");
        statusFeedback.classList.add("invalid-feedback");
        addBtn.disabled = true;
    }else{
        statusFeedback.textContent = "";
        statusInput.classList.remove("is-invalid");
        statusInput.classList.add("is-valid");
        statusFeedback.classList.add("valid-feedback");
       addBtn.disabled = false;
    }
});

