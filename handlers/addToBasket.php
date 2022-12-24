<?php
session_start();
//2. Получаем доступ к массиву
// $_SESSION = [
//     'basket' => [
//         0 => [
//             'id' => 22,
//             'amount' => 3
//         ],
//         1 => [
//             'id' => 2,
//             'amount' => 1
//         ],
//     ],
//     'pages' =>[
//     ]
// ]
$result= "Не удалось добавить товар";

if (isset($_SESSION['basket'])) {
    $flag=false;
    foreach ($_SESSION['basket'] as $key => $value) {
        if ($value['id']==$_GET['id']){
            $flag=true;
            $_SESSION['basket'][$key]['amount']++;
            $result = "Товар добавлен в корзину";
        //break;
        }
    }
    if ($flag==false){
        $_SESSION['basket'][]=[
            'id' => $_GET['id'],
            'amount' => 1 
        ];
        $result = "Товар добавлен в корзину";
    }
} else {
    $_SESSION['basket'][]=[
        'id' => $_GET['id'],
        'amount' => 1
    ];
    $result = "Товар добавлен в корзину";
}
sleep(1);
echo $result
?>