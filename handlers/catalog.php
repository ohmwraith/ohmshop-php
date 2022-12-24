<?php 
    include_once($_SERVER['DOCUMENT_ROOT'] . '/config/config.php');

    $itemsOnPage = 6;
    $pageID = 1;
    if (isset($_GET['page'])){
        $pageID = $_GET['page'];
    }
    else{
        $pageID = 1;
    }
    $data = [
        'pagination' => [
            'allPages' => 1,
            'currentPage' => (int) $pageID
        ]
    ];

    $category = $_GET['category'];
    $subCategory = $_GET['subCategory'];

    function pagination($rows, $itemsOnPage){
        $sheets = ceil($rows / $itemsOnPage);
        return $sheets;
    }

    function getItems($link, $query, $itemsOnPage, $queryPagination) {
        $result = $link -> query($query);
        $allGoods = $link -> query($queryPagination);
        $allGoodsMass = $allGoods -> fetch_assoc();

        $sheets = pagination($allGoodsMass['result'], $itemsOnPage);
            
        $products = [];
        // создать ассоциатвный массив php
        while($row = $result -> fetch_assoc()) {
            $products[] = $row;
        }
        return [$products, $sheets];
    }
    if ($pageID==1){
        $startItem = 0;
    }
    else {
        $startItem = ($pageID-1)*$itemsOnPage;
    }

    if ($category==0 & $subCategory==0) {
        // 1. отправлена дочерняя категория
        $query = "SELECT * 
        FROM `itemsmen`
        LIMIT $startItem, $itemsOnPage";

        $queryPagination = "
        SELECT COUNT(`itemsmen`.`id`) AS `result` 
        FROM `itemsmen`";

        $products = getItems($link, $query, $itemsOnPage, $queryPagination);


    } elseif($category!=0 & $subCategory==0) {
        // 1. отправлена родительская категория 
        $query = "
                SELECT *
                FROM `itemsmen`
                WHERE `category_id` = $category
                LIMIT $startItem, $itemsOnPage
        ";
        $queryPagination = "SELECT COUNT(id) AS result FROM itemsmen WHERE category_id=$category;";
        
        $products = getItems($link, $query, $itemsOnPage, $queryPagination);
    } elseif($category==0 & $subCategory!=0){
        $query = "
            SELECT *
            FROM `itemsmen`
            WHERE `subCategory_id` = $subCategory
            LIMIT $startItem, $itemsOnPage
        ";
        $queryPagination = "SELECT COUNT(id) AS result FROM itemsmen WHERE subCategory_id=$subCategory;";
    
        $products = getItems($link, $query, $itemsOnPage, $queryPagination);
    } else {
        $query = "
            SELECT *
            FROM `itemsmen`
            WHERE `category_id` = $category AND `subCategory_id` = $subCategory
            LIMIT $startItem, $itemsOnPage
        ";
        $queryPagination = "SELECT COUNT(id) AS result FROM itemsmen WHERE subCategory_id=$subCategory;";

        $products = getItems($link, $query, $itemsOnPage, $queryPagination);
    }
    $data['products'] = $products[0];
    $data['pagination']['allPages'] = $products[1];

    echo json_encode($data);

    
?>