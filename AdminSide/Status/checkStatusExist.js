$(document).ready(function () {
                $("#statusTitle").keyup(function () {
                    var statusTitle = $(this).val().trim();
                    var statusTitleInput = document.getElementById('statusTitle');
                    var statusTitleFeedback = document.getElementById('statusFeedback');
                    var addBtn = document.getElementById('addStatus');
                    
                    console.log(statusTitle);
                    if (statusTitle !== '') {
                        $.ajax({
                            url: "../../checkExist/checkStatus.php",
                            type: 'GET',
                            data: {
                                'statusTitle': statusTitle
                            },
                            cache: false,
                            async: false,
                            success: function (count, status, xhr) {
                                if (count > 0) {
                                   statusTitleFeedback.textContent = "This status title already exist, please re-enter another one";
                                   statusTitleInput.classList.remove('is-valid');
                                   statusTitleInput.classList.add('is-invalid');
                                   statusTitleFeedback.classList.add('invalid-feedback');
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


