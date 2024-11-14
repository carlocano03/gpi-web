<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GPI | Admin</title>
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="<?= base_url('assets/images/logo-no-bg.png');?>" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/admin-login.css'); ?>">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
        integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.10.1/dist/sweetalert2.all.min.js"></script>
    <script src="<?= base_url('assets/vendor/libs/jquery/jquery.js');?>"></script>
    <script>
        var csrf_token_name = "<?php echo $this->security->get_csrf_token_name(); ?>";
        var csrf_token_value = "<?php echo $this->security->get_csrf_hash(); ?>";
        var baseURL = "<?= base_url();?>";
    </script>

    <style>
        .loading-screen {
            overflow: hidden;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(255, 255, 255, 0.8);
            /* background-color: #fff; */
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9999;
            /* Make sure it appears on top of other elements */
        }
    </style>
</head>

<body>
    <!-- <div class="loading-screen text-center">
        <div class="spinner-border text-dark" role="status">
                <span class="visually-hidden">Loading...</span>
        </div>
    </div> -->

    <div class="login-form">
        <div class="icon-container">
            <img class="navbar__logo" src="<?php echo base_url('assets/images/logo-no-bg.png'); ?>"
                alt="GPI Logo">
        </div>
        <h1 style="color:#344489;">Admin Login</h1>
        <div class="error-message"></div>
        <form id="adminLoginForm" class="needs-validation" novalidate>
            <div class="mb-3">
                <input type="text" class="form-control" id="username" placeholder="Username" required>
                <div class="invalid-feedback">Please enter your username.</div>
            </div>
            <div class="mb-3">
                <input type="password" class="form-control" id="password" placeholder="Password" required>
                <div class="invalid-feedback">Please enter your password.</div>
            </div>
            <button type="button" class="btn btn-black sign-in__btn">Sign In</button>
            <p class="form-text">Forgot your password? <a href="#" class="btn-link">Click here</a></p>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        $(document).ready(function() {
            setTimeout(() => {
                $('.loading-screen').fadeOut(500);
                $('body').css('overflow', 'auto');
            }, 1500);

            function handleLogin() {
                var form = $('#adminLoginForm')[0];
                var formData = new FormData(form);

                formData.append('username', $('#username').val());
                formData.append('password', $('#password').val());
                formData.append('_token', csrf_token_value);

                form.classList.add('was-validated');
                if (form.checkValidity() === false) {
                    event.preventDefault();
                    event.stopPropagation();
                } else {
                    $.ajax({
                        url: "<?= base_url('admin_portal/login/login_process');?>",
                        method: "POST",
                        data: formData,
                        contentType: false,
                        processData: false,
                        dataType: "json",
                        beforeSend: function() {
                            $('.loading-screen').show();
                        },
                        success: function(data) { 
                            if (data.error != '') {
                                $('.error-message').html(data.error);
                                setTimeout(function() {
                                    $('.error-message').html('');
                                }, 3000)
                            } else {
                                $('.error-message').html(data.success);
                                setTimeout(function() {
                                    $('.error-message').html('');
                                    window.location.href = data.main_url;
                                }, 3000);
                            }
                        },
                        complete: function() {
                            $('.loading-screen').hide();
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            console.error("AJAX request failed:", textStatus, errorThrown);
                            $('.error-message').html('<div class="alert alert-danger p-2 text-dark text-sm">An error occurred while processing the request.</div>');
                        }
                    });
                }
            }

            $(document).on('click', '.sign-in__btn', function(event) {
                event.preventDefault();
                event.stopPropagation();
                handleLogin();
            });

            $(document).on('keypress', '#password', function(event) {
                if (event.which === 13) {
                    event.preventDefault();
                    event.stopPropagation();
                    handleLogin();
                }
            });
        });

    </script>
</body>

</html>
