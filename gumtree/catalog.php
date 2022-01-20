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
    <div class="wrapper">
        <?php foreach ($ads as $ad): ?>
            <div class="ads">
                <div class="title">
                    <?php echo '<h2>' . $ad['title'] . '</h2>' ?>
                </div>
                <div class="user_id">
                    <?php
                    echo
                        '<b>Posted by - </b>' . ($users[($ad['user_id'] - 1)]['name'])
                        . ' '
                        . ($users[($ad['user_id'] - 1)]['last_name'])
                        . ' from '
                        . ($cities[(($users[($ad['user_id'] - 1)]['city_id']) - 1)]['name']);
                    ?>
                </div>
                <div class="year">
                    <?php echo '<b>Year of manufacture - </b>' . $ad['year'] ?>
                </div>
                <div class="price">
                    <?php echo '<b>Price - </b>' . $ad['price'] . ' Eur' ?>
                </div>
                <br>
                <a href="http://localhost/pamokos/gumtree/ad.php?id=<?php echo $ad['id'] ?>"
                   style="color:white;">More</a>
                <hr>
            </div>
        <?php endforeach; ?>
    </div>
<?php include 'parts/footer.php' ?>