<?php include 'parts/header2.php' ?>
<?php

$email = $_POST['email'];
$pass = md5($_POST['password']);

$servername = "localhost";
$username = "root";
$password = "";
$dbName = "gumtree";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbName", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}

$sql = 'SELECT * FROM users WHERE email = "' . $email . '" AND password = "' . $pass . '"';
$rez = $conn->query($sql);
$user = $rez->fetchAll();

if (!empty($user)){

}else{
    echo 'Check email and password';
}

echo '<hr>';

?>
<?php include 'parts/footer.php' ?>