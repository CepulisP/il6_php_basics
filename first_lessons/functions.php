<?php

//$productPrice = 12;
//$discount = 20;
//
//$productPrice1 = 13;
//$discount2 = 30;
//
//$finalPrice = getFinalPrice($productPrice, $discount);
//$finalPrice2 = $productPrice1 * ((100-$discount2) / 100);
//
//echo '<div class="price">'.$finalPrice. '</div>';
//echo '<div class="price">'.$finalPrice2. '</div>';
//
//function getFinalPrice($price, $discount){
//    $finalPriceWithoutTaxes = $price * ((100 - $discount) / 100);
//    $finalPriceWithTaxes = getPriceWithTax($finalPriceWithoutTaxes);
//    return $finalPriceWithTaxes;
//}
//
//function getPriceWithTax($price){
//    return $price * 1.21;
//}
//
//function clearEmail($email){
//    $emailLowercases = strtolower($email);
//    return trim($emailLowercases);
//}
//function isEmailValid($email)
//{
//    if (strpos($email, '@')) {
//        return true;
//    } else {
//        return false;
//    }
//}
//
//$userEmail = 'kazkas@belekas.com';
//$userEmail1 = "belekaskazkas.com";
//
//if(isEmailValid($userEmail)){
//    echo clearEmail($userEmail);
//}else{
//    echo 'Emailas nevalidus';
//}
//
//$name = 'Povilas';
//$surname = 'Cepulis';
//
//function getNickname($name, $surName){
//    return strtolower(substr($name, 0, 3).substr($surName, 0, 3).rand(1, 100));
//}
//echo getNickname($name, $surname);

function titleToSlug($title){
    return strtolower(str_replace(' ', '-', $title));
}

