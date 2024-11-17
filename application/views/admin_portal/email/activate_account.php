<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Membership Account Activated</title>
</head>
<body>
    <p>Dear <?= $name_to ?></p>
    <br>

    <p>We are delighted to inform you that your membership account with God's People's Initiative (GPI) has been successfully activated. You are now officially part of our community, and we look forward to your active participation in our initiatives.</p>

    <p>If you need to reset your credentials (username or password), please open the app, click on "Forgot Password," and input the email address provided below:</p>

    <p>
        <b>Email Address: </b><?= $email_address ?>
    </p>

    <p>For security reasons, please ensure that you do not share your account details with others.</p>
    <br>
    <hr>
    <p>Thank You.</p>
    <b>God's People's Initiative</b><br>
    <p>*** This is a system-generated message. <b>DO NOT REPLY TO THIS EMAIL. ***</b></p>
</body>
</html>
