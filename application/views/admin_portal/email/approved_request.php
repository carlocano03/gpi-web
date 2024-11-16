<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Membership Application Approved</title>
</head>
<body>
    <p>Dear <?= $name_to ?>,</p>
    <br>

    <p>We are thrilled to inform you that your application for membership to God's People's Initiative (GPI) has been approved. Welcome to our community!</p>

    <p>Below are your account credentials, which you can use to access our member portal:</p>
    <ul>
        <li><b>Username:</b> <?= $username ?></li>
        <li><b>Password:</b> <?= $password ?></li>
    </ul>

    <p>We strongly recommend changing your password after logging in for the first time to ensure your account security.</p>

    <p>We are excited to have you as a part of our mission. Should you have any questions, feel free to reach out through the official contact channels provided on our website.</p>
    <br>
    <hr>
    <p>Thank You.</p>
    <b>God's People's Initiative</b><br>
    <p>*** This is a system-generated message. <b>DO NOT REPLY TO THIS EMAIL. ***</b></p>
</body>
</html>
