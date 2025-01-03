<style>
    .divider {
        background: #344489;
        color: #fff;
        padding: 8px;
        border-radius: 8px;
        font-weight:600;
    }

    .offcanvas-body {
        overflow-y: auto; /* Ensure the scrollbar appears */
        scrollbar-width: thin; /* Firefox: Thin scrollbar */
        scrollbar-color: #888 #f1f1f1; /* Firefox: Thumb and track colors */
    }

    .offcanvas-body::-webkit-scrollbar {
        width: 8px !important; /* Adjust the width as needed */
    }

    .offcanvas-body::-webkit-scrollbar-thumb {
        background-color: red; /* Color of the scrollbar thumb */
        border-radius: 8px !important; /* Round edges */
    }

    .offcanvas-body::-webkit-scrollbar-thumb:hover {
        background-color: #555 !important; /* Color when hovering */
    }

    .offcanvas-body::-webkit-scrollbar-track {
        background: #f1f1f1 !important; /* Background of the scrollbar track */
    }
</style>
<div class="offcanvas offcanvas-end shadow" data-bs-backdrop="false" tabindex="-1" id="offcanvasBottom" aria-labelledby="offcanvasBottomLabel">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title text-white" id="offcanvasBottomLabel"><i class="bi bi-person-rolodex me-2"></i>Member Application Details</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body small">
        <div class="row">
            <div class="col-12 mb-3">
                <div class="overview-card">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div class="d-flex align-items-center gap-2">
                            <img class="overview-card__icon"
                                src="<?php echo base_url('assets/images/admin/personal-info.png'); ?>" alt="
								Registration">
                            <h1 class="overview-card__title mb-0">Personal Information</h1>
                        </div>
                    </div>
                    <div>
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <div class="fw-bold">Complete Name:</div>
                            <div class="complete_name"></div>
                        </div>   
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <div class="fw-bold">Birth Date:</div>
                            <div class="birthday"></div>
                        </div>  
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <div class="fw-bold">Place of Birth:</div>
                            <div class="birth_place"></div>
                        </div>       
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <div class="fw-bold">Gender:</div>
                            <div class="gender"></div>
                        </div>   
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <div class="fw-bold">Precinct No.:</div>
                            <div class="precinct_no"></div>
                        </div>  
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <div class="fw-bold">Civil Status:</div>
                            <div class="civil_status"></div>
                        </div> 
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <div class="fw-bold">Spouse Name:</div>
                            <div class="spouse_name"></div>
                        </div> 
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <div class="fw-bold">Occupation:</div>
                            <div class="occupation"></div>
                        </div>   
                        <div class="d-flex align-items-center justify-content-between mb-2" id="other_occupation">
                            <div class="fw-bold">Other Occupation:</div>
                            <div class="other"></div>
                        </div>   
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <div class="fw-bold">Are you a retiree?</div>
                            <div class="retiree"></div>
                        </div>   
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <div class="fw-bold">Religion:</div>
                            <div class="religion"></div>
                        </div>    
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <div class="fw-bold">Citizenship:</div>
                            <div class="citizenship"></div>
                        </div>  
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <div class="fw-bold">Mother's Maiden Name:</div>
                            <div class="mother_name"></div>
                        </div>
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <div class="fw-bold">Father's Name:</div>
                            <div class="father_name"></div>
                        </div>  

                        <div class="divider">Address Information</div> 

                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <div class="fw-bold">Province:</div>
                            <div class="province"></div>
                        </div>  
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <div class="fw-bold">Municipality:</div>
                            <div class="municipality"></div>
                        </div>  
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <div class="fw-bold">Barangay:</div>
                            <div class="barangay"></div>
                        </div>  
                        <hr>
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <div class="fw-bold">Date of Residency:</div>
                            <div class="date_residency"></div>
                        </div> 
                        <div>
                            <div class="fw-bold">Residence Address:</div>
                            <div class="residence_address"></div>
                        </div> 

                        <div class="divider">Contact Details</div> 

                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <div class="fw-bold">Phone No.:</div>
                            <div class="phone_no"></div>
                        </div>  
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <div class="fw-bold">Mobile No.:</div>
                            <div class="mobile_no"></div>
                        </div> 
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <div class="fw-bold">Email Address:</div>
                            <div class="email_address"></div>
                        </div> 
                    </div>
                </div>
            </div>
    
            <div class="col-12 mb-3">
                <div class="overview-card">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div class="d-flex align-items-center gap-2">
                            <img class="overview-card__icon"
                                src="<?php echo base_url('assets/images/admin/emergency-contact.png'); ?>" alt="
								Registration">
                            <h1 class="overview-card__title mb-0">Emergency Contact Information</h1>
                        </div>
                    </div>
                    <div>
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <div class="fw-bold">Name:</div>
                            <div class="em_contact_name"></div>
                        </div> 
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <div class="fw-bold">Relationship:</div>
                            <div class="em_relationship"></div>
                        </div> 
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <div class="fw-bold">Phone No.:</div>
                            <div class="em_phone"></div>
                        </div> 
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <div class="fw-bold">Mobile No.:</div>
                            <div class="em_mobile"></div>
                        </div> 
                        <div>
                            <div class="fw-bold">Address:</div>
                            <div class="em_address"></div>
                        </div> 
                    </div>
                </div>
            </div>

            <div class="col-12">
                <div class="overview-card">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div class="d-flex align-items-center gap-2">
                            <img class="overview-card__icon"
                                src="<?php echo base_url('assets/images/admin/attachment.png'); ?>" alt="
								Registration">
                            <h1 class="overview-card__title mb-0">Attachment</h1>
                        </div>
                    </div>
                    <div>
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <div class="fw-bold">Personal Picture:</div>
                            <button class="btn btn-outline-primary btn-sm download_selfie"><i class="bi bi-download"></i></button>
                            <span class="no_selfie"></span>
                            <input type="hidden" class="selfie_attachment">
                        </div> 
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <div class="fw-bold">Signature:</div>
                            <button class="btn btn-outline-primary btn-sm download_signature"><i class="bi bi-download"></i></button>
                            <span class="no_sign"></span>
                            <input type="hidden" class="signature_attachment">
                        </div> 
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <div class="fw-bold">Government ID:</div>
                            <button class="btn btn-outline-primary btn-sm download_id"><i class="bi bi-download"></i></button>
                            <span class="no_id"></span>
                            <input type="hidden" class="id_attachment">
                        </div> 
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <input type="hidden" class="application_id">
        <button type="button" class="btn btn-danger decline_request"><i class="bi bi-x-square me-2"></i>Decline</button>
        <button type="button" class="btn btn-primary approve_modal"><i class="bi bi-check2-square me-2"></i>Approve Request</button>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="approveModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel"><i class="bi bi-person-fill-add me-2"></i>Apply Membership Type</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="member_type" class="form-label">Member Type</label>
                    <select name="member_type" id="member_type" class="form-select">
                        <option value="">Please choose on the following options</option>
                        <?php foreach($member_type as $row) : ?>
                            <option value="<?= $row->user_type_id?>"><?= $row->name_type?></option>
                        <?php endforeach;?>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="bi bi-x-square me-2"></i>Close</button>
                <button type="button" class="btn btn-primary" id="approve_request"><i class="bi bi-floppy-fill me-2"></i>Save changes</button>
            </div>
        </div>
    </div>
</div>