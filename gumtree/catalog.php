<?php include 'parts/header.php' ?>
<?php

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

$sql = 'SELECT * FROM cities';
$rez = $conn->query($sql);
$cities = $rez->fetchAll();

$sql = 'SELECT * FROM ads';
$rez = $conn->query($sql);
$ads = $rez->fetchAll();

$sql = 'SELECT * FROM users';
$rez = $conn->query($sql);
$users = $rez->fetchAll();

?>
<?php foreach ($ads as $ad): ?>
    <div class="ads">
        <div class="title">
            <?php echo '<h2>'.$ad['title'].'</h2>'?>
        </div>
        <div class="description">
            <?php echo $ad['description']?>
        </div>
        <br>
        <div class="manufacturer">
            <?php echo '<b>Manufacturer - </b>'.$ad['manufacturer_id'].'</b>'?>
        </div>
        <div class="model">
            <?php echo '<b>Model - </b>'.$ad['model_id'].'</b>'?>
        </div>
        <div class="price">
            <?php echo '<b>Price - </b>'.$ad['price'].'</b>'?>
        </div>
        <div class="year">
            <?php echo '<b>Year of manufacture - </b>'.$ad['year'].'</b>'?>
        </div>
        <div class="type_id">
            <?php echo '<b>Type - </b>'.$ad['type_id']?>
        </div>
        <div class="user_id">
            <?php echo '<b>User - </b>'.($users[$ad['user_id']]['name']).' from '.($cities[$users[$ad['user_id']]['city_id']]['name']).'</b>'?>
        </div>
    </div>
<?php endforeach; ?>
<?php include 'parts/footer.php' ?>