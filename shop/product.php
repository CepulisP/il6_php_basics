<?php

include 'helper.php';

$id = $_GET['id'];
$product = getProductById($id);

?>
<div class="products">
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
