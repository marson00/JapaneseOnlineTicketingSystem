$(document).ready(function () {
    $("#loginBtn").click(function () {
        var username = $('#username').val();
        var password = $('#password').val();

        if (username !== '' && password !== '') {
            $.ajax({
                url: "../../checkExist/checkLoginInput.php",
                type: 'POST',
                data: {
                    'username': username,
                    'password': password
                },
                cache: false,
                async: false,
                success: function (response) {
                    var result = JSON.parse(response);
                    console.log(result.error);
                    console.log(result.roleId);
                    console.log(result.userId);
                    if (result.error === false) {
                        window.location.href = 'session.php?userid='+result.userId;
                        if(result.roleId === 1){
                            window.location.href = '/JapaneseOnlineTicketingSystem/AdminSide/Dashboard/dashboard.php';
                        }else{
                            window.location.href = 'homepage.php';
                        }
                    } else {
                        Swal.fire({
                            position: 'top',
                            icon: 'error',
                            title: 'Incorrect username or password',
                            showConfirmButton: false,
                            timer: 1500
                        })
                    }
                },
                error: function (errorMessage) {
                    showCustomMessage(errorMessage);
                }
            });
        }

    });
});


