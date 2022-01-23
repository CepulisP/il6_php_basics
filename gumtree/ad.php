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

$id = $_GET['id'];

$sql = 'SELECT * FROM cities';
$rez = $conn->query($sql);
$cities = $rez->fetchAll();

$sql = 'SELECT * FROM ads WHERE id =' . $id;
$rez = $conn->query($sql);
$ads = $rez->fetchAll();

$sql = 'SELECT * FROM users';
$rez = $conn->query($sql);
$users = $rez->fetchAll();

?>

    <div class="wrapper">
        <div class="title">
            <?php echo '<h2>' . $ads[0]['title'] . '</h2>' ?>
        </div>
        <div class="user_id">
            <?php
            echo
                '<b>Posted by - </b>' . ($users[($ads[0]['user_id'] - 1)]['name'])
                . ' '
                . ($users[($ads[0]['user_id'] - 1)]['last_name'])
                . ' from '
                . ($cities[(($users[($ads[0]['user_id'] - 1)]['city_id']) - 1)]['name']);
            ?>
        </div>
        <br>
        <div class="description">
            <?php echo $ads[0]['description'] ?>
        </div>
        <br>
        <div class="manufacturer">
            <?php echo '<b>Manufacturer - </b>' . $ads[0]['manufacturer_id'] ?>
        </div>
        <div class="model">
            <?php echo '<b>Model - </b>' . $ads[0]['model_id'] ?>
        </div>
        <div class="price">
            <?php echo '<b>Price - </b>' . $ads[0]['price'] . ' Eur' ?>
        </div>
        <div class="year">
            <?php echo '<b>Year of manufacture - </b>' . $ads[0]['year'] ?>
        </div>
        <div class="type_id">
            <?php echo '<b>Type - </b>' . $ads[0]['type_id'] ?>
        </div>
        <br>
    </div>

<?php include 'parts/footer.php' ?>