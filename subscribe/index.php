<!DOCTYPE html>
<html>
<head><title>Our website</title></head>
<body>
<h2>Subscribe</h2>
<form action="http://localhost/pamokos/subscribe/index.php" method="post">
    <input type="email" name="email" placeholder="name@mail.com">
    <input type="submit" value="Subscribe">
</form>
</body>
</html>

<?php

include 'helper.php';

if (isset($_POST['email'])) {
    $email = cleanEmail($_POST['email']);
    if (isEmailValid($email)) {
        if (isValueUniq($email, EMAIL_FIELD_KEY, 'emails.csv')) {
            $data = [];
            $data[] = [$email];
            writeToCsv($data, 'emails.csv');
            echo '<br>';
            echo '<b>Thank you for subscribing</b>';
        } else {
            echo '<br>';
            echo 'Email taken';
        }
    } else {
        echo '<br>';
        echo 'Check your email';
    }
}
