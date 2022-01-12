<!DOCTYPE html>
<html>
    <head>
        <title>Our website</title>
    </head>
    <body style="background-color: rgba(19,19,20,255);">
        <h2 style="color:white;">Subscribe</h2>
        <form action="http://localhost/pamokos/subscribe/index.php" method="post">
            <input type="email" name="email" placeholder="name@mail.com">
            <input type="submit" value="Subscribe">
        </form>
        <?php
        include 'helper.php';
        if (isset($_POST['email'])) {
            $email = cleanString($_POST['email']);
            if (isEmailValid($email) && isValueUniq($email, 'emails.csv')) {
                    writeToCsv($email, 'emails.csv');
                    echo '<br><b style="color:white;">Thank you for subscribing</b>';
                } else {
                    echo '<br><i style="color:white;">Email is invalid</i>';
            }
        }
        ?>
    </body>
</html>
