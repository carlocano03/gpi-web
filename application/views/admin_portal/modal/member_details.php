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
        <h5 class="offcanvas-title text-white" id="offcanvasBottomLabel"><i class="bi bi-person-rolodex me-2"></i>Member Information</h5>
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
                            <div class="complete_name">Carlo Pagdanganan Cano</div>
                        </div>   
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <div class="fw-bold">Birth Date:</div>
                            <div class="birthday">January 03, 1994</div>
                        </div>      
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <div class="fw-bold">Gender:</div>
                            <div class="gender">Male</div>
                        </div>   
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <div class="fw-bold">Passport No.:</div>
                            <div class="passport_no">123456789</div>
                        </div>  
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <div class="fw-bold">Civil Status:</div>
                            <div class="civil_status">Married</div>
                        </div> 
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <div class="fw-bold">Spouse Name:</div>
                            <div class="spouse_name">Ana Marie Cano</div>
                        </div> 
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <div class="fw-bold">Occupation:</div>
                            <div class="occupation">Web Developer</div>
                        </div>   
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <div class="fw-bold">Are you a retiree?</div>
                            <div class="retiree">No</div>
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

                        <div class="divider">Business Information</div> 

                        <div class="mb-2">
                            <div class="fw-bold">Business Address:</div>
                            <div class="business_address"></div>
                        </div> 
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <div class="fw-bold">Business Phone No.:</div>
                            <div class="business_phone"></div>
                        </div> 
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="fw-bold">Business Mobile No.:</div>
                            <div class="business_mobile"></div>
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

            <div class="col-12 mb-3">
                <div class="overview-card">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div class="d-flex align-items-center gap-2">
                            <img class="overview-card__icon"
                                src="<?php echo base_url('assets/images/admin/contact-reference.png'); ?>" alt="
								Registration">
                            <h1 class="overview-card__title mb-0">Contact References</h1>
                        </div>
                    </div>
                    <div>
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <div class="fw-bold">Name:</div>
                            <div class="ref_name"></div>
                        </div> 
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <div class="fw-bold">Relationship:</div>
                            <div class="ref_relationship"></div>
                        </div> 
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <div class="fw-bold">Phone No.:</div>
                            <div class="ref_phone"></div>
                        </div> 
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <div class="fw-bold">Mobile No.:</div>
                            <div class="ref_mobile"></div>
                        </div> 
                        <div>
                            <div class="fw-bold">Address:</div>
                            <div class="ref_address"></div>
                        </div> 

                        <div class="divider">Additional Reference</div> 

                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <div class="fw-bold">Name:</div>
                            <div class="add_ref_name"></div>
                        </div> 
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <div class="fw-bold">Relationship:</div>
                            <div class="add_ref_relationship"></div>
                        </div> 
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <div class="fw-bold">Phone No.:</div>
                            <div class="add_ref_phone"></div>
                        </div> 
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <div class="fw-bold">Mobile No.:</div>
                            <div class="add_ref_mobile"></div>
                        </div> 
                        <div>
                            <div class="fw-bold">Address:</div>
                            <div class="add_ref_address"></div>
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
                            <div class="fw-bold">Passport:</div>
                            <button class="btn btn-outline-primary btn-sm download_passport"><i class="bi bi-download"></i></button>
                            <span class="no_passport"></span>
                            <input type="hidden" class="passport_attachment">
                        </div> 
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
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>