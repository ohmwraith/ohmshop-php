<?php
session_start();

$countItems=0;

if (isset($_SESSION['basket'])) {
    foreach ($_SESSION['basket'] as $key => $value) {
        $countItems+=$_SESSION['basket'][$key]['amount'];
    }
}
echo $countItems;
?>