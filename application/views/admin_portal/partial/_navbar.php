<style>
.navbar {
    padding: 9px 0;
    border-right: 1px solid #E4E7EB;
}
</style>
<!-- Layout container -->
<div class="layout-page">
    <!-- Navbar -->



    <nav class="layout-navbar navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme"
        style="position: relative; z-index: 1000;">
        <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
            <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
                <i class="bx bx-menu bx-sm"></i>
            </a>
        </div>


        <div class="d-flex align-items-center gap-2">
            <img src="<?php echo base_url('assets/images/dashboard/system.png'); ?>" alt="" style="width:32px" />
            <h5 class="m-0 ms-2 fw-bold text-nowrap header-title">God's People's Initiative Portal</h5>
        </div>

        <div class="container d-flex justify-content-end">

            <a class=" nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
                <img src="<?= base_url('assets/images/admin/profile.png');?>" alt class="w-px-40 h-auto rounded-circle" />
            </a>


            <ul class="dropdown-menu dropdown-menu-end" style="position:absolute; z-index: 1050;">
                <li>
                    <a class="dropdown-item" href="#">
                        <div class="d-flex">
                            <div class="flex-shrink-0 me-3">
                                <div class="avatar avatar-online">
                                    <img src="<?= base_url('assets/images/admin/profile.png');?>" alt
                                        class="w-px-40 h-auto rounded-circle" />
                                </div>
                            </div>
                            <div class="flex-grow-1">
                                <span class="fw-semibold d-block"><?= $this->session->userdata('adminIn')['fullname']?></span>
                                <small class="text-muted"><i><?= $this->session->userdata('adminIn')['email_add']?></i></small>
                            </div>
                        </div>
                    </a>
                </li>
                <li>
                    <div class="dropdown-divider"></div>
                </li>
                <li>
                    <a class="dropdown-item" href="#passwordModal" data-bs-toggle="modal">
                        <i class="bx bx-cog me-2"></i>
                        <span class="align-middle">Change Password</span>
                    </a>
                </li>
                <li>
                    <div class="dropdown-divider"></div>
                </li>
                <li>
                    <a class="dropdown-item" href="<?= base_url('admin_portal/login/logout/adminIn');?>">
                        <i class="bx bx-power-off me-2"></i>
                        <span class="align-middle">Log Out</span>
                    </a>
                </li>
            </ul>
        </div>
    </nav>
    <!-- / Navbar -->