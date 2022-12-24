<?php
    
    // 1. Записать время старта сессии 

    function checkUser($status): bool {
        session_set_cookie_params(5);
        
        session_start();
        // 1. Проверяем, есть ли внутри сессии дата старта сессии
        // 2. Добавляем дату ['date'] = '';
        // 3. Если дата есть, то сравниваем ее с текущей датой 


        $status = $_SESSION[$status];
        if (!$status) {
            header('location: /admin/');
            die();
        }
        $lifetime = 60;
        // setcookie(session_name(), session_id(), time() + $lifetime);
        return true;
    }

    function checkFile($avalibleTypes, $sizeLimit,$fileName, $tmp){
        if(!empty($_FILES)){
            $error=[];
            foreach ($avalibleTypes as $key => $value) {
                if ($_FILES[$fileName]['type'] == $key){
                    $currentType=$value;
                }
            }
            if (!isset($currentType)){
                array_push($error, "Недопустимый тип файла");
            }
            if ($_FILES[$fileName]['size']>2**20*$sizeLimit){
                array_push($error, "Размер файла превышает ".$sizeLimit."МБ");
            }
            if(!empty($error)){
                foreach ($error as $key => $value) {
                    $answer['errors'][$key]=$value;
                }
                return $answer;
            }
            $dir = "../../images/catalog";
            if (!is_dir($dir)){
                mkdir($dir, 0777, true);
            }
            $fileName= date('Y-m-d-h-i-s').'.'.$currentType;
            $filePath=$dir.'/'.$fileName;
            if (!file_exists($filePath)){
                move_uploaded_file($tmp ,$filePath);
                foreach ($error as $key => $value) {
                    $answer['errors'][$key]=$value;
                }
                $answer['fileName']=$fileName;
                return $answer;
            } else {
                array_push($error, 'Файл уже существует');
            }
            return $error;
        }
    }
?>