<?php 
session_start();
require_once($_SERVER['DOCUMENT_ROOT'] . '/config/config.php');
$message = "У вас недостаточно прав";
if (isset($_GET['id']) && $_SESSION['admin']==True){
    $id = $_GET['id'];
$query = 'DELETE FROM itemsmen WHERE id ='.$id;
    $result = $link->query($query);
    if ($result){
        $message="Товар был успешно удален";
    }
    else{
        $message="Ошибка! Товара не существует";
    }
}
echo json_encode($message);

?>