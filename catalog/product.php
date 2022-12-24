<?php
session_start();
include_once($_SERVER['DOCUMENT_ROOT'].'/config/config.php');
if (isset($_GET['id'])){
    $selectedItem=$_GET['id'];

    $query="SELECT * FROM `itemsmen` WHERE `id` = $selectedItem";
    $result=$link->query($query);
    $product= $result->fetch_assoc();

    if ($result->num_rows==0){
        header("location: /catalog/");
        die("Товара не существует");
    }
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="/css/style.css">
    <link rel="stylesheet" href="/css/product.css">
    <title>Товар</title>
</head>
<body>
    <div class="wrapper">
    <?php include($_SERVER['DOCUMENT_ROOT'].'/modules/header.php')?>
        <a href="/catalog/" class="returnBack">назад</a>
        <? if (isset($product)): ?>
            <? if ($row_cnt): ?>
        <div class="product">
            <div class="product-image">
                <img style="" src="/images/catalog/<?=$product['itemPic']?>" alt="<?=$product['itemName']?>">
            </div>
            <div class="product-info">
                <h1 class="product-title"><?=$product['itemName']?></h1>
                <div class="product-price"><?=$product['itemPrice']?>р</div>
                <div class="product-description"><?=$product['itemDescription']?></div>
                <div class="product-buttons">
                    <span class="addToCart" onclick="Product.addToCart(<?=$product['id']?>); Catalog.renderBasketIcon();">добавить в корзину</span>
                    <?php
                        if (isset($_SESSION['admin']) && $_SESSION['admin']==True){
                            echo '<span class="addToCart" onclick="Catalog.editThisProduct(\''.$product['itemName'].'\',\''.$product['itemPic'].'\',\''.$product['itemPrice'].'\',\''.$product['itemDescription'].'\',\''.$product['category_id'].'\',\''.$product['subCategory_id'].'\',\''.$product['id'].'\');">изменить</span>';
                            if(isset($_POST['newTitle']) && isset($_POST['newPrice']) && isset($_POST['newDescription']) && isset($_POST['newCategory']) && isset($_POST['newSubCategory'])){
                                $newTitle = $_POST['newTitle'];
                                $newPrice = $_POST['newPrice'];
                                $newDescription = $_POST['newDescription'];
                                $newCategory = $_POST['newCategory'];
                                $newSubCategory = $_POST['newSubCategory'];
                                $productID = $_GET['id'];

                                $insertQuery = "UPDATE itemsmen SET itemName='$newTitle', itemPrice='$newPrice', itemDescription='$newDescription', category_id='$newCategory', subCategory_id='$newSubCategory' WHERE id='$productID'";

                                $insertResult = $link->query($insertQuery);
                                header('location: /catalog/product.php?id='.$productID);
                                echo $insertResult;
                            }
                        }
                    ?>
                </div>
            </div>
        </div>
        <? endif; ?>
        <? endif; ?>
        <?php include_once($_SERVER['DOCUMENT_ROOT'].'/modules/footer.php'); ?>
    </div>
    <script src="/js/main.js"></script>
</body>