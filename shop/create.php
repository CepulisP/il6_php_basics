<?php

include 'helper.php';

$name = $_POST['name'];
$sku = $_POST['sku'];
$price = $_POST['price'];
$qty = $_POST['qty'];

$data = readFromCsv('products.csv');
echo count($data);
