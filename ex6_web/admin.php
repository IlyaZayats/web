<?php

/**
 * Задача 6. Реализовать вход администратора с использованием
 * HTTP-авторизации для просмотра и удаления результатов.
 **/

// Пример HTTP-аутентификации.
// PHP хранит логин и пароль в суперглобальном массиве $_SERVER.
// Подробнее см. стр. 26 и 99 в учебном пособии Веб-программирование и веб-сервисы.


$user="u47553";
$pass="3584958";

try{
    $db = new PDO('mysql:host=localhost;dbname=u47553', $user, $pass, array(PDO::ATTR_PERSISTENT => true));
    $get_pwd = $db->prepare("SELECT password FROM admin WHERE login=:login");
    $login = 'admin';
    $get_pwd->bindParam(':login', $login);
    $get_pwd->execute();
    $pwd = current(current($get_pwd->fetchAll(PDO::FETCH_ASSOC)));
//    var_dump($pwd);
//    var_dump(md5('T8LHGTYmY9sWIedh'));
}catch (PDOException $e) {
    print('Error : ' . $e->getMessage());
    exit();
}

if (empty($_SERVER['PHP_AUTH_USER']) ||
    empty($_SERVER['PHP_AUTH_PW']) ||
    $_SERVER['PHP_AUTH_USER'] != 'admin' ||
    md5($_SERVER['PHP_AUTH_PW']) != $pwd) {
  header('HTTP/1.1 401 Unanthorized');
  header('WWW-Authenticate: Basic realm="My site"');
  print('<h1>401 Требуется авторизация</h1>');
  exit();
}
?>

<html lang="ru">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv='X-UA-Compatible' content='IE=edge'/>
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
        <title>Admin Ex6</title>
        <link rel="stylesheet" href="css/bootstrap.css">
        <link rel="stylesheet" href="css/style.css">
    </head>
    <body>

<?php
print('<div style="color:#dc3545; background-color:#212529;">Вы успешно авторизовались и видите защищенные паролем данные.</d00iv>');

session_start();
$_SESSION['admin']="admin";

try{
    $db = new PDO('mysql:host=localhost;dbname=u47553', $user, $pass, array(PDO::ATTR_PERSISTENT => true));
    $get_data = $db->prepare("SELECT * FROM user_data");
    $get_data->execute();
    $data = $get_data->fetchAll(PDO::FETCH_ASSOC);
    $get_logins = $db->prepare("SELECT login FROM user_data_login");
    $get_logins->execute();
    $logins = $get_logins->fetchAll(PDO::FETCH_ASSOC);
    $get_ab = $db->prepare("SELECT * FROM user_ab");
    $get_ab->execute();
    $ab = $get_ab->fetchAll(PDO::FETCH_ASSOC);
}catch (PDOException $e) {
    print('Error : ' . $e->getMessage());
    exit();
}


echo '<table class="table table-dark table-hover">
        <thead>
            <tr>
                <th class="col">USER_ID</th>
                <th class="col">USER_NAME</th>
                <th class="col">USER_EMAIL</th>
                <th class="col">USER_BIRTHDATE</th>
                <th class="col">USER_GENDER</th>
                <th class="col">USER_LIMBS</th>
                <th class="col">USER_GOD</th>
                <th class="col">USER_NOCLIP</th>
                <th class="col">USER_LEVITATION</th>
                <th class="col">USER_BIO</th>
                <th class="col">CHANGE</th>
                <th class="col">DELETE</th>
            </tr>
        </thead>
        <tbody>';
$god_amount = 0;
$noclip_amount = 0;
$levitation_amount = 0;
for($i=0; $i<count($data); $i++){
    $id = $data[$i]['id'];
    $name = $data[$i]['name'];
    $email = $data[$i]['email'];
    $birthdate = $data[$i]['birthdate'];
    $limbs = $data[$i]['limbs'];
    $bio = $data[$i]['bio'];
    $gender = $data[$i]['gender'];
    $god = $ab[$i]['god'];
    $noclip = $ab[$i]['noclip'];
    $levitation = $ab[$i]['levitation'];
    $god_amount += $god;
    $noclip_amount += $noclip;
    $levitation_amount += $levitation;
    echo '
            <tr>
                <th class="col">'.$id.'</th>
                <th class="col">'.$name.'</th>
                <th class="col">'.$email.'</th>
                <th class="col">'.$birthdate.'</th>
                <th class="col">'.$gender.'</th>
                <th class="col">'.$limbs.'</th>
                <th class="col">'.$god.'</th>
                <th class="col">'.$noclip.'</th>
                <th class="col">'.$levitation.'</th>
                <th class="col">'.$bio.'</th>
                <th class="col"><form method="POST"><input class="btn btn-info" type="submit" name="change'.$i.'" value="Change"></form></th>
                <th class="col"><form method="POST"><input class="btn btn-danger" type="submit" name="delete'.$i.'" value="Delete"></form></th>
            </tr>';
}
    echo '</tbody>
           </table>
           </body>';

echo '<table class="table table-dark table-hover mt-2">
        <thead>
            <tr>
                <th class="col">GOD_AMOUNT</th>
                <th class="col">NOCLIP_AMOUNT</th>
                <th class="col">LEVITATION_AMOUNT</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <th class="col">'.$god_amount.'</th>
                <th class="col">'.$noclip_amount.'</th>
                <th class="col">'.$levitation_amount.'</th>
            </tr>
        </tbody>
        <tbody>';

for($i=0; $i<count($data); $i++){
    if(isset($_POST['change'.$i])){
        $_SESSION['login']=$logins[$i]['login'];
        $_SESSION['uid']=$data[$i]['id'];
        header('Location: index.php');
        exit();
    }
}

for($i=0; $i<count($data); $i++){
    if(isset($_POST['delete'.$i])){
        try{
            $db = new PDO('mysql:host=localhost;dbname=u47553', $user, $pass, array(PDO::ATTR_PERSISTENT => true));
            $delete = $db->prepare("DELETE FROM user_data WHERE id=:id");
            $delete->bindParam(':id',$data[$i]['id']);
            $delete->execute();
        }catch (PDOException $e) {
            print('Error : ' . $e->getMessage());
            exit();
        }
        header('Location: admin.php');
        exit();
    }
}



