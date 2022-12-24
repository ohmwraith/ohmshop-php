<?php
session_start();

$http_response_header=400;

if (isset($_GET['id'])){
    foreach ($_SESSION['basket'] as $key => $value) {
        if($_SESSION['basket'][$key]['id']==$_GET['id']){
            $_SESSION['basket'][$key]['amount']=0;
            $http_response_header=200;
        }
    }
}
echo $http_response_header;

?>