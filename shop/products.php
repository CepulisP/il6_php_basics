<?php

include 'helper.php';

$products = readFromCsv('products.csv');
$products = prepareProducts($products);
?>
<div class="grid">
<?php foreach ($products as $key => $product) : ?>
    <div class="product-wrap">
        <div class="name">
            <?php echo $product['name'] ?>
        </div>
        <div class="price">
            <?php echo $product['price'] . ' Eur' ?>
        </div>
        <?php if ($product['qty'] > 0): ?>
            <a href="<?php echo getProductURL($product['id']) ?>">To cart</a>
        <?php endif; ?>
    </div>
<?php if(($key + 1) % 3 == 0): ?>
    <br>
    <hr>
    <br>
<?php endif; ?>
<?php endforeach; ?>
</div>
