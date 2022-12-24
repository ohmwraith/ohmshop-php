<?php
    ini_set('session.cookie_lifetime', 5);

    if ( !empty($_GET) ) {

        include_once($_SERVER['DOCUMENT_ROOT'] . '/config/config.php');

        $password = md5(md5($_GET['pass']));
        $query = "  SELECT `id`, `admin`   
                    FROM `users` 
                    WHERE `password` = '{$password}' 
                    AND `login` = '{$_GET['login']}'
                    ";

        $result = $link -> query($query);

        if ($result -> num_rows != 0 ) {

            $userInfo = $result -> fetch_assoc();

            if ( $userInfo['admin'] == 1 ) {
                echo 'Привет, админ!';

                session_set_cookie_params(50000);
                session_start();
                $_SESSION['admin'] = true;
                header('location: /admin/panel/');

            } elseif ($userInfo['admin'] == 2) {
                session_set_cookie_params(50000);
                session_start();
                $_SESSION['user'] = true;
                header('location: /cabinet/');
            }
        } else {
            echo 'Такого пользователя не существует! =(';
        };
        
        // print_r($result);

        // 2. Если пользователь есть, то 
        //      создаем сессию и переадресовываем пользователя
        //      на страницу админ панели
        
        // 3. Если пользователя нет в базе, то 
        //     отображаем ошибку

        
    }
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Вход в личный кабинет</title>
    <link rel="stylesheet" href="/css/admin.css">
</head>
<body>
    <div class="wrapper">
        <h1>Вход в личный кабинет</h1>
        <form action="" method="GET">
            <div class="loginForm">
            <input type="text" name="login" placeholder="Укажите логин"><br>
            <input type="password" name="pass" placeholder="Укажите пароль"><br>
            <input type="submit" value="войти">
            </div>
        </form>
    </div>
</body>
</html>