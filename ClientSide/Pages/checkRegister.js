$(document).ready(function () {
    $("#username").keyup(function () {
        var userName = $(this).val().trim();
        var usernameInput = document.getElementById('username');
        var usernameFeedback = document.getElementById('usernameFeedback');
        console.log(userName);

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
//        var emailOutline = document.getElementById('emailOutline');

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
//                        emailOutline.classList.remove("mb-3");
//                        emailOutline.classList.add("mb-5");
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


