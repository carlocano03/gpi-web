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
                <td>Carlo</td>
                <td class="fw-bold" style="width:90px; background:#dfe6e9;">Middle Name</td>
                <td>Pagdanganan</td>
                <td class="fw-bold" style="width:75px; background:#dfe6e9;">Last Name</td>
                <td>Cano</td>
            </tr>

            <tr>
                <td class="fw-bold" style="width:75px; background:#dfe6e9;">Birthday</td>
                <td>January 03, 1994</td>
                <td class="fw-bold" style="width:90px; background:#dfe6e9;">Gender</td>
                <td>
                    <input type="radio"> Male
                    <input type="radio"> Female
                </td>
                <td class="fw-bold" style="width:85px; background:#dfe6e9;">Passport No.</td>
                <td>12345678</td>
            </tr>

            <tr>
                <td class="fw-bold" style="width:75px; background:#dfe6e9;">Phone No.</td>
                <td>00000</td>
                <td class="fw-bold" style="width:90px; background:#dfe6e9;">Mobile No.</td>
                <td>09061798559</td>
                <td class="fw-bold" style="width:100px; background:#dfe6e9;">Email Address</td>
                <td>carlocano03@gmail.com</td>
            </tr>
            
            <tr>
                <td class="fw-bold" style="width:75px; background:#dfe6e9;">Civil Status</td>
                <td>
                    <input type="radio"> Single
                    <input type="radio"> Married
                </td>
                <td class="fw-bold" style="width:100px; background:#dfe6e9;">Spouse Name</td>
                <td colspan="3">carlocano03@gmail.com</td>
            </tr>

            <tr>
                <td class="fw-bold" style="width:75px; background:#dfe6e9;">Occupation</td>
                <td colspan="2">
                    Web Developer
                </td>
                <td colspan="2" class="fw-bold" style="width:100px; background:#dfe6e9;">Are you a retiree?</td>
                <td>
                    <input type="radio"> YES
                    <input type="radio"> NO
                </td>
            </tr>

            <tr>
                <td colspan="2" class="fw-bold" style="width:75px; background:#dfe6e9;">Business Address</td>
                <td colspan="4">
                    Sample Address
                </td>
            </tr>

            <tr>
                <td colspan="2" class="fw-bold" style="width:75px; background:#dfe6e9;">Business Phone No.</td>
                <td>
                    0000
                </td>
                <td colspan="2" class="fw-bold" style="width:75px; background:#dfe6e9;">Business Mobile No.</td>
                <td>
                    09061798559
                </td>
            </tr>
        </table>
        <div class="title">EMERGENCY CONTACT INFORMATION</div>
        <table class="tbl-info">
            <tr>
                <td class="fw-bold" style="width:75px; background:#dfe6e9;">Name</td>
                <td colspan="2">
                    Ana Marie Cano
                </td>
                <td colspan="2" class="fw-bold" style="width:100px; background:#dfe6e9;">Relationship</td>
                <td>
                    Spouse
                </td>
            </tr>

            <tr>
                <td colspan="2" class="fw-bold" style="width:75px; background:#dfe6e9;">Phone No.</td>
                <td>
                    0000
                </td>
                <td colspan="2" class="fw-bold" style="width:75px; background:#dfe6e9;">Mobile No.</td>
                <td>
                    09061798559
                </td>
            </tr>

            <tr>
                <td colspan="2" class="fw-bold" style="width:75px; background:#dfe6e9;">Address</td>
                <td colspan="4">
                    Sample Address
                </td>
            </tr>
        </table>
        <div class="title">REFERENCES</div>
        <div class="reference">
            <table class="tbl-info">
                <tr>
                    <td class="fw-bold" style="width:75px; background:#dfe6e9;">Name</td>
                    <td colspan="2">
                        Ana Marie Cano
                    </td>
                    <td colspan="2" class="fw-bold" style="width:100px; background:#dfe6e9;">Relationship</td>
                    <td>
                        Spouse
                    </td>
                </tr>

                <tr>
                    <td colspan="2" class="fw-bold" style="width:75px; background:#dfe6e9;">Phone No.</td>
                    <td>
                        0000
                    </td>
                    <td colspan="2" class="fw-bold" style="width:75px; background:#dfe6e9;">Mobile No.</td>
                    <td>
                        09061798559
                    </td>
                </tr>

                <tr>
                    <td colspan="2" class="fw-bold" style="width:75px; background:#dfe6e9;">Address</td>
                    <td colspan="4">
                        Sample Address
                    </td>
                </tr>
            </table>
        </div>
        <div class="reference">
            <table class="tbl-info">
                <tr>
                    <td class="fw-bold" style="width:75px; background:#dfe6e9;">Name</td>
                    <td colspan="2">
                        Ana Marie Cano
                    </td>
                    <td colspan="2" class="fw-bold" style="width:100px; background:#dfe6e9;">Relationship</td>
                    <td>
                        Spouse
                    </td>
                </tr>

                <tr>
                    <td colspan="2" class="fw-bold" style="width:75px; background:#dfe6e9;">Phone No.</td>
                    <td>
                        0000
                    </td>
                    <td colspan="2" class="fw-bold" style="width:75px; background:#dfe6e9;">Mobile No.</td>
                    <td>
                        09061798559
                    </td>
                </tr>

                <tr>
                    <td colspan="2" class="fw-bold" style="width:75px; background:#dfe6e9;">Address</td>
                    <td colspan="4">
                        Sample Address
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
                    <p>Effective Date: November 15, 2024</p>
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
                        4. Intellectual Property
                        <p>
                            All content provided by GPI’, including text, images, logos, and software, is protected by copyright and intellectual property laws. You may not use or distribute this content 
                            without permission.
                        </p>
                    </p>
                    <br>
                    <p>
                        5. Limitation of Liability
                        <p>
                            To the fullest extent permitted by law, GPI is not liable for any indirect, incidental, or consequential damages arising from your use of our services.
                        </p>
                    </p>
                    <br>
                    <p>
                        6. Privacy
                        <p>
                            By using our services, you consent to our collection and use of your personal data as described in our Privacy Policy.
                        </p>
                    </p>

                </td>
                <td style="width:30px"></td>
                <td style="vertical-align:middle;">
                    <p style="font-size:11px;">Signature over Printed Name:</p>
                    <br><br>
                    <span class="fw-bold">CARLO PAGDANGANAN CANO</span>
                    <br><br>
                    Date: November 15, 2024
                </td>
            </tr>
        </table>
    </div>
</body>
</html>