<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Copy of Registration</title>
</head>

<style>
    .form-body {
        padding-left: 20px;
        padding-right: 20px;
        margin-top: 20px;
        font-size: 11px;
    }

    .tbl-info {
        font-size: 10px;
        width: 100%;
        color: #2d3436;
        border-collapse: collapse;
    }

    .tbl-info td {
        border: 1px solid #2d3436;
        padding: 5px;
    }

    .fw-bold {
        font-weight: bold;
    }

    .title {
        background: #636e72;
        margin-top: 15px;
        padding: 8px;
        color: #fff;
        font-weight: bold;
        border-radius: 5px;
        margin-bottom: 15px;
    }

    .reference {
        border: 2px solid #2d3436;
        padding: 10px;
        border-radius: 10px;
        margin-bottom: 15px;
    }

    .footer {
        background: #dfe6e9;
        height: 100%;
        padding:10px;
    }

    .sign {
        background: #fff;
    }
</style>

<body>
    <img src="<?= base_url('assets/images/pdf-header.jpg')?>" alt="">

    <div class="form-body">
        <table class="tbl-info">
            <tr>
                <td class="fw-bold" style="width:75px; background:#dfe6e9;">First Name</td>
                <td><?= isset($pdf_data['first_name']) ? $pdf_data['first_name'] : '';?></td>
                <td class="fw-bold" style="width:90px; background:#dfe6e9;">Middle Name</td>
                <td><?= isset($pdf_data['middle_name']) ? $pdf_data['middle_name'] : '';?></td>
                <td class="fw-bold" style="width:75px; background:#dfe6e9;">Last Name</td>
                <td><?= isset($pdf_data['last_name']) ? $pdf_data['last_name'] : '';?></td>
            </tr>

            <tr>
                <td class="fw-bold" style="width:75px; background:#dfe6e9;">Birthday</td>
                <td><?= isset($pdf_data['birthday']) ? date('F j, Y', strtotime($pdf_data['birthday'])) : '';?></td>
                <td class="fw-bold" style="width:90px; background:#dfe6e9;">Gender</td>
                <td>
                    <?php
                        $gender = isset($pdf_data['gender']) ? $pdf_data['gender'] : '';
                    ?>
                    <?= $gender === 'male' ? '▣' : '▢' ?> Male
                    <?= $gender === 'female' ? '▣' : '▢' ?> Female
                </td>
                <td class="fw-bold" style="width:85px; background:#dfe6e9;">Passport No.</td>
                <td><?= isset($pdf_data['passport_no']) ? $pdf_data['passport_no'] : '';?></td>
            </tr>

            <tr>
                <td class="fw-bold" style="width:75px; background:#dfe6e9;">Phone No.</td>
                <td><?= isset($pdf_data['phone_number']) ? $pdf_data['phone_number'] : '';?></td>
                <td class="fw-bold" style="width:90px; background:#dfe6e9;">Mobile No.</td>
                <td><?= isset($pdf_data['mobile_number']) ? $pdf_data['mobile_number'] : '';?></td>
                <td class="fw-bold" style="width:100px; background:#dfe6e9;">Email Address</td>
                <td><?= isset($pdf_data['email_address']) ? $pdf_data['email_address'] : '';?></td>
            </tr>
            
            <tr>
                <td class="fw-bold" style="width:75px; background:#dfe6e9;">Civil Status</td>
                <td colspan="3">
                    <?php
                        $civil_status = isset($pdf_data['civil_status']) ? $pdf_data['civil_status'] : '';
                    ?>
                    <?= $civil_status === 'single' ? '▣' : '▢' ?> Single
                    <?= $civil_status === 'married' ? '▣' : '▢' ?> Married
                    <?= $civil_status === 'annulled' ? '▣' : '▢' ?> Annulled
                    <?= $civil_status === 'separated' ? '▣' : '▢' ?> Separated
                    <?= $civil_status === 'widowed' ? '▣' : '▢' ?> Widowed
                </td>
                <td class="fw-bold" style="width:100px; background:#dfe6e9;">Spouse Name</td>
                <td><?= isset($pdf_data['spouse_name']) ? $pdf_data['spouse_name'] : '';?></td>
            </tr>

            <tr>
                <td class="fw-bold" style="width:75px; background:#dfe6e9;">Occupation</td>
                <td colspan="2">
                    <?= isset($pdf_data['occupation']) ? $pdf_data['occupation'] : '';?>
                </td>
                <td colspan="2" class="fw-bold" style="width:100px; background:#dfe6e9;">Are you a retiree?</td>
                <td>
                    <?php
                        $retiree = isset($pdf_data['retiree']) ? $pdf_data['retiree'] : '';
                    ?>
                    <?= $retiree === 'yes' ? '▣' : '▢' ?> YES
                    <?= $retiree === 'no' ? '▣' : '▢' ?> NO
                </td>
            </tr>
            <tr>
                <td class="fw-bold" style="width:75px; background:#dfe6e9;">Religion</td>
                <td>
                    <?= isset($pdf_data['religion']) ? $pdf_data['religion'] : '';?>
                </td>
                <td class="fw-bold" style="width:75px; background:#dfe6e9;">Mother's Name</td>
                <td>
                    <?= isset($pdf_data['mother_name']) ? $pdf_data['mother_name'] : '';?>
                </td>
                <td class="fw-bold" style="width:75px; background:#dfe6e9;">Father's Name</td>
                <td>
                    <?= isset($pdf_data['father_name']) ? $pdf_data['father_name'] : '';?>
                </td>
            </tr>
            <tr>
                <td class="fw-bold" style="width:75px; background:#dfe6e9;">TIN/SSS</td>
                <td colspan="5">
                    <?= isset($pdf_data['tin_sss_no']) ? $pdf_data['tin_sss_no'] : '';?>
                </td>
            </tr>

        </table>
        <div class="title">EMERGENCY CONTACT INFORMATION</div>
        <table class="tbl-info">
            <tr>
                <td class="fw-bold" style="width:75px; background:#dfe6e9;">Name</td>
                <td colspan="2">
                    <?= isset($pdf_data['em_contact_name']) ? $pdf_data['em_contact_name'] : '';?>
                </td>
                <td colspan="2" class="fw-bold" style="width:100px; background:#dfe6e9;">Relationship</td>
                <td>
                    <?= isset($pdf_data['em_relationship']) ? $pdf_data['em_relationship'] : '';?>
                </td>
            </tr>

            <tr>
                <td colspan="2" class="fw-bold" style="width:75px; background:#dfe6e9;">Phone No.</td>
                <td>
                    <?= isset($pdf_data['em_phone_no']) ? $pdf_data['em_phone_no'] : '';?>
                </td>
                <td colspan="2" class="fw-bold" style="width:75px; background:#dfe6e9;">Mobile No.</td>
                <td>
                    <?= isset($pdf_data['em_mobile_no']) ? $pdf_data['em_mobile_no'] : '';?>
                </td>
            </tr>

            <tr>
                <td colspan="2" class="fw-bold" style="width:75px; background:#dfe6e9;">Address</td>
                <td colspan="4">
                    <?= isset($pdf_data['em_address']) ? $pdf_data['em_address'] : '';?>
                </td>
            </tr>
        </table>
        <div class="title">REFERENCES</div>
        <div class="reference">
            <table class="tbl-info">
                <tr>
                    <td class="fw-bold" style="width:75px; background:#dfe6e9;">Name</td>
                    <td colspan="2">
                        <?= isset($pdf_data['first_ref_name']) ? $pdf_data['first_ref_name'] : '';?>
                    </td>
                    <td colspan="2" class="fw-bold" style="width:100px; background:#dfe6e9;">Relationship</td>
                    <td>
                        <?= isset($pdf_data['first_ref_relationship']) ? $pdf_data['first_ref_relationship'] : '';?>
                    </td>
                </tr>

                <tr>
                    <td colspan="2" class="fw-bold" style="width:75px; background:#dfe6e9;">Phone No.</td>
                    <td>
                        <?= isset($pdf_data['first_ref_phone_no']) ? $pdf_data['first_ref_phone_no'] : '';?>
                    </td>
                    <td colspan="2" class="fw-bold" style="width:75px; background:#dfe6e9;">Mobile No.</td>
                    <td>
                        <?= isset($pdf_data['first_ref_mobile_no']) ? $pdf_data['first_ref_mobile_no'] : '';?>
                    </td>
                </tr>

                <tr>
                    <td colspan="2" class="fw-bold" style="width:75px; background:#dfe6e9;">Address</td>
                    <td colspan="4">
                        <?= isset($pdf_data['first_ref_address']) ? $pdf_data['first_ref_address'] : '';?>
                    </td>
                </tr>
            </table>
        </div>
    </div>
    <div class="footer">
        <table style="width:100%; font-size:9px;">
            <tr>
                <td style="width:60%; text-align:justify;">
                    <p>Terms and Conditions of GOD’S People’s Initiative</p>
                    <br>
                    <p>Effective Date: <?= isset($pdf_data['date_created']) ? date('F j, Y', strtotime($pdf_data['date_created'])) : '';?></p>
                    <br>
                    <p>By using our website and services, you agree to the following terms and conditions. If you do not agree, please refrain from using our services.</p>
                    <br>
                    <p>
                        1. Acceptance of Terms
                        <p>
                            By accessing or using GPI’s services, you agree to comply with and be bound by these Terms and any applicable laws. We may update these Terms at any time, and your 
                            continued use of our services constitutes acceptance of those changes.
                        </p>
                    </p>
                    <br>
                    <p>
                        2. User Responsibilities
                        <p>
                            You agree not to misuse our website or services, including engaging in unlawful activities, uploading harmful content, or interfering with our services. You are responsible for 
                            maintaining the condentiality of your account information.
                        </p>
                    </p>
                    <br>
                    <p>
                        3. Intellectual Property
                        <p>
                            All content provided by GPI’, including text, images, logos, and software, is protected by copyright and intellectual property laws. You may not use or distribute this content 
                            without permission.
                        </p>
                    </p>
                    <br>
                    <p>
                        4. Limitation of Liability
                        <p>
                            To the fullest extent permitted by law, GPI is not liable for any indirect, incidental, or consequential damages arising from your use of our services.
                        </p>
                    </p>
                    <br>
                    <p>
                        5. Privacy
                        <p>
                            By using our services, you consent to our collection and use of your personal data as described in our Privacy Policy.
                        </p>
                    </p>

                </td>
                <td style="width:30px"></td>
                <td style="vertical-align:middle; text-align:center;">
                    <p style="font-size:11px;">Signature over Printed Name:</p>
                    <br><br>
                    <?php 
                        $img = '';
                        if ($pdf_data['signature'] != '') {
                            if(!empty($pdf_data['signature']) && file_exists('./assets/uploaded_file/member_application/signature/'.$pdf_data['signature'])){
                                // $img = base_url()."assets/uploaded_attachment/personal_photo/".$student->personal_photo;
                                $img = '<img  style="width:80px;" src="'.base_url()."/assets/uploaded_file/member_application/signature/".$pdf_data['signature'].'">';
                            }
                        }
                    ?>
                    <div><?= $img; ?></div>
                    <span class="fw-bold">
                        <?php
                            $first_name = isset($pdf_data['first_name']) ? $pdf_data['first_name'] : '';
                            $last_name = isset($pdf_data['last_name']) ? $pdf_data['last_name'] : '';

                            $printed_name = strtoupper($first_name).' '.strtoupper($last_name)
                        ?>
                        <?= $printed_name;?>
                    </span>
                    <br><br>
                    Date: <?= isset($pdf_data['date_sign']) ? date('F j, Y', strtotime($pdf_data['date_sign'])) : '';?>
                </td>
            </tr>
        </table>
    </div>
</body>
</html>