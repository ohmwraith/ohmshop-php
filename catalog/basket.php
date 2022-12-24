<?php 
session_start();
include_once($_SERVER['DOCUMENT_ROOT'].'/config/config.php');
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="/css/style.css">
    <link rel="stylesheet" href="/css/product.css">
    <title>Корзина</title>
</head>
<body>
<body>
    <div class="wrapper">
    <?php include($_SERVER['DOCUMENT_ROOT'].'/modules/header.php')?>
    <div class="basket">
        <h1 class="product-title basket-title">Ваша Корзина</h1>
    </div>
    <?php include_once($_SERVER['DOCUMENT_ROOT'].'/modules/footer.php'); ?>
    </div>

    <script src="/js/basket.js"></script>
    <script src="/js/main.js"></script>
</body>
</html>