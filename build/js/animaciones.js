$(document).ready(function () {
    // Enviar el formulario de Log In
    $("#form-login").on("submit", function (e) {
        e.preventDefault(); // Evita que el formulario se envíe normalmente
        var username = $("#username-login").val();
        var password = $("#password-login").val();

        if (username === "" || password === "") {
            Swal.fire({
                icon: 'warning',
                title: 'Oops...',
                text: 'Please fill in all fields!',
                timer: 2000,
                showConfirmButton: false
            });
        } else {
            $.ajax({
                url: 'apis/login-handler.php',  
                type: 'POST',
                data: {
                    username: username,
                    password: password
                },
                success: function (response) {
                    if (response === "admin") {
                        Swal.fire({
                            icon: 'success',
                            title: 'Login Successful',
                            text: 'Welcome Admin!',
                            timer: 2000,
                            showConfirmButton: false
                        }).then(function () {
                            window.location = "../admin/index.php"; // Redirigir a la vista de admin
                        });
                    } else if (response === "user") {
                        Swal.fire({
                            icon: 'success',
                            title: 'Login Successful',
                            text: 'Welcome back!',
                            timer: 2000,
                            showConfirmButton: false
                        }).then(function () {
                            window.location = "index.php"; // Redirigir a la vista del usuario
                        });
                    } else if (response === "incorrect_password") {
                        Swal.fire({
                            icon: 'error',
                            title: 'Login Failed',
                            text: 'Incorrect password.',
                            timer: 2000,
                            showConfirmButton: false
                        });
                    } else if (response === "user_not_found") {
                        Swal.fire({
                            icon: 'error',
                            title: 'Login Failed',
                            text: 'User not found.',
                            timer: 2000,
                            showConfirmButton: false
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'There was a problem processing your request.',
                            timer: 2000,
                            showConfirmButton: false
                        });
                    }
                },
                error: function () {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'There was a problem processing your request.',
                        timer: 2000,
                        showConfirmButton: false
                    });
                }
            });
        }
    });

    // Enviar el formulario de Sign Up
    $("#form-signup").on("submit", function (e) {
        e.preventDefault(); // Evita que el formulario se envíe normalmente
        var email = $("#email-signup").val();
        var username = $("#username-signup").val();
        var password = $("#password-signup").val();
        var termsChecked = $("#confirm-terms").is(":checked");

        if (!termsChecked) {
            Swal.fire({
                icon: 'warning',
                title: 'Oops...',
                text: 'You need to accept the Terms and Conditions!',
                timer: 2000,
                showConfirmButton: false
            });
        } else if (email === "" || username === "" || password === "") {
            Swal.fire({
                icon: 'warning',
                title: 'Oops...',
                text: 'Please fill in all fields!',
                timer: 2000,
                showConfirmButton: false
            });
        } else {
            $.ajax({
                url: 'apis/register-handler.php',  
                type: 'POST',
                data: {
                    email: email,
                    username: username,
                    password: password,
                    tipo_usuario: 'usuario'  // Tipo de usuario por defecto
                },
                success: function (response) {
                    if (response === "success") {
                        Swal.fire({
                            icon: 'success',
                            title: 'Registration Successful',
                            text: 'You can now log in!',
                            timer: 2000,
                            showConfirmButton: false
                        }).then(function () {
                            window.location = "login.php"; // Redirigir al login
                        });
                    } else if (response === "username_exists") {
                        Swal.fire({
                            icon: 'error',
                            title: 'Registration Failed',
                            text: 'Username already exists.',
                            timer: 2000,
                            showConfirmButton: false
                        });
                    } else if (response === "email_exists") {
                        Swal.fire({
                            icon: 'error',
                            title: 'Registration Failed',
                            text: 'Email already exists.',
                            timer: 2000,
                            showConfirmButton: false
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'There was a problem processing your request.',
                            timer: 2000,
                            showConfirmButton: false
                        });
                    }
                },
                error: function () {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'There was a problem processing your request.',
                        timer: 2000,
                        showConfirmButton: false
                    });
                }
            });
        }
    });

    // Evitar que se active la validación cuando se cambie de pestaña (Sign Up o Login)
    $("#goRight, #goLeft").on("click", function (e) {
        e.preventDefault();  // Evitar que cualquier acción se ejecute al hacer clic
    });
});
