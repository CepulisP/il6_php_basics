<?php

//$x = 1;
//$y = ['2', $x];
//echo '<pre>';
//var_dump($y);
//
//$x = '2faAuth';
//$y = 2;
//
//var_dump($x);
//var_dump($y);
//var_dump($x * $y);
// $x = (float)2;
// $y = 3;
//
// if ($x === 2) {
//     echo 'true';
// } elseif ($x == 3) {
//     echo 'false';
// } else {
//     echo 'whats left';
// }
//
// switch($x){
//     case 2:
//         echo '$x = 2';
//         break;
//     case 3:
//         echo '$x = 2';
//         break;
//     default:
//         echo 'not match';
//         break;
// }

// $x = 'sasasa';
// $y = 3;

// if(!$variable){
//     $variable = 2;
// }

// echo $variable;

// $products = [
//     [    
//     'name' => 'Siulai',    
//     'price' => 12.4,
//     'special_price' => 9.99,    
//     'img' => 'https://siulupinkles.lt/wp-content/uploads/2021/01/Mezgimo-siulai-ritese-italiski-siulai-kasmyras-kasmyro-siulai-silko-siulai-silkas.jpg'    
//     ],    
//     [    
//     'name' => 'adata',    
//     'price' => 1.99,
//     'special_price' => 0.99,    
//     'img' => 'https://www.vle.lt/uploads/_CGSmartImage/70839_3-26c56fce05f1ac6e0247f6daa86648aa.jpg'    
//     ],    
//     [    
//     'name' => 'virbalai',    
//     'price' => 3.99,    
//     'img' => 'https://mezgimomanija.lt/wp-content/uploads/2019/02/3397.jpg'    
//     ],   
//     [    
//         'name' => 'virbalai',    
//         'price' => 9.99,    
//         'img' => 'https://mezgimomanija.lt/wp-content/uploads/2019/02/3397.jpg'    
//     ],
//     [    
//         'name' => 'virbalai2',    
//         'price' => 8.99,    
//         'img' => 'https://mezgimomanija.lt/wp-content/uploads/2019/02/3397.jpg'    
//     ],  
//     [    
//         'name' => 'virbalai3',    
//         'price' => 7.99,    
//         'img' => 'https://mezgimomanija.lt/wp-content/uploads/2019/02/3397.jpg'    
//     ],
//     [    
//         'name' => 'virbalai4',    
//         'price' => 6.99,    
//         'img' => 'https://mezgimomanija.lt/wp-content/uploads/2019/02/3397.jpg'    
//     ],
//     [    
//         'name' => 'virbalai5',    
//         'price' => 5.99,    
//         'img' => 'https://mezgimomanija.lt/wp-content/uploads/2019/02/3397.jpg'    
//     ],  
//     [    
//         'name' => 'virbalai6',    
//         'price' => 4.99,
//         'special_price' => 2.99,    
//         'img' => 'https://mezgimomanija.lt/wp-content/uploads/2019/02/3397.jpg'    
//     ],       
//     ];

// $counter = 0;

// foreach($products as $product){   
//     echo '<img width="60" src="'. $product['img'] .'"/>';    
//     echo '<h2>'. $product['name'] . '</h2>';
// //isset kad nebutu notice
//         if ( isset($product['special_price'])){            
//             echo '<h3><del>'.$product['price'].'</del>'.$product['special_price'].'</h3>';
//         } else {
//             echo '<h3>'. $product['price'] . '</h3>';
//         }
//     //$x = $x + 1;
//     $counter++;
//         if ( ($counter % 3) === 0 ){   
//             echo '<hr>';
//         }
// }

// for ($y = 0; $y <= 10; $y++){
//     for ($x = 0; $x <= 10; $x++){
//         if (($y % 2) == 0 ){
//             echo '#';
//         }else{
//             if (($x % 2) == 0 ){
//                 echo '#';
//             }else{
//                 echo '.';
//             }
//         }
        
//     }
//     echo '<br>';
// }

//mano bandymas
// for($years = 2015; $years < 2022; $years++){
//     for($months = 1; $months <= 12; $months++){
//         if ($months % 2 == 0){
//             for($days = 1; $days <= 31; $days++){
//                 echo $years.' '.$months.' '.$days;
//                 echo '<br>';                
//             }
//         }else{
//             for($days = 1; $days <= 30; $days++){
//                 echo $years.' '.$months.' '.$days;
//                 echo '<br>';                
//             }
//         }                   
        
//     }
// }

for($years = 2015; $years < 2022; $years++){
    for($months = 1; $months <= 12; $months++){
        if($months == 1 || $months == 3 || $months == 5 || $months == 8 || $months == 10 || $months == 12){
            $to = 31;
        }elseif($months == 2){
            if($years % 4 == 0){
                $to = 29;
            }else{
                $to = 28;
            }
        }else{
            $to = 30;
        }
    for($day = 1; $day <= $to; $day++){
        echo $years.' '.$months.' '.$day; 
        echo '<br>';
    }
    }
}

