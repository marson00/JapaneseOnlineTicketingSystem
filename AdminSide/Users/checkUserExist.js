//check username exist
$(document).ready(function () {
    $("#username").keyup(function () {
        var userName = $(this).val().trim();
        var usernameInput = document.getElementById('username');
        var usernameFeedback = document.getElementById('usernameFeedback');
        var addBtn = document.getElementById('addUser');

        if (userName !== '') {
            $.ajax({
                url: "../../checkExist/checkUsername.php",
                type: 'GET',
                data: {
                    'username': userName
                },
                cache: false,
                async: false,
                success: function (count, status, xhr) {
                    if (count > 0) {
                        usernameFeedback.textContent = "This username already exist, please re-enter another one";
                        usernameInput.classList.remove('is-valid');
                        usernameInput.classList.add('is-invalid');
                        usernameFeedback.classList.add('invalid-feedback');
                        addBtn.disabled = true;
                    }
                },
                error: function (jqXhr, textStatus, errorMessage) {
                    showCustomMessage(errorMessage);
                }
            });
        }

    });

    $("#email").keyup(function () {
        var email = $(this).val().trim();
        var emailInput = document.getElementById("email");
        var emailfeedback = document.getElementById('emailFeedback');

        if (email !== '') {
            $.ajax({
                url: "../../checkExist/checkEmail.php",
                type: 'GET',
                data: {
                    'email': email
                },
                cache: false,
                async: false,
                success: function (count, status, xhr) {
                    if (count > 0) {
                        emailfeedback.textContent = "This email already exist, please re-enter another one";
                        emailInput.classList.remove('is-valid');
                        emailInput.classList.add('is-invalid');
                        emailfeedback.classList.add('invalid-feedback');
                    }
                },
                error: function (jqXhr, textStatus, errorMessage) {
                    showCustomMessage(errorMessage);
                }
            });
        }

    });
});


