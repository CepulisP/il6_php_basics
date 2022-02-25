<?php
//
//$id = 18;
//$table = 'users';
//$data = [
//    'name' => 'john',
//    'last_name' => 'john',
//    'email' => 'john',
//    'password' => 'john',
//    'phone' => 'john',
//    'city_id' => 'john'
//];
//
//$line = '';
//$line .= 'UPDATE ' . $table . ' SET ';
//$i = 0;
//foreach ($data as $key => $element) {
//    $count = count($data);
//    $i++;
//    if ($i < $count) {
//        $line .= $key . ' = "' . $element . '", ';
//    } else {
//        $line .= $key . ' = "' . $element . '"';
//    }
//}
//$line .= ' WHERE id = ' . $id;
//echo $line . '<br>';
//
//$x = 1;
//
//if (empty($x)) {
//    echo 'true';
//} else {
//    echo 'false';
//}
//
//$arr = [1,2,3,4,5,6,7,8,9];
//array_splice($arr,5);
//print_r($arr);
?>
<div class="order-wrapper">
    <a href="<?php echo '/' ?>?order_by=id&clause=ASC">Numatytasis rikiavimas</a>
    <a href="<?php echo '/' ?>?order_by=created_at&clause=ASC">Seniausi pirmiau</a>
    <a href="<?php echo '/' ?>?order_by=created_at&clause=DESC">Naujausi pirmiau</a>
    <a href="<?php echo '/' ?>?order_by=price&clause=ASC">Pigiausi pirmiau</a>
    <a href="<?php echo '/' ?>?order_by=price&clause=DESC">Brangiausi pirmiau</a>
    <a href="<?php echo '/' ?>?order_by=title&clause=ASC">Pavadinimas a-z</a>
    <a href="<?php echo '/' ?>?order_by=title&clause=DESC">Pavadinimas z-a</a>
</div>