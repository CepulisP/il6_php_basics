<?php
include 'parts/header.php';

$servername = "localhost";
$username = "root";
$password = "";
$dbName = "gumtree";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbName", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "<b>Ad created</b>";
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}

if (isset($_POST['createAd'])) {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $price = $_POST['price'];
    $year = $_POST['year'];

    $sql = 'INSERT INTO ads (title, description, manufacturer_id, model_id, price, year, type_id, user_id)
            VALUES ("' . $title . '", "' . $content . '", 1, 1, ' . $price . ', ' . $year . ', 1, 1)';

    $conn->query($sql);
}

if (isset($_POST['createUser'])) {
    $name = $_POST['name'];
    $lastName = $_POST['lastName'];
    $email = cleanEmail($_POST['email']);
    $pass1 = $_POST['pass1'];
    $pass2 = $_POST['pass2'];
    $phone = $_POST['phone'];
    $cityId = intval($_POST['city']);

    if (isPasswordValid($pass1, $pass2) && isEmailValid($email)) {
        $pass = md5($pass1);
        $sql = 'INSERT INTO users (name, last_name, email, password, phone, city_id)
            VALUES ("' . $name . '", "' . $lastName . '", "' . $email . '", "' . $pass . '", "' . $phone . '", ' . $cityId . ')';
        $conn->query($sql);
    } else {
        echo 'check password and email';
    }
}

include 'parts/footer.php';

function isPasswordValid($pass1, $pass2)
{
    return $pass1 === $pass2 && strlen($pass1) > 3;
}

function isEmailValid($email)
{
    return strpos($email, '@') !== false;
}

function cleanEmail($email)
{
    return trim(strtolower($email));
}