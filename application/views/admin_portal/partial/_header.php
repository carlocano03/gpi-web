<!DOCTYPE html>
<html lang="en" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-light" data-assets-path="../assets/"
    data-template="vertical-menu-template-free">

<head>
    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>GPI | Admin Portal</title>

    <meta name="description" content="" />


    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="<?= base_url('assets/images/logo-no-bg.png');?>" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
        rel="stylesheet" />

    <!-- Icons. Uncomment required icon fonts -->
    <link rel="stylesheet" href="<?= base_url('assets/vendor/fonts/boxicons.css');?>" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <!-- Core CSS -->
    <link rel="stylesheet" href="<?= base_url('assets/vendor/css/core.css');?>" class="template-customizer-core-css" />
    <link rel="stylesheet" href="<?= base_url('assets/vendor/css/theme-default.css');?>"
        class="template-customizer-theme-css" />
    <link rel="stylesheet" href="<?= base_url('assets/css/custom-style.css');?>" />
    <link rel="stylesheet" href="<?= base_url('assets/css/jquery.toast.css');?>" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="<?= base_url('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css');?>" />

    <link rel="stylesheet" href="<?= base_url('assets/vendor/libs/apex-charts/apex-charts.css');?>" />

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
        integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.css" rel="stylesheet"/>
    <!-- Page CSS -->

    <!-- Helpers -->
    <script src="<?= base_url('assets/vendor/js/helpers.js');?>"></script>

    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="<?= base_url('assets/js/config.js');?>"></script>

    <!-- Core JS -->
    <!-- build:js assets/vendor/js/core.js -->
    <script src="<?= base_url('assets/vendor/libs/jquery/jquery.js');?>"></script>
    <script src="<?= base_url('assets/vendor/libs/popper/popper.js');?>"></script>
    <script src="<?= base_url('assets/vendor/js/bootstrap.js');?>"></script>
    <script src="<?= base_url('assets/js/jquery.toast.js');?>"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.10.1/dist/sweetalert2.all.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/countup.js/1.7.1/countUp.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.js"></script>
    <!--   CSRF Token   -->
    <script src="<?php echo base_url('assets/js/form-validate.js'); ?>"></script>
    <script src="<?php echo base_url('assets/js/csrf_generator.js'); ?>"></script>
    <script>
    var csrf_token_name = "<?php echo $this->security->get_csrf_token_name(); ?>";
    var csrf_token_value = "<?php echo $this->security->get_csrf_hash(); ?>";
    var baseURL = "<?= base_url();?>";
    </script>
    <?php
        // Load specified header library
        if (isset($header_contents)) {
            foreach ($header_contents as $header_cont) :
            echo $header_cont . "\n";
            endforeach;
        }
    ?>

    <style>
    /* For WebKit browsers */
    ::-webkit-scrollbar {
        width: 12px;
        /* Width of the scrollbar */
    }

    ::-webkit-scrollbar-track {
        background: #f1f1f1;
        /* Background of the scrollbar track */
    }

    ::-webkit-scrollbar-thumb {
        background: #888;
        /* Color of the scrollbar thumb */
        border-radius: 10px;
        /* Rounded corners */
    }

    ::-webkit-scrollbar-thumb:hover {
        background: #555;
        /* Color of the scrollbar thumb when hovered */
    }

    /* For Firefox */
    html {
        scrollbar-width: thin;
        /* 'auto' or 'thin' */
        scrollbar-color: #888 #f1f1f1;
        /* thumb color, track color */
    }

    /* CSS Reset */
    /*
	1. Use a more-intuitive box-sizing model.
  */
    *,
    *::before,
    *::after {
        box-sizing: border-box;
    }

    /*
	  2. Remove default margin
	*/
    * {
        margin: 0;
    }

    /*
	  Typographic tweaks!
	  3. Add accessible line-height
	  4. Improve text rendering
	*/
    body {
        line-height: 1.5;
        -webkit-font-smoothing: antialiased;
    }

    /*
	  5. Improve media defaults
	*/
    img,
    picture,
    video,
    canvas,
    svg {
        display: block;
        max-width: 100%;
    }

    /*
	  6. Remove built-in form typography styles
	*/
    input,
    button,
    textarea,
    select {
        font: inherit;
    }

    /*
	  7. Avoid text overflows
	*/
    p,
    h1,
    h2,
    h3,
    h4,
    h5,
    h6 {
        overflow-wrap: break-word;
    }

    p {
        margin: 0;
    }

    /*
	  8. Create a root stacking context
	*/

    #root,
    #__next {
        isolation: isolate;
    }

    ul {
        list-style-type: none;
    }

    li {
        cursor: pointer;
    }

    /* Font */
    .roboto-regular {
        font-family: "Roboto", sans-serif;
        font-weight: 400;
        font-style: normal;
    }

    .roboto-medium {
        font-family: "Roboto", sans-serif;
        font-weight: 500;
        font-style: normal;
    }

    .roboto-bold {
        font-family: "Roboto", sans-serif;
        font-weight: 700;
        font-style: normal;
    }

    .roboto-black {
        font-family: "Roboto", sans-serif;
        font-weight: 900;
        font-style: normal;
    }

    body {
        font-family: "Roboto", sans-serif;
    }


    .bg-primary {
        background: linear-gradient(to right, #434875, #b18647) !important;
    }

    .text-title {
        color: #3a352d;
    }

    .text-paragraph {
        color: #585249;
    }


    .bg-light {
        background-color: #f9f8f6;
    }
    </style>


</head>

<body>

    <?php
  
	$this->load->view('admin_portal/partial/_sidebar');
    $this->load->view('admin_portal/partial/_navbar');
?>
