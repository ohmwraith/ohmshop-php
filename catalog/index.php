<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="/css/style.css">
    <title>Каталог товаров</title>
</head>
<body>
    <div class="wrapper">
    <?php include($_SERVER['DOCUMENT_ROOT'].'/modules/header.php')?>
        <form action="" id="categoryFilter">
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
        </form>
        <div class="catalog"></div>
        <div id="selectPage"></div>
        <?php include_once($_SERVER['DOCUMENT_ROOT'].'/modules/footer.php'); ?>
    </div>

    <script src="/js/main.js"></script>
</body>
</html>