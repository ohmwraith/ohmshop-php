<?php 
session_start();
include_once($_SERVER['DOCUMENT_ROOT'].'/config/config.php');
if (!empty($_SESSION['basket']) && !empty($_GET)){
    $basket = $_SESSION['basket'];
    foreach ($basket as $key => $value) {
        $itemID = $basket[$key]['id'];
        $itemAmount = $basket[$key]['amount'];
        $query="SELECT * FROM `itemsmen` WHERE `id` = $itemID";
        $result=$link->query($query);
        $product= $result->fetch_assoc();
        $basketItems[$key] = $product;
        $basketItems[$key]['amount'] = $itemAmount;  
    }
    echo json_encode($basketItems);

}

?>