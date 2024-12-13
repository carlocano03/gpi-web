<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Staff Credentials</title>
</head>
<body>
    <p>Dear <?= $name_to ?>,</p>
    <br>

    <p>We are pleased to inform you that your access as an admin staff to the God's People's Initiative (GPI) system has been successfully set up.</p>

    <p>Below are your account credentials, which you can use to access the admin portal:</p>
    <ul>
        <li><b>Username:</b> <?= $username ?></li>
        <li><b>Password:</b> <?= $password ?></li>
        <li><b>Login URL:</b> <a href="<?= $login_url ?>">Login URL</a></li>
    </ul>

    <p>For security reasons, we strongly recommend changing your password after logging in for the first time.</p>

    <p>We are happy to have you as part of our administrative team. If you have any questions or need further assistance, please contact the support team through the official channels provided on our website.</p>
    <br>
    <hr>
    <p>Thank You.</p>
    <b>God's People's Initiative</b><br>
    <p>*** This is a system-generated message. <b>DO NOT REPLY TO THIS EMAIL. ***</b></p>
</body>
</html>
