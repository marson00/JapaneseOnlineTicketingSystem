

$(document).ready(function () {
    $("#roleTitle").keyup(function () {
        var roleTitle = $(this).val().trim();
        var roleTitleInput = document.getElementById('roleTitle');
        var roleTitleFeedback = document.getElementById('roleTitleFeedback');
        var addBtn = document.getElementById('addRole');

        if (roleTitle !== '') {
            $.ajax({
                url: "../../checkExist/checkRole.php",
                type: 'GET',
                data: {
                    'roleTitle': roleTitle
                },
                cache: false,
                async: false,
                success: function (count, status, xhr) {
                    if (count > 0) {
                        roleTitleFeedback.textContent = "This role title already exist, please re-enter another one";
                        roleTitleInput.classList.remove('is-valid');
                        roleTitleInput.classList.add('is-invalid');
                        roleTitleFeedback.classList.add('invalid-feedback');
                        addBtn.disabled = true;
                    }
                },
                error: function (jqXhr, textStatus, errorMessage) {
                    showCustomMessage(errorMessage);
                }
            });
        }

    });
});