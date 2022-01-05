<?php
//$_POST(sends through header) ir $_GET(sends through url)
//$email = $_POST['email'];
//
//function isEmailValid($email)
//{
//    if (strpos($email, '@')) {
//        return true;
//    } else {
//        return false;
//    }
//}
//
//if(isEmailValid($email)){
//    echo 'email good';
//}else{
//    echo 'something went wrong';
//}
//
//$answer = 0;
//echo $_POST["number"];
//echo $_POST["operation"];
//echo $_POST["number2"];
//echo '<br>';
//
//
//if ($_POST["operation"] == "+"){
//    $answer = ($_POST["number"] + $_POST['number2']);
//}elseif($_POST["operation"] == "-"){
//    $answer = ($_POST["number"] - $_POST['number2']);
//}elseif($_POST["operation"] == "*"){
//    $answer = ($_POST["number"] * $_POST['number2']);
//}elseif($_POST["operation"] == "/"){
//    $answer = ($_POST["number"] / $_POST['number2']);
//}
//
//$operation = $_POST["operation"];
//$x = $_POST["number"];
//$y = $_POST["number2"];
//
//switch($operation){
//     case "+":
//         echo $x + $y;
//         break;
//     case "-":
//         echo $x - $y;
//         break;
//     case "*":
//         echo $x * $y;
//         break;
//     case "/":
//         echo $x / $y;
//         break;
//     default:
//         $answer = 'Operation not valid';
//
// }

function clearEmail($email){
    $emailLowercases = strtolower($email);
    return trim($emailLowercases);
}

function isEmailValid($email)
{
    if (strpos($email, '@')) {
        return true;
    } else {
        return false;
    }
}

function getNickname($name, $surName){
    return strtolower(substr($name, 0, 3).substr($surName, 0, 3).rand(1, 100));
}

$pw1 = $_POST['pw1'];
$pw2 = $_POST['pw2'];

function checkPassMatch($pw1,$pw2){
    if ($pw1==$pw2){
        return true;
    }else{
        return false;
    }
}

function checkPassLenght($pw){
    if (strlen($pw)>5){
        return true;
    }else{
        return false;
    }
}

if(isEmailValid($_POST['email'])){
    if(checkPassMatch($pw1,$pw2)) {
        if (checkPassLenght($pw1)) {
            echo $_POST['name'] . '<br>';
            echo $_POST['name2'] . '<br>';
            echo clearEmail($_POST['email']) . '<br>';
            echo getNickname($_POST['name'], $_POST['name2']) . '<br>';
        }else{
            echo 'slaptazodi turi sudaryti bent 6 simboliai';
        }
    }else{
        echo 'Slaptazodziai nesutampa';
    }
}else{
    echo 'Blogas pasto adresas';
}
