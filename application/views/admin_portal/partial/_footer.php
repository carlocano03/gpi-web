<!-- Footer -->
<footer class="content-footer footer bg-footer-theme">
    <div class="container-xxl d-flex flex-wrap justify-content-between py-2 flex-md-row flex-column">
        <div class="mb-2 mb-md-0">
            Copyright © All Right Reserved
            <script>
            document.write(new Date().getFullYear());
            </script>
            | 
            <a href="#" target="_blank" class="footer-link fw-bolder">Change Life Christian Church</a>
        </div>
    </div>
</footer>
<!-- / Footer -->

<div class="content-backdrop fade"></div>
</div>
<!-- Content wrapper -->
</div>
<!-- / Layout page -->
</div>

<!-- Overlay -->
<div class="layout-overlay layout-menu-toggle"></div>
</div>
<!-- / Layout wrapper -->

    <div class="modal fade" id="passwordModal" data-bs-backdrop="static" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"><i class="bi bi-person-fill-lock me-2"></i>Change Password</h5>
                </div>
                <div class="modal-body">
                    <div class="message"></div>
                    <form id="passwordForm" class="needs-validation" novalidate>
                        <div class="mb-3 form-password-toggle">
                            <div class="d-flex justify-content-between">
                                <label class="form-label" for="old_password">Old Password</label>
                            </div>
                            <div class="input-group input-group-merge">
                                <input type="password" id="old_password" class="form-control" name="old_password"
                                    placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                    aria-describedby="old_password" required/>
                                <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                            </div>
                            <div class="invalid-feedback">
                                Please provide a valid password.
                            </div>
                            <div class="error-message" style="font-size:12px; color:red;"></div>
                        </div>
                        
                        <hr>
                        <div class="new_pass" style="display: none;">
                            <div class="mb-3 form-password-toggle">
                                <div class="d-flex justify-content-between">
                                    <label class="form-label" for="new_password">New Password</label>
                                </div>
                                <div class="input-group input-group-merge">
                                    <input type="password" id="new_password" class="form-control" name="new_password"
                                        placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                        aria-describedby="new_password" required/>
                                    <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                                </div>
                                <div class="invalid-feedback">
                                    Please provide a valid password.
                                </div>
                            </div>

                            <div class="mb-3 form-password-toggle">
                                <div class="d-flex justify-content-between">
                                    <label class="form-label" for="confirm_password">Confirm Password</label>
                                </div>
                                <div class="input-group input-group-merge">
                                    <input type="password" id="confirm_password" class="form-control" name="confirm_password"
                                        placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                        aria-describedby="confirm_password" required/>
                                    <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                                </div>
                                <div class="invalid-feedback">
                                    Please provide a valid password.
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="update_password" disabled>Update Password</button>
                </div>
            </div>
        </div>
    </div>

<script src="<?= base_url('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js');?>"></script>

<script src="<?= base_url('assets/vendor/js/menu.js');?>"></script>
<!-- endbuild -->

<!-- Vendors JS -->
<script src="<?= base_url('assets/vendor/libs/apex-charts/apexcharts.js');?>"></script>

<!-- Main JS -->
<script src="<?= base_url('assets/js/main.js');?>"></script>

<!-- Page JS -->
<!-- <script src="<?= base_url('assets/js/dashboards-analytics.js');?>"></script> -->

<!-- Place this tag in your head or just before your close body tag. -->
<script async defer src="https://buttons.github.io/buttons.js"></script>

<script>
    var temp_pass = "<?= $this->session->userdata('adminIn')['temp_pass']?>";
    function checkPasswordMatch() {
        var password = $("#new_password").val();
        var confirmPassword = $("#confirm_password").val();
        if (password != confirmPassword) {
            $(".message").text("Passwords does not match!");
            $(".message").removeClass("alert alert-success");
            $(".message").addClass("alert alert-danger");
            $("#update_password").attr("disabled", true);
        } else {
            $(".message").text("Passwords match.");
            $(".message").removeClass("alert alert-danger");
            $(".message").addClass("alert alert-success");
            $("#update_password").attr("disabled", false);
        }
    }

    function sidebarCount()
    {
        $.ajax({
            url: "<?= base_url('portal/admin_portal/main/sidebar_count');?>",
            method: "GET",
            dataType: "json",
            success: function(data) {
                if (data.settings_count > 0) {
                    $('.settings_count').text(data.settings_count);
                } else {
                    $('.settings_count').text('');
                }

                if (data.suggestion_count > 0) {
                    $('.suggestion_count').text(data.suggestion_count);
                } else {
                    $('.suggestion_count').text('');
                }
            }
        });
    }

    $(document).ready(function() {
        sidebarCount();
        setTimeout(() => {
            sidebarCount();
        }, 5000);

        if (temp_pass != '') {
            $('#passwordModal').modal('show');
        } else {
            $('#passwordModal').modal('hide');
        }

        $(document).on('input', '#old_password', function() {
            var old_pass = $(this).val();

            $.ajax({
                url: "<?= base_url('portal/admin_portal/main/check_old_pass')?>",
                method: "POST",
                data: {
                    old_pass: old_pass,
                    '_token': csrf_token_value,
                },
                dataType: "json",
                success: function(data) {
                    if (data.error != '') {
                        $('.error-message').html(data.error);
                        $('.new_pass').hide();
                    } else {
                        setTimeout(() => {
                            $('.error-message').html('');
                        }, 2000);
                        $('.new_pass').fadeIn();
                    }
                }
            });
        });

        $(document).on('keyup', '#new_password, #confirm_password', function() {
            if ($(this).val() == '') {
                $(".message").text("");
                $(".message").removeClass("alert alert-danger");
                $(".message").removeClass("alert alert-success");
            }
        });

        $("#confirm_password").keyup(checkPasswordMatch);
    });

    $(document).on('keypress', '.number-input', function (e) {
		// Allow only numeric and dot (.) characters
		var charCode = e.which || e.keyCode;
		if (charCode !== 46 && charCode > 31 && (charCode < 48 || charCode > 57)) {
			e.preventDefault();
		}
	});

    $(document).on('click', '#update_password', function(event) {
        event.preventDefault();
        event.stopPropagation();

        var form = $('#passwordForm')[0];
        var formData = new FormData(form);
        formData.append('password', $('#new_password').val());
        formData.append('_token', csrf_token_value);

        form.classList.add('was-validated');
        if (form.checkValidity() === false) {
            event.preventDefault();
            event.stopPropagation();
        } else {
            Swal.fire({
                title: 'Are you sure..',
                text: "You want to change your password?",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, continue',
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "<?= base_url('portal/admin_portal/main/update_password')?>",
                        method: "POST",
                        data: formData,
                        contentType: false,
                        processData: false,
                        dataType: "json",
                        success: function(data) {
                            if (data.message == 'Success') {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Thank you!',
                                    text: 'Password successfully changed.',
                                });
                                setTimeout(() => {
                                    window.location.href =
                                        "<?= base_url('main/logout/adminIn');?>";
                                }, 2000);
                            } else {
                                Swal.fire({
                                    icon: 'warning',
                                    title: 'Oops...',
                                    text: 'Failed to change password. Please try again later.',
                                });
                            }
                        },
                        error: function(xhr, textStatus, errorThrown) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: 'An error occurred while communicating with the server. Please try again.',
                            });
                        }
                    });
                }
            });
        }
    });

</script>

</body>

</html>
