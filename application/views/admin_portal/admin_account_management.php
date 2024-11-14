<style>
.table__title {
    font-size: 20px;
    font-weight: 500;
    color: #434875 !important;
    padding: 8px 0;
    margin-bottom: 0;
}

.card {
    background: #ffffff;
    border-radius: 8px;
    color: #434875;
    box-shadow: 0 9px 20px rgba(46, 35, 94, .07);
}

#table_permission th:nth-child(2),
#table_permission td:nth-child(2),

#tbl_account th:nth-child(1),
#tbl_account td:nth-child(1),
#tbl_account th:nth-child(3),
#tbl_account td:nth-child(3),
#tbl_account th:nth-child(4),
#tbl_account td:nth-child(4),
#tbl_account th:nth-child(5),
#tbl_account td:nth-child(5),
#tbl_account th:nth-child(6),
#tbl_account td:nth-child(6) {
    text-align: center;
}
</style>
<!-- Content wrapper -->
<div class="content-wrapper">
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card">
            <div class="card-header mb-3 pb-3 d-flex align-items-center gap-2 ">
                <img src="<?php echo base_url('assets/images/admin/administration.png'); ?>" width="36px"
                    alt="Calendar" />
                <h5 class="table__title"><?= $card_title?></h5>
            </div>
            <div class="card-body mt-4">
                <table class="table" width="100%" id="tbl_account">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Complete Name</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Status</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="loading-screen text-center" style="display: none;">
    <div class="spinner-border text-dark" role="status">

    </div>
</div>

<?php $this->load->view('admin_portal/modal/account_modal');?>

<script>
$(document).ready(function() {
    var tbl_account = $('#tbl_account').DataTable({
        language: {
            search: '',
            searchPlaceholder: "Search Here...",
            paginate: {
                next: '<i class="bi bi-chevron-double-right"></i>',
                previous: '<i class="bi bi-chevron-double-left"></i>'
            }
        },
        "ordering": false,
        "serverSide": true,
        "processing": true,
        "deferRender": true,
        "ajax": {
            "url": "<?= base_url('admin_portal/account_management/get_admin_account')?>",
            "type": "POST",
            "data": function(d) {
                d[csrf_token_name] = csrf_token_value;
            },
            "complete": function(res) {
                csrf_token_name = res.responseJSON.csrf_token_name;
                csrf_token_value = res.responseJSON.csrf_token_value;
            }
        }
    });

    $('#tbl_account_filter').prepend(
        `<button class="btn btn-dark btn-sm" data-bs-toggle="modal" data-bs-target="#addModal"><i class="bi bi-person-fill-add me-2"></i>Add New Account</button>`
    );

    $(document).on('click', '.add_permission', function() {
        var user_id = $(this).attr('id');
        $('#modalPermission').modal('show');
        $('#table_permission').DataTable({
            language: {
                search: '',
                searchPlaceholder: "Search Here...",
                paginate: {
                    next: '<i class="bi bi-chevron-double-right"></i>',
                    previous: '<i class="bi bi-chevron-double-left"></i>'
                }
            },
            "ordering": false,
            "info": false,
            "serverSide": true,
            "processing": true,
            "deferRender": true,
            "stateSave": true,
            "bDestroy": true,
            "ajax": {
                "url": "<?= base_url('admin_portal/account_management/get_Permission') ?>",
                "type": "POST",
                "data": function(d) {
                    d[csrf_token_name] = csrf_token_value;
                    d.user_id = user_id;
                },
                "complete": function(res) {
                    csrf_token_name = res.responseJSON.csrf_token_name;
                    csrf_token_value = res.responseJSON.csrf_token_value;
                }
            },
        });
    });

    $(document).on('click', '#save_account', function(event) {
        event.preventDefault();
        event.stopPropagation();

        var form = $('#userForm')[0];
        var formData = new FormData(form);
        formData.append('first_name', $('#first_name').val());
        formData.append('middle_name', $('#middle_name').val());
        formData.append('last_name', $('#last_name').val());
        formData.append('email_add', $('#email_add').val());
        formData.append('_token', csrf_token_value);

        form.classList.add('was-validated');
        if (form.checkValidity() === false) {
            event.preventDefault();
            event.stopPropagation();
        } else {
            Swal.fire({
                title: 'Are you sure..',
                text: "You want to continue this transaction?",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, continue',
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "<?= base_url('admin_portal/account_management/save_new_account');?>",
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
                                Swal.fire({
                                    icon: 'warning',
                                    title: 'Ooops...',
                                    text: data.error,
                                });
                            } else {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Thank You!',
                                    text: data.success,
                                });
                                $('#addModal').modal('hide');
                                form.reset();
                                form.classList.remove('was-validated');
                                tbl_account.draw();
                            }
                        },
                        complete: function() {
                            $('.loading-screen').hide();
                        },
                        error: function() {
                            $('.loading-screen').hide();
                            Swal.fire({
                                icon: 'error',
                                title: 'Ooops...',
                                text: 'An error occurred while processing the request.',
                            });
                        }
                    });
                }
            });
        }
    });

    $(document).on('click', '#edit_account', function(event) {
        event.preventDefault();
        event.stopPropagation();

        var form = $('#updateForm')[0];
        var formData = new FormData(form);
        formData.append('user_id', $('#user_id').val());
        formData.append('first_name', $('#edit_first_name').val());
        formData.append('middle_name', $('#edit_middle_name').val());
        formData.append('last_name', $('#edit_last_name').val());
        formData.append('email_add', $('#edit_email_add').val());
        formData.append('_token', csrf_token_value);

        form.classList.add('was-validated');
        if (form.checkValidity() === false) {
            event.preventDefault();
            event.stopPropagation();
        } else {
            Swal.fire({
                title: 'Are you sure..',
                text: "You want to continue this transaction?",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, continue',
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "<?= base_url('admin_portal/account_management/update_account');?>",
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
                                Swal.fire({
                                    icon: 'warning',
                                    title: 'Ooops...',
                                    text: data.error,
                                });
                            } else {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Thank You!',
                                    text: data.success,
                                });
                                $('.loading-screen').hide();
                                $('#updateModal').modal('hide');
                                form.reset();
                                form.classList.remove('was-validated');
                                tbl_account.draw();
                            }
                        },
                        complete: function() {
                            $('.loading-screen').hide();
                        },
                        error: function() {
                            $('.loading-screen').hide();
                            Swal.fire({
                                icon: 'error',
                                title: 'Ooops...',
                                text: 'An error occurred while processing the request.',
                            });
                        }
                    });
                }
            });
        }
    });

    $(document).on('click', '.account_activation', function() {
        var user_id = $(this).attr('id');

        if ($(this).is(":checked")) {
            //Activate accouny
            Swal.fire({
                title: 'Are you sure..',
                text: "You want to activate this account?",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, continue',
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "<?= base_url('admin_portal/account_management/account_activation')?>",
                        method: "POST",
                        data: {
                            user_id: user_id,
                            action: 'Activate',
                            '_token': csrf_token_value,
                        },
                        dataType: "json",
                        success: function(data) {
                            if (data.message == 'Success') {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Thank you!',
                                    text: 'Account successfully activated.',
                                });
                                tbl_account.draw();
                            } else {
                                Swal.fire({
                                    icon: 'warning',
                                    title: 'Oops...',
                                    text: 'Failed to activate the account.',
                                });
                            }
                        },
                        error: function() {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: 'An error occurred while processing the request.',
                            });
                        }
                    });
                } else {
                    tbl_account.draw();
                }
            });
        } else {
            //Deactivating account
            Swal.fire({
                title: 'Are you sure..',
                text: "You want to deactivate this account?",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, continue',
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "<?= base_url('admin_portal/account_management/account_activation')?>",
                        method: "POST",
                        data: {
                            user_id: user_id,
                            action: 'Deactivate',
                            '_token': csrf_token_value,
                        },
                        dataType: "json",
                        success: function(data) {
                            if (data.message == 'Success') {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Thank you!',
                                    text: 'Account successfully deactivated.',
                                });
                                tbl_account.draw();
                            } else {
                                Swal.fire({
                                    icon: 'warning',
                                    title: 'Oops...',
                                    text: 'Failed to deactivated the account.',
                                });
                            }
                        },
                        error: function() {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: 'An error occurred while processing the request.',
                            });
                        }
                    });
                } else {
                    tbl_account.draw();
                }
            });
        }
    });

    $(document).on('click', '.apply_permission', function() {
        var perm_id = $(this).attr('id');
        var userID = $(this).data('user');

        if ($(this).is(":checked")) {
            $.ajax({
                url: "<?= base_url('admin_portal/account_management/apply_permission') ?>",
                method: "POST",
                data: {
                    userID: userID,
                    perm_id: perm_id,
                    action: 'Grant',
                    '_token': csrf_token_value,
                },
                dataType: "json",
                success: function(data) {
                    if (data.message == 'Success') {
                        $('.success-message').html(
                            '<div class="alert alert-success"><i class="bi bi-info-circle-fill me-2"></i>Permission Granted!</div>'
                        );
                        setTimeout(() => {
                            $('.success-message').html('');
                        }, 2000);
                        var table = $('#table_permission').DataTable();
                        table.draw();
                    } else {
                        $('.success-message').html(
                            '<div class="alert alert-danger"><i class="bi bi-info-circle-fill me-2"></i>Failed to add permission.</div>'
                        );
                        setTimeout(() => {
                            $('.success-message').html('');
                        }, 2000);
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.error("AJAX request failed:", textStatus, errorThrown);
                    $('.success-message').html(
                        '<div class="alert alert-danger text-sm"><i class="bi bi-info-circle-fill me-2"></i>An error occurred while processing the request.</div>'
                    );
                }
            });
        } else {
            $.ajax({
                url: "<?= base_url('admin_portal/account_management/apply_permission') ?>",
                method: "POST",
                data: {
                    userID: userID,
                    perm_id: perm_id,
                    action: 'Denied',
                    '_token': csrf_token_value,
                },
                dataType: "json",
                success: function(data) {
                    if (data.message == 'Success') {
                        $('.success-message').html(
                            '<div class="alert alert-success"><i class="bi bi-info-circle-fill me-2"></i>Remove Permission!</div>'
                        );
                        setTimeout(() => {
                            $('.success-message').html('');
                        }, 2000);
                        var table = $('#table_permission').DataTable();
                        table.draw();
                    } else {
                        $('.success-message').html(
                            '<div class="alert alert-danger"><i class="bi bi-info-circle-fill me-2"></i>Failed to remove permission.</div>'
                        );
                        setTimeout(() => {
                            $('.success-message').html('');
                        }, 2000);
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.error("AJAX request failed:", textStatus, errorThrown);
                    $('.success-message').html(
                        '<div class="alert alert-danger text-sm"><i class="bi bi-info-circle-fill me-2"></i>An error occurred while processing the request.</div>'
                    );
                }
            });
        }
    });

    $(document).on('click', '#send_credentials', function() {
        var user_id = $(this).data('id');

        $.ajax({
            url: "<?= base_url('admin_portal/account_management/resend_credentials')?>",
            method: "POST",
            data: {
                user_id: user_id,
                '_token': csrf_token_value,
            },
            dataType: "json",
            beforeSend: function() {
                $('.loading-screen').show();
            },
            success: function(data) {
                if (data.error !== '') {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Ooops..',
                        text: data.error,
                    });
                } else {
                    Swal.fire({
                        icon: 'success',
                        title: 'Thank you!',
                        text: 'Account credentials successfully sent.',
                    });
                }
            },
            complete: function() {
                $('.loading-screen').hide();
            },
            error: function() {
                $('.loading-screen').hide();

                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'An error occurred while communicating with the server. Please try again.',
                });
            }
        });
    });

});
</script>