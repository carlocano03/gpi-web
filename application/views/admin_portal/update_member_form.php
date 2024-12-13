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

    #tbl_news th:nth-child(1),
    #tbl_news td:nth-child(1),
    #tbl_news th:nth-child(3),
    #tbl_news td:nth-child(3),
    #tbl_news th:nth-child(4),
    #tbl_news td:nth-child(4),
    #tbl_news th:nth-child(5),
    #tbl_news td:nth-child(5) {
        text-align: center;
    }

</style>
<!-- Content wrapper -->
<div class="content-wrapper">
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card">
            <div class="card-header mb-3 pb-3 d-flex align-items-center gap-2 ">
                <img src="<?php echo base_url('assets/images/admin/news.png'); ?>" width="36px"
                    alt="Calendar" />
                <h5 class="table__title"><?= $card_title?></h5>
            </div>
            <div class="card-body">
                <form id="updateForm" class="needs-validation" novalidate>
                    <input type="hidden" id="member_id" value="<?= isset($info['member_id']) ? $info['member_id'] : '';?>">
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <div for="firstname" class="form-label">First Name<span class="text-danger">*</span></div>
                            <input type="text" class="form-control text-uppercase" id="firstname" value="<?= isset($info['first_name']) ? $info['first_name'] : '';?>" required>
                            <div class="invalid-feedback">
                                Please provide a valid first name.
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div for="middlename" class="form-label">Middle Name</div>
                            <input type="text" class="form-control text-uppercase" id="middlename" value="<?= isset($info['middle_name']) ? $info['middle_name'] : '';?>">
                        </div>
                        <div class="col-md-4 mb-3">
                            <div for="lastname" class="form-label">Last Name<span class="text-danger">*</span></div>
                            <input type="text" class="form-control text-uppercase" id="lastname" required value="<?= isset($info['last_name']) ? $info['last_name'] : '';?>">
                            <div class="invalid-feedback">
                                Please provide a valid last name.
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div for="birthday" class="form-label">Birthday<span class="text-danger">*</span></div>
                            <input type="date" class="form-control" id="birthday" required value="<?= isset($info['birthday']) ? $info['birthday'] : '';?>">
                            <div class="invalid-feedback">
                                Please provide a valid birthday.
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div for="place_birth" class="form-label">Place of Birth<span class="text-danger">*</span></div>
                            <input type="text" class="form-control text-uppercase" id="place_birth" required value="<?= isset($info['birth_place']) ? $info['birth_place'] : '';?>">
                            <div class="invalid-feedback">
                                Please provide a valid place of birth.
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div for="gender" class="form-label">Gender<span class="text-danger">*</span></div>
                            <select name="gender" id="gender" class="form-select" required>
                                <option value="">Please choose one</option>
                                <option value="male" <?= isset($info['gender']) && $info['gender'] === 'male' ? 'selected' : '' ?>>Male</option>
                                <option value="female" <?= isset($info['gender']) && $info['gender'] === 'female' ? 'selected' : '' ?>>Female</option>
                            </select>
                            <div class="invalid-feedback">
                                Please provide a valid gender.
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div for="civil_status" class="form-label">Civil Status<span class="text-danger">*</span></div>
                            <select name="civil_status" id="civil_status" class="form-select" required>
                                <option value="">Please choose one</option>
                                <option value="single" <?= isset($info['civil_status']) && $info['civil_status'] === 'single' ? 'selected' : '' ?>>Single</option>
                                <option value="married" <?= isset($info['civil_status']) && $info['civil_status'] === 'married' ? 'selected' : '' ?>>Married</option>
                                <option value="annulled" <?= isset($info['civil_status']) && $info['civil_status'] === 'annulled' ? 'selected' : '' ?>>Annulled</option>
                                <option value="separated" <?= isset($info['civil_status']) && $info['civil_status'] === 'separated' ? 'selected' : '' ?>>Separated</option>
                                <option value="widowed" <?= isset($info['civil_status']) && $info['civil_status'] === 'widowed' ? 'selected' : '' ?>>Widowed</option>
                            </select>
                            <div class="invalid-feedback">
                                Please provide a valid civil status.
                            </div>
                        </div>
                        <div class="col-md-12 mb-3">
                            <div for="spouse_name" class="form-label">Spouse Name</div>
                            <input type="text" class="form-control text-uppercase" id="spouse_name" value="<?= isset($info['spouse_name']) ? $info['spouse_name'] : '';?>" readonly>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div for="precinct_no" class="form-label">Precinct No.</div>
                            <input type="text" class="form-control" id="precinct_no" value="<?= isset($info['precinct_no']) ? $info['precinct_no'] : '';?>">
                        </div>
                        <div class="col-md-3 mb-3">
                            <div for="phone_no" class="form-label">Phone No.</div>
                            <input type="text" class="form-control" id="phone_no" value="<?= isset($info['phone_number']) ? $info['phone_number'] : '';?>">
                        </div>
                        <div class="col-md-3 mb-3">
                            <div for="mobile_no" class="form-label">Mobile No.<span class="text-danger">*</span></div>
                            <input type="text" class="form-control number-input" id="mobile_no" required value="<?= isset($info['mobile_number']) ? $info['mobile_number'] : '';?>">
                            <div class="invalid-feedback">
                                Please provide a valid mobile number.
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div for="email_address" class="form-label">Email Address<span class="text-danger">*</span></div>
                            <input type="email" class="form-control" id="email_address" required value="<?= isset($info['email_address']) ? $info['email_address'] : '';?>">
                            <div class="invalid-feedback">
                                Please provide a valid email address.
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div for="occupation" class="form-label">Occupation<span class="text-danger">*</span></div>
                            <select name="occupation" id="occupation" class="form-select" required>
                                <option value="">Please choose one</option>
                                <?php foreach($occupation as $row) : ?>
                                    <option value="<?= $row['name']?>" <?= isset($info['occupation']) && $info['occupation'] === $row['name'] ? 'selected' : '' ?>><?= $row['name']?></option>
                                <?php endforeach;?>
                            </select>
                            <div class="invalid-feedback">
                                Please provide a valid occupation.
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div for="other_occupation" class="form-label">Other Occupation</div>
                            <input type="text" class="form-control" id="other_occupation" readonly value="<?= isset($info['others_occupation']) ? $info['others_occupation'] : '';?>">
                            <div class="invalid-feedback">
                                Please provide a valid email address.
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div for="retiree" class="form-label">Are you retired?<span class="text-danger">*</span></div>
                            <select name="retiree" id="retiree" class="form-select" required>
                                <option value="">Please choose one</option>
                                <option value="yes" <?= isset($info['retiree']) && $info['retiree'] === 'yes' ? 'selected' : '' ?>>YES</option>
                                <option value="no" <?= isset($info['retiree']) && $info['retiree'] === 'no' ? 'selected' : '' ?>>NO</option>
                            </select>
                            <div class="invalid-feedback">
                                Please choose on the following options.
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div for="religion" class="form-label">Religion<span class="text-danger">*</span></div>
                            <select name="religion" id="religion" class="form-select" required>
                                <option value="">Please choose one</option>
                                <?php foreach($religion as $row) : ?>
                                    <option value="<?= $row['religion_name']?>" <?= isset($info['religion']) && $info['religion'] === $row['religion_name'] ? 'selected' : '' ?>><?= $row['religion_name']?></option>
                                <?php endforeach;?>
                            </select>
                            <div class="invalid-feedback">
                                Please provide a valid religion.
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div for="mother_name" class="form-label">Mother's Maiden Name<span class="text-danger">*</span></div>
                            <input type="text" class="form-control text-uppercase" id="mother_name" required value="<?= isset($info['mother_name']) ? $info['mother_name'] : '';?>">
                            <div class="invalid-feedback">
                                Please provide a valid mother's maiden name.
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div for="father_name" class="form-label">Father's Name<span class="text-danger">*</span></div>
                            <input type="text" class="form-control text-uppercase" id="father_name" required value="<?= isset($info['father_name']) ? $info['father_name'] : '';?>">
                            <div class="invalid-feedback">
                                Please provide a valid father's maiden name.
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div for="citizenship" class="form-label">Citizenship<span class="text-danger">*</span></div>
                            <select name="citizenship" id="citizenship" class="form-select" required>
                                <option value="">Please choose one</option>
                                <?php foreach($citizenship as $row) : ?>
                                    <option value="<?= $row['country_adjective']?>" <?= isset($info['citizenship']) && $info['citizenship'] === strtolower($row['country_adjective']) ? 'selected' : '' ?>><?= $row['country_adjective']?></option>
                                <?php endforeach;?>
                            </select>
                            <div class="invalid-feedback">
                                Please provide a valid citizenship.
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div for="province" class="form-label">Province<span class="text-danger">*</span></div>
                            <select name="province" id="province" class="form-select text-uppercase" required>
                                <option value="">Please choose one</option>
                                <?php foreach($province as $row) : ?>
                                    <option value="<?= $row['code']?>" <?= isset($info['province_code']) && $info['province_code'] === $row['code'] ? 'selected' : '' ?>><?= ucwords($row['name'])?></option>
                                <?php endforeach;?>
                            </select>
                            <div class="invalid-feedback">
                                Please provide a valid province.
                            </div>
                            <input type="hidden" id="province_name">
                        </div>
                        <div class="col-md-4 mb-3">
                            <div for="municipality" class="form-label">Municipality<span class="text-danger">*</span></div>
                            <select name="municipality" id="municipality" class="form-select" required>
                                <option value="">Please choose one</option>
                            </select>
                            <div class="invalid-feedback">
                                Please provide a valid municipality.
                            </div>
                            <input type="hidden" id="municipality_name">
                        </div>
                        <div class="col-md-4 mb-3">
                            <div for="barangay" class="form-label">Barangay<span class="text-danger">*</span></div>
                            <select name="barangay" id="barangay" class="form-select" required>
                                <option value="">Please choose one</option>
                            </select>
                            <div class="invalid-feedback">
                                Please provide a valid barangay.
                            </div>
                            <input type="hidden" id="barangay_name">
                        </div>
                        <div class="col-md-8 mb-3">
                            <div for="residence_address" class="form-label">Residence Address<span class="text-danger">*</span></div>
                            <input type="text" class="form-control text-uppercase" id="residence_address" required value="<?= isset($info['residence_address']) ? $info['residence_address'] : '';?>">
                            <div class="invalid-feedback">
                                Please provide a valid residence address.
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div for="date_residency" class="form-label">Date of Residency<span class="text-danger">*</span></div>
                            <input type="text" class="form-control" id="date_residency" required value="<?= isset($info['residence_when']) ? $info['residence_when'] : '';?>">
                            <div class="invalid-feedback">
                                Please provide a valid date of residency.
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="alert alert-dark"><i class="bi bi-person-lines-fill me-2"></i>EMERGENCY CONTACT INFORMATION</div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div for="contact_name" class="form-label">Name<span class="text-danger">*</span></div>
                            <input type="text" class="form-control text-uppercase" id="contact_name" required value="<?= isset($info['em_contact_name']) ? $info['em_contact_name'] : '';?>">
                            <div class="invalid-feedback">
                                Please provide a valid emergency contact.
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div for="relationship" class="form-label">Relationship<span class="text-danger">*</span></div>
                            <input type="text" class="form-control text-uppercase" id="relationship" required value="<?= isset($info['em_relationship']) ? $info['em_relationship'] : '';?>">
                            <div class="invalid-feedback">
                                Please provide a valid relationship.
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div for="contact_phone" class="form-label">Phone No.</div>
                            <input type="text" class="form-control" id="contact_phone" value="<?= isset($info['em_phone_no']) ? $info['em_phone_no'] : '';?>">
                        </div>
                        <div class="col-md-3 mb-3">
                            <div for="contact_mobile" class="form-label">Mobile No.<span class="text-danger">*</span></div>
                            <input type="text" class="form-control number-input" id="contact_mobile" required value="<?= isset($info['em_mobile_no']) ? $info['em_mobile_no'] : '';?>">
                            <div class="invalid-feedback">
                                Please provide a valid mobile number.
                            </div>
                        </div>
                        <div class="col-md-12 mb-3">
                            <div for="contact_address" class="form-label">Address<span class="text-danger">*</span></div>
                            <input type="text" class="form-control text-uppercase" id="contact_address" required value="<?= isset($info['em_address']) ? $info['em_address'] : '';?>">
                            <div class="invalid-feedback">
                                Please provide a valid address.
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="text-end">
                        <a href="<?= base_url('admin/active-member')?>" class="btn btn-secondary"><i class="bi bi-x-square me-2"></i>Cancel</a>
                        <button class="btn btn-primary" id="update_member_info"><i class="bi bi-floppy-fill me-2"></i>Save Changes</button>
                    </div>
                </form>
                
            </div>
        </div>
    </div>
</div>

<div class="loading-screen text-center" style="display: none;">
    <div class="spinner-border text-dark" role="status">

    </div>
</div>

<script>
    var present_muncode = "<?= isset($info['municipality_code']) ? $info['municipality_code'] : '';?>";
    var present_brgycode = "<?= isset($info['brgy_code']) ? $info['brgy_code'] : '';?>";

    $(document).ready(function() {
        
        $(document).on('change', '#occupation', function() {
            var occupation = $(this).val();

            if (occupation === 'Others') {
                $('#other_occupation').attr('readonly', false);
                $('#other_occupation').attr('required', true);
            } else {
                $('#other_occupation').attr('readonly', true);
                $('#other_occupation').attr('required', false);
                $('#other_occupation').val('');
            }
        });

        $(document).on('change', '#civil_status', function() {
            var civil_status = $(this).val();

            if (civil_status === 'married') {
                $('#spouse_name').attr('readonly', false);
                $('#spouse_name').attr('required', true);
            } else {
                $('#spouse_name').attr('readonly', true);
                $('#spouse_name').attr('required', false);
                $('#spouse_name').val('');
            }
        });

        $('#occupation').trigger('change');
        $('#civil_status').trigger('change');

        $(document).on('change', '#province', function() {
            var codes = $(this).val();
            var subss = codes.substring(0, 4);
            $.ajax({
                url: "<?= base_url('admin_portal/member_information/psgc_munc')?>",
                method: "POST",
                dataType: "json",
                data: {
                    codes: subss,
                    '_token': csrf_token_value,
                },
                success: function(data) {
                    var options = '<option value="">Select Municipal</option>';
                    $.each(data.data, function(index, item) {
                        options += '<option value="' + item.code + '">' + item.name
                            .toUpperCase() + '</option>';
                    });
                    $("#municipality").html(options);
                    $("#province_name").val($("#province").find("option:selected")
                        .text());
                    if (present_muncode) {
                        var mun_code = present_muncode;
                        $("#municipality").val(mun_code).change();
                    }
                }
            });
        });
        $('#province').trigger('change');

        $(document).on('change', '#municipality', function() {
            var $municipalitySelect = $(this);
            var codes = $municipalitySelect.val();
            
            if (!codes) {
                $("#barangay").html('<option value="">Select Barangay</option>');
                return;
            }
            
            var subss = codes.substring(0, 6);
            
            $.ajax({
                url: "<?= base_url('admin_portal/member_information/psgc_brgy')?>",
                method: "POST",
                data: {
                    codes: subss,
                    '_token': csrf_token_value,
                },
                success: function(data) {
                    var options = '<option value="">Select Barangay</option>';
                    $.each(data.data, function(index, item) {
                        options += '<option value="' + item.code + '">' + item.name.toUpperCase() + '</option>';
                    });
                    $("#barangay").html(options);
                    $("#municipality_name").val($municipalitySelect.find("option:selected").text());
                    
                    if (present_brgycode) {
                        $("#barangay").val(present_brgycode).trigger('change');
                        present_brgycode = ''; // Clear it after first use
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error loading barangays:', error);
                    $("#barangay").html('<option value="">Error loading barangays</option>');
                }
            });
        });

        $(document).on('change', '#barangay', function() {
            var selectedBarangayCode = $(this).val();
            var selectedBarangayName = $(this).find("option:selected").text();
            
            if (selectedBarangayCode) {
                $("#barangay_name").val(selectedBarangayName);
            } else {
                $("#barangay_name").val('');
            }
        });

        // Initial triggers
        $('#municipality').trigger('change');

        $(document).on('click', '#update_member_info', function() {
            event.preventDefault();
            event.stopPropagation();

            var form = $('#updateForm')[0];
            var formData = new FormData(form);
            formData.append('member_id', $('#member_id').val());
            formData.append('firstname', $('#firstname').val());
            formData.append('middlename', $('#middlename').val());
            formData.append('lastname', $('#lastname').val());
            formData.append('birthday', $('#birthday').val());
            formData.append('place_birth', $('#place_birth').val());
            formData.append('gender', $('#gender').val());
            formData.append('civil_status', $('#civil_status').val());
            formData.append('spouse_name', $('#spouse_name').val());
            formData.append('precinct_no', $('#precinct_no').val());
            formData.append('phone_no', $('#phone_no').val());
            formData.append('mobile_no', $('#mobile_no').val());
            formData.append('email_address', $('#email_address').val());
            formData.append('occupation', $('#occupation').val());
            formData.append('other_occupation', $('#other_occupation').val());
            formData.append('retiree', $('#retiree').val());
            formData.append('religion', $('#religion').val());
            formData.append('mother_name', $('#mother_name').val());
            formData.append('father_name', $('#father_name').val());
            formData.append('citizenship', $('#citizenship').val());
            formData.append('province', $('#province').val());
            formData.append('province_name', $('#province_name').val());
            formData.append('municipality', $('#municipality').val());
            formData.append('municipality_name', $('#municipality_name').val());
            formData.append('barangay', $('#barangay').val());
            formData.append('barangay_name', $('#barangay_name').val());
            formData.append('residence_address', $('#residence_address').val());
            formData.append('date_residency', $('#date_residency').val());
            formData.append('contact_name', $('#contact_name').val());
            formData.append('relationship', $('#relationship').val());
            formData.append('contact_phone', $('#contact_phone').val());
            formData.append('contact_mobile', $('#contact_mobile').val());
            formData.append('contact_address', $('#contact_address').val());
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
                            url: "<?= base_url('admin_portal/member_information/update_member_info');?>",
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
                                    setTimeout(() => {
                                        window.location.href = "<?= base_url('admin/active-member')?>";
                                    }, 3000);
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
    });
</script>