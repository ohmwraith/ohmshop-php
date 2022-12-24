<?php 
    require_once($_SERVER['DOCUMENT_ROOT'] . '/functions/functions.php');
    require_once($_SERVER['DOCUMENT_ROOT'] . '/config/config.php');
    // ini_set('session.gc_maxlifetime', 5);
    // ini_set('session.cookie_lifetime', 5);
    // ini_set('session.save_path', $_SERVER['DOCUMENT_ROOT'] .'/sessions');

    checkUser('admin');
    echo '<br>';

    if(!empty($_POST)){
        echo "<div class='message'>";
        echo "<pre>";
        print_r($_POST);
        echo "</pre>";
        echo "<pre>";
        print_r($_FILES);
        echo "</pre>";
        echo "</div>";
    }
    
    $fileName="file";
    $tmp = "";
    if (isset($_FILES[$fileName])){
        $tmp=$_FILES[$fileName]['tmp_name'];
    }
    $sizeLimit=8;
    $avalibleTypes=['image/png'=> 'png','image/jpeg'=> 'jpg', 'image/webp'=> 'webp'];
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="/css/admin.css">
    <title>Document</title>
</head>
<body>
<div class="wrapper">
    <h1>Добавить</h1>
    <form action="" method="post" enctype="multipart/form-data">
    <div class="addNewItem">
        <input type="text" name="title" placeholder="Наименование">
        <input type="text" name="price" placeholder="Цена">
        <input type="text" name="discription" placeholder="Описание">
        <input type="file" name="<?=$fileName?>">
        <select name="category">
                <option value="0">Все</option>
                <option value="1">Мужчинам</option>
                <option value="2">Женщинам</option>
                <option value="3">Детям</option>
            </select>
            <select name="subCategory">
                <option value="0">Все</option>
                <option value="1">Обувь</option>
                <option value="2">Куртки</option>
                <option value="3">Джинсы</option>
                <option value="4">Костюмы</option>
                <option value="5">Рюкзаки</option>
            </select>
        <input type="submit">
        <?php

        if(isset($_POST['title']) && isset($_POST['price']) && isset($_POST['discription']) && isset($_POST['category']) && isset($_POST['subCategory'])){

            $title = $_POST['title'];
            $price = $_POST['price'];
            $discription = $_POST['discription'];
            $category = $_POST['category'];
            $subCategory = $_POST['subCategory'];

            if(isset($_FILES['file'])){
                $answer=checkFile($avalibleTypes, $sizeLimit, $fileName, $tmp);
                if(!isset($answer['fileName'])){
                    echo "<div class='error'>";
                    foreach ($answer['errors'] as $key => $value) {
                        echo $value.'<br>'; 
                    } 
                    echo "</div>";
                } else {
                    // $image = $_SERVER['DOCUMENT_ROOT']."/images/new/".$answer['fileName'];
                    $image =$answer['fileName'];
                    $query = "INSERT INTO `itemsmen` (`itemPic`, `itemName`, `itemPrice`, `itemDescription`, `category_id`, `subCategory_id`) VALUES ('$image', '$title', $price, '$discription', $category, $subCategory)";
                    $result = $link->query($query);
                    echo '<div class="success">Лот успешно создан с именем "'.$title.'", фотография сохранена с названием: '.$answer['fileName'].'</div>';
                }
            } else {
                echo "<div class='error'>Файл не выбран</div>";
            }
        }
    ?>
    </form>
    </div>
</div>
</body>
</html>