<?php

header('Content-Type: text/html; charset=UTF-8');

session_start();

if (!empty($_SESSION['login'])) {

    print('
    <div class="container-fluid">
        <form method="POST">
            <div class="col mt-3 pb-3 text-center">
                <input class="btn btn-success btn-lg" type="submit" id="exitButton" name="exitButton" value="Выйти">
            </div>
        </form>
    <div>
    ');

    if(isset($_POST['exitButton'])){
        session_destroy();
        header('Location: index.php');
        exit();
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $login_err = !empty($_COOKIE['login_err']);
    $pass_err = !empty($_COOKIE['pass_err']);
    if($login_err){
        setcookie('login_err', '', 100000);
        $msg = '<div style="color:#dc3545; background-color:#212529;"> Пользователь с таким логином/паролем не найден!</div>';
    }
    if($pass_err){
        setcookie('pass_err', '', 100000);
        $msg = '<div style="color:#dc3545; background-color:#212529;"> Неверно введён пароль!</div>';
    }
    ?>
    <html lang="ru">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv='X-UA-Compatible' content='IE=edge'/>
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
        <title>Login into Ex5</title>
        <link rel="stylesheet" href="css/bootstrap.css">
        <link rel="stylesheet" href="css/style.css">
    </head>
    <body>
    <?php
    if(!empty($msg)){
        print($msg);
    }
    ?>
    <div class="container-fluid">
        <div class="row d-flex">
            <div class="col-sm-8 col-md-4 mx-auto bg-dark">
                <form id="loginForm" action="" method="POST" enctype="multipart/form-data" accept-charset="UTF-8">
                    <div class="form-row text-light">
                        <div class="col pt-1">
                            <div>
                                Логин:
                            </div>
                            <label>
                                <input class="form-control form-control-md info" type="text" name="login" placeholder="Логин" autocomplete="off">
                            </label><br/>
                        </div>
                        <div class="col pt-1">
                            <div>
                                Пароль:
                            </div>
                            <label>
                                <input class="form-control form-control-md info" type="text" name="password" placeholder="Пароль" autocomplete="off">
                            </label><br/>
                        </div>
                        <div class="col mt-3 pb-3">
                            <input class="btn btn-danger btn-lg" type="submit" id="submitLoginButton" value="Войти">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    </body>

    <?php
}

else {

    try{
        $user = 'u47553';
        $pass = '3584958';
        $db = new PDO('mysql:host=localhost;dbname=u47553', $user, $pass, array(PDO::ATTR_PERSISTENT => true));
        $check_login = $db->prepare("SELECT * FROM user_data_login WHERE login=:login");
        $check_login->bindParam(':login', $_POST['login']);
        $check_login->execute();
        $all = $check_login->fetchAll(PDO::FETCH_ASSOC);
    }catch (PDOException $e) {
        print('Error : ' . $e->getMessage());
        exit();
    }

    if(empty($all)){
        setcookie('login_err', '20', time() + 24*60*60);
        header('Location: login.php');
        exit();
    } else {
        $password = $all[0]['password'];
        if($password != $_POST['password'].md5('Ui4N9c')){
            setcookie('pass_err', '21', time() + 24*60*60);
            header('Location: login.php');
            exit();
        } else {
            setcookie('login_err', '', 100000);
            setcookie('pass_err', '', 100000);
            $_SESSION['login'] = $_POST['login'];
            try {
                $db = new PDO('mysql:host=localhost;dbname=u47553', $user, $pass, array(PDO::ATTR_PERSISTENT => true));
                $get_id = $db->prepare("SELECT user_id FROM user_data_login WHERE login=:login");
                $get_id->bindParam(':login', $_SESSION['login']);
                $get_id->execute();
                $_SESSION['uid'] = $get_id->fetchColumn();
                header('Location: index.php');
                exit();
            } catch (PDOException $e) {
                print('Error : ' . $e->getMessage());
                exit();
            }
        }
    }
    exit();

}

