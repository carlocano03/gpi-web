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

    #tbl_request th:nth-child(1),
    #tbl_request td:nth-child(1),
    #tbl_request th:nth-child(4),
    #tbl_request td:nth-child(4),
    #tbl_request th:nth-child(5),
    #tbl_request td:nth-child(5),
    #tbl_request th:nth-child(6),
    #tbl_request td:nth-child(6) {
        text-align: center;
    }

</style>
<!-- Content wrapper -->
<div class="content-wrapper">
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card">
            <div class="card-header mb-3 pb-3 d-flex align-items-center gap-2 ">
                <img src="<?php echo base_url('assets/images/admin/member-application.png'); ?>" width="36px"
                    alt="Calendar" />
                <h5 class="table__title"><?= $card_title?></h5>
            </div>
            <div class="card-body mt-4">
                <table class="table" width="100%" id="tbl_request">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Application No</th>
                            <th>Complete Name</th>
                            <th>Application Date</th>
                            <th>Status</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- <tr>
                            <td>1</td>
                            <td>GPI2024-0001</td>
                            <td>Carlo Cano</td>
                            <td>November 16, 2024</td>
                            <td>For Validation</td>
                            <td>
                                <button class="btn btn-primary btn-sm view_details">View</button>
                            </td>
                        </tr> -->
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

<?php $this->load->view('admin_portal/modal/member_info_modal');?>

<script>
    $(document).ready(function() {
        var tbl_request = $('#tbl_request').DataTable({
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
                "url": "<?= base_url('admin_portal/member_application/get_member_application')?>",
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

        $(document).on('click', '.view_details', function() {
            var application_id = $(this).data('id');

            $.ajax({
                url: "<?= base_url('admin_portal/member_application/get_member_info')?>",
                method: "POST",
                data: {
                    application_id: application_id,
                    '_token': csrf_token_value,
                },
                dataType: "json",
                success: function(data) {
                    $('.application_id').val(application_id);

                    $('.complete_name').text(data.complete_name);
                    $('.birthday').text(data.birthday);
                    $('.gender').text(data.gender);
                    $('.passport_no').text(data.passport_no);
                    $('.civil_status').text(data.civil_status);
                    $('.spouse_name').text(data.spouse_name);
                    $('.occupation').text(data.occupation);
                    $('.retiree').text(data.retiree);
                    $('.phone_no').text(data.phone_no);
                    $('.mobile_no').text(data.mobile_no);
                    $('.email_address').text(data.email_address);
                    $('.business_address').text(data.business_address);
                    $('.business_phone').text(data.business_phone);
                    $('.business_mobile').text(data.business_mobile);
                    $('.em_contact_name').text(data.em_contact_name);
                    $('.em_relationship').text(data.em_relationship);
                    $('.em_phone').text(data.em_phone);
                    $('.em_mobile').text(data.em_mobile);
                    $('.em_address').text(data.em_address);
                    $('.ref_name').text(data.ref_name);
                    $('.ref_relationship').text(data.ref_relationship);
                    $('.ref_phone').text(data.ref_phone);
                    $('.ref_mobile').text(data.ref_mobile);
                    $('.ref_address').text(data.ref_address);
                    $('.add_ref_name').text(data.add_ref_name);
                    $('.add_ref_relationship').text(data.add_ref_relationship);
                    $('.add_ref_phone').text(data.add_ref_phone);
                    $('.add_ref_mobile').text(data.add_ref_mobile);
                    $('.add_ref_address').text(data.add_ref_address);
                    $('.passport_attachment').val(data.passport_attachment);
                    $('.selfie_attachment').val(data.selfie_attachment);
                    $('.signature_attachment').val(data.signature_attachment);

                    if (data.passport_attachment == '') {
                        $('.download_passport').hide();
                        $('.no_passport').text('No attachment found');
                    } else {
                        $('.no_passport').hide();
                    }

                    if (data.selfie_attachment == '') {
                        $('.download_selfie').hide();
                        $('.no_selfie').text('No attachment found');
                    } else {
                        $('.no_selfie').hide();
                    }

                    if (data.signature_attachment == '') {
                        $('.download_signature').hide();
                        $('.no_sign').text('No attachment found');
                    } else {
                        $('.no_sign').hide();
                    }

                    $('#offcanvasBottom').offcanvas('show');
                }
            });
        });

        $(document).on('click', '.approve_request', function() {
            var application_id = $('.application_id').val();

            Swal.fire({
                title: 'Are you sure..',
                text: "You want to approve this request?",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, continue',
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "<?= base_url('admin_portal/member_application/request_approval')?>",
                        method: "POST",
                        data: {
                            application_id: application_id,
                            action: 'Approved',
                            '_token': csrf_token_value,
                        },
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
                                $('#offcanvasBottom').offcanvas('hide');
                                tbl_request.draw();
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
        });

        $(document).on('click', '.decline_request', function() {
            var application_id = $('.application_id').val();

            Swal.fire({
                title: 'Are you sure..',
                text: "You want to decline this request?",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, continue',
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "<?= base_url('admin_portal/member_application/request_approval')?>",
                        method: "POST",
                        data: {
                            application_id: application_id,
                            action: 'Declined',
                            '_token': csrf_token_value,
                        },
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
                                $('#offcanvasBottom').offcanvas('hide');
                                tbl_request.draw();
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
        });
    });
</script>