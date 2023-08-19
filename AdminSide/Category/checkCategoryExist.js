$(document).ready(function () {
                $("#categoryTitle").keyup(function () {
                    var categoryTitle = $(this).val().trim();
                    var categoryTitleInput = document.getElementById('categoryTitle');
                    var categoryTitleFeedback = document.getElementById('categoryTitleFeedback');
                    var addBtn = document.getElementById('addCategory');
                    
                    if (categoryTitle !== '') {
                        $.ajax({
                            url: "../../checkExist/checkCategory.php",
                            type: 'GET',
                            data: {
                                'categoryTitle': categoryTitle
                            },
                            cache: false,
                            async: false,
                            success: function (count, status, xhr) {
                                if (count > 0) {
                                   categoryTitleFeedback.textContent = "This category title already exist, please re-enter another one";
                                   categoryTitleInput.classList.remove('is-valid');
                                   categoryTitleInput.classList.add('is-invalid');
                                   categoryTitleFeedback.classList.add('invalid-feedback');
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


