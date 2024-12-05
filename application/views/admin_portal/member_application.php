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
                    $('.birth_place').text(data.birth_place);
                    $('.gender').text(data.gender);
                    $('.precinct_no').text(data.precinct_no);
                    $('.civil_status').text(data.civil_status);
                    $('.spouse_name').text(data.spouse_name);
                    $('.occupation').text(data.occupation);
                    $('.other_occupation').text(data.others_occupation);
                    $('.retiree').text(data.retiree);

                    $('.religion').text(data.religion);
                    $('.citizenship').text(data.citizenship);
                    $('.mother_name').text(data.mother_name);
                    $('.father_name').text(data.father_name);

                    $('.phone_no').text(data.phone_no);
                    $('.mobile_no').text(data.mobile_no);
                    $('.email_address').text(data.email_address);
                    $('.em_contact_name').text(data.em_contact_name);
                    $('.em_relationship').text(data.em_relationship);
                    $('.em_phone').text(data.em_phone);
                    $('.em_mobile').text(data.em_mobile);
                    $('.em_address').text(data.em_address);
                    $('.selfie_attachment').val(data.selfie_attachment);
                    $('.signature_attachment').val(data.signature_attachment);
                    $('.id_attachment').val(data.government_id);

                    $('.province').text(data.province);
                    $('.municipality').text(data.municipality);
                    $('.barangay').text(data.barangay);
                    $('.residence_address').text(data.residence_address);
                    $('.date_residency').text(data.residence_when);
                    

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

                    if (data.government_id == '') {
                        $('.download_id').hide();
                        $('.no_id').text('No attachment found');
                    } else {
                        $('.no_id').hide();
                    }

                    $('#offcanvasBottom').offcanvas('show');
                }
            });
        });

        $(document).on('click', '.approve_modal', function() {
            $('#approveModal').modal('show');
        });

        
        $(document).on('click', '#approve_request', function() {
            var application_id = $('.application_id').val();
            var member_type = $('#member_type').val();

            if (member_type != '') {
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
                                member_type: member_type,
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
                                    $('#approveModal').modal('hide');
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
            } else {
                Swal.fire({
                    icon: 'warning',
                    title: 'Ooops...',
                    text: 'Please choose on the following options.',
                });
            }
            
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

        $(document).on('click', '.download_selfie', function() {
            var filename = $('.selfie_attachment').val();

            var url = "<?= base_url('admin_portal/member_application/download_selfie?file=')?>" + filename;
            window.location.href = url;
        });

        $(document).on('click', '.download_signature', function() {
            var filename = $('.signature_attachment').val();

            var url = "<?= base_url('admin_portal/member_application/download_signature?file=')?>" + filename;
            window.location.href = url;
        });

        $(document).on('click', '.download_id', function() {
            var filename = $('.id_attachment').val();

            var url = "<?= base_url('admin_portal/member_application/government_id?file=')?>" + filename;
            window.location.href = url;
        });
    });
</script>