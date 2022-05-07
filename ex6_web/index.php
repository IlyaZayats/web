<?php

/**
 * Реализовать возможность входа с паролем и логином с использованием
 * сессии для изменения отправленных данных в предыдущей задаче,
 * пароль и логин генерируются автоматически при первоначальной отправке формы.
 */

header('Content-Type: text/html; charset=UTF-8');

$user = 'u47553';
$pass = '3584958';

function okLetsGo($errors, $error_type, $i){
    if($i<12) {
        return !$errors[$error_type[$i]] && okLetsGo($errors, $error_type, $i + 1);
    }
    else return !$errors[$error_type[$i]];
}

function goBack(){
    setcookie('userAb_error', '6', time() + 24 * 60 * 60);
    header('Location: index.php');
    exit();
}

function generateUniqueLogin(){
    $user = 'u47553';
    $pass = '3584958';
    $login = uniqid();
    try {
        $db = new PDO('mysql:host=localhost;dbname=u47553', $user, $pass, array(PDO::ATTR_PERSISTENT => true));
        $stmt = $db->prepare("SELECT login FROM user_data_login WHERE login=(:login)");
        $stmt->bindParam(':login', $login);
        $stmt->execute();
        while($stmt->fetchColumn() == $login){
            if(strlen($login)<21) {
                $postfix = rand(0, 9);
                $login = $login.$postfix;
            } else {
                $login = generateUniqueLogin();
                break;
            }
        }
        return $login;
    } catch (PDOException $e) {
        print('Error : ' . $e->getMessage());
        exit();
    }
}

function getId($login){
    $user = 'u47553';
    $pass = '3584958';
    $db = new PDO('mysql:host=localhost;dbname=u47553', $user, $pass, array(PDO::ATTR_PERSISTENT => true));
    $get_id = $db->prepare("SELECT user_id FROM user_data_login WHERE login=:login");
    $get_id->bindParam(':login', $login);
    $get_id->execute();
    return $get_id->fetchColumn();
}

if ($_SERVER['REQUEST_METHOD'] == 'GET') {

    $messages = array();

    if (!empty($_COOKIE['save'])) {

        setcookie('save', '', 100000);
        setcookie('login', '', 100000);
        setcookie('pass', '', 100000);

        $messages[] = '<div style="color:#20c997; background-color:#212529;">Спасибо, результаты сохранены. </div>';
        // Если в куках есть пароль, то выводим сообщение.
        if (!empty($_COOKIE['pass'])) {
            $messages[] = sprintf('<div style="color:#ffc107; background-color:#212529;">Вы можете <a href="login.php">войти</a> с логином <strong>%s</strong>и паролем <strong>%s</strong> для изменения данных.</div>', strip_tags($_COOKIE['login']), strip_tags($_COOKIE['pass']));
        }
    }

    // Складываем признак ошибок в массив.
    $errors = array();
    $errors['userName'] = !empty($_COOKIE['userName_error']);
    $errors['userEmail'] = !empty($_COOKIE['userEmail_error']);
    $errors['userBirthdate'] = !empty($_COOKIE['userBirthdate_error']);
    $errors['userGender'] = !empty($_COOKIE['userGender_error']);
    $errors['userLimbs'] = !empty($_COOKIE['userLimbs_error']);
    $errors['userAb'] = !empty($_COOKIE['userAb_error']);
    $errors['check'] = !empty($_COOKIE['check_error']);
    $errors['userBio'] = !empty($_COOKIE['userBio_error']);
    $errors['userName_wrong'] = !empty($_COOKIE['userName_wrong']);
    $errors['userEmail_wrong'] = !empty($_COOKIE['userEmail_wrong']);
    $errors['userBirthdate_wrong'] = !empty($_COOKIE['userBirthdate_wrong']);
    $errors['userGender_wrong'] = !empty($_COOKIE['userGender_wrong']);
    $errors['userLimbs_wrong'] = !empty($_COOKIE['userLimbs_wrong']);


    if($errors['userName']) {
        setcookie('userName_error', '', 100000);
        $messages[] = '<div style="color:#dc3545; background-color:#212529;">Заполните имя. </div>';
    }
    if($errors['userEmail']) {
        setcookie('userEmail_error', '', 100000);
        $messages[] = '<div style="color:#dc3545; background-color:#212529;">Заполните email.</div>';
    }
    if($errors['userBirthdate']) {
        setcookie('userBirthdate_error', '', 100000);
        $messages[] = '<div style="color:#dc3545; background-color:#212529;">Заполните дату рождения. </div>';
    }
    if($errors['userGender']) {
        setcookie('userGender_error', '', 100000);
        $messages[] = '<div style="color:#dc3545; background-color:#212529;">Заполните пол. </div>';
    }
    if($errors['userLimbs']) {
        setcookie('userLimbs_error', '', 100000);
        $messages[] = '<div style="color:#dc3545; background-color:#212529;">Заполните конечности. </div>';
    }
    if($errors['userAb']) {
        setcookie('userAb_error', '', 100000);
        $messages[] = '<div style="color:#dc3545; background-color:#212529;">Неверно введены суперспособности. </div>';
    }
    if($errors['check']) {
        setcookie('check_error', '', 100000);
        $messages[] = '<div style="color:#dc3545; background-color:#212529;">Вы не согласились с контрактом!</div>';
    }
    if($errors['userBio']) {
        setcookie('userBio_error', '', 100000);
        $messages[] = '<div style="color:#dc3545; background-color:#212529;">Используются недопустимые символы в поле "Биография".</div>';
    }
    if($errors['userName_wrong']) {
        setcookie('userName_wrong', '', 100000);
        $messages[] = '<div style="color:#dc3545; background-color:#212529;">Используются недопустимые символы в поле "Имя". </div>';
    }
    if($errors['userEmail_wrong']) {
        setcookie('userEmail_wrong', '', 100000);
        $messages[] = '<div style="color:#dc3545; background-color:#212529;">Используются недопустимые символы в поле "Email".</div>';
    }
    if($errors['userBirthdate_wrong']) {
        setcookie('userBirthdate_wrong', '', 100000);
        $messages[] = '<div style="color:#dc3545; background-color:#212529;">Неверно введена дата рождения. </div>';
    }
    if($errors['userGender_wrong']) {
        setcookie('userGender_wrong', '', 100000);
        $messages[] = '<div style="color:#dc3545; background-color:#212529;">Неверно введён пол. </div>';
    }
    if($errors['userLimbs_wrong']) {
        setcookie('userLimbs_wrong', '', 100000);
        $messages[] = '<div style="color:#dc3545; background-color:#212529;">Неверно введены конечности. </div>';
    }

    $values = array();
    $values['userName'] = empty($_COOKIE['userName_value']) ? '' : $_COOKIE['userName_value'];
    $values['userEmail'] = empty($_COOKIE['userEmail_value']) ? '' : $_COOKIE['userEmail_value'];
    $values['userBirthdate'] = empty($_COOKIE['userBirthdate_value']) ? '' : $_COOKIE['userBirthdate_value'];
    $values['userGender'] = empty($_COOKIE['userGender_value']) ? '' : $_COOKIE['userGender_value'];
    $values['userLimbs'] = empty($_COOKIE['userLimbs_value']) ? '' : $_COOKIE['userLimbs_value'];
    $values['userBio'] = empty($_COOKIE['userBio_value']) ? '' : $_COOKIE['userBio_value'];

    for($i=0; $i<3; $i++){
        $values['userAb'.$i] = empty($_COOKIE['userAb_value'.$i]) ? '' : $_COOKIE['userAb_value'.$i];
    }

    $error_type = ['userName','userEmail','userBirthdate','userGender','userLimbs','userBio','userAb', 'check', 'userName_wrong', 'userEmail_wrong', 'userBirthdate_wrong', 'userGender_wrong', 'userLimbs_wrong'];
    $final_error = okLetsGo($errors, $error_type, 0);

    session_start();
    if ($final_error && !empty($_COOKIE[session_name()]) && !empty($_SESSION['login'])) {
        try{
            $id = getId($_SESSION['login']);
            $db = new PDO('mysql:host=localhost;dbname=u47553', $user, $pass, array(PDO::ATTR_PERSISTENT => true));
            $get_data = $db->prepare("SELECT * FROM user_data WHERE id=:id");
            $get_data->bindParam(':id' , $id);
            $get_data->execute();
            $data = array();
            $data = $get_data->fetchAll(PDO::FETCH_ASSOC);
            $get_ab = $db->prepare("SELECT * FROM user_ab WHERE user_data_id=:id");
            $get_ab->bindParam(':id' , $id);
            $get_ab->execute();
            $data_ab = array();
            $data_ab = $get_ab->fetchAll(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            print('Error : ' . $e->getMessage());
            exit();
        }
        $values['userName'] = filter_var($data[0]['name'],FILTER_SANITIZE_SPECIAL_CHARS);
        $values['userEmail'] = filter_var($data[0]['email'], FILTER_SANITIZE_SPECIAL_CHARS);
        $values['userBirthdate'] = $data[0]['birthdate'];
        $values['userGender'] = $data[0]['gender'];
        $values['userLimbs'] = $data[0]['limbs'];
        $values['userBio'] = filter_var($data[0]['bio'], FILTER_SANITIZE_SPECIAL_CHARS);
        $values['userAb0'] = $data_ab[0]['god'];
        $values['userAb1'] = $data_ab[0]['noclip'];
        $values['userAb2'] = $data_ab[0]['levitation'];
        print('<div style="color:#ffc107; background-color:#212529;">');
        if(empty($_SESSION['admin'])) {
            printf('Вход с логином %s, uid %d', $_SESSION['login'], $_SESSION['uid']);
        } else {
            printf('Изменение данных с логином %s, uid %d', $_SESSION['login'], $_SESSION['uid']);
            var_dump($values);
        }
        print('</div>');
    }
    include('form.php');
}
else {
    $errors = FALSE;

    if (empty($_POST['check'])) {
        setcookie('check_error', '13', time() + 24 * 60 * 60);
        $errors = TRUE;
    }

    if (empty($_POST['userName'])) {
        setcookie('userName_error', '1', time() + 24 * 60 * 60);
        $errors = TRUE;
    } else if(!preg_match("/^[\sa-zA-Zа-яА-Я-]+$/", $_POST['userName'])){
        setcookie('userName_wrong', '8', time() + 24 * 60 * 60);
        $errors = TRUE;
    } else {
        $userName = $_POST['userName'];
        setcookie('userName_value', $userName, time() + 30 * 24 * 60 * 60);
    }

    if (empty($_POST['userEmail'])) {
        setcookie('userEmail_error', '2', time() + 24 * 60 * 60);
        $errors = TRUE;
    } else if(!preg_match("/^([a-z0-9_-]+\.)*[a-z0-9_-]+@[a-z0-9_-]+(\.[a-z0-9_-]+)*\.[a-z]{2,6}$/", $_POST['userEmail'])){
        setcookie('userEmail_wrong', '9', time() + 24 * 60 * 60);
        $errors = TRUE;
    } else {
        $userEmail = $_POST['userEmail'];
        setcookie('userEmail_value', $userEmail, time() + 30 * 24 * 60 * 60);
    }

    if (empty($_POST['userBirthdate'])) {
        setcookie('userBirthdate_error', '3', time() + 24 * 60 * 60);
        $errors = TRUE;
    } else if(!preg_match("(([0-9]{3}[1-9]|[0-9]{2}[1-9][0-9]{1}|[0-9]{1}[1-9][0-9]{2}|[1-9][0-9]{3})-(((0[13578]|1[02])-(0[1-9]|[12][0-9]|3[01]))|((0[469]|11)-(0[1-9]|[12][0-9]|30))|(02-(0[1-9]|[1][0-9]|2[0-8])))|((([0-9]{2})(0[48]|[2468][048]|[13579][26])|((0[48]|[2468][048]|[3579][26])00))-02-29))", $_POST['userBirthdate'])){
        setcookie('userBirthdate_wrong', '10', time() + 24 * 60 * 60);
        $errors = TRUE;
    } else {
        $userBirthdate = $_POST['userBirthdate'];
        setcookie('userBirthdate_value', $userBirthdate, time() + 30 * 24 * 60 * 60);
    }

    if (empty($_POST['userGender'])) {
        setcookie('userGender_error', '4', time() + 24 * 60 * 60);
        $errors = TRUE;
    } else if (($_POST['userGender'] != 1 && $_POST['userGender'] != 2)){
        setcookie('userGender_wrong', '11', time() + 24 * 60 * 60);
        $errors = TRUE;
    } else {
        $userGender = $_POST['userGender'];
        setcookie('userGender_value', $userGender, time() + 30 * 24 * 60 * 60);
    }

    if (empty($_POST['userLimbs'])) {
        setcookie('userLimbs_error', '5', time() + 24 * 60 * 60);
        $errors = TRUE;
    } else if(($_POST['userLimbs'] != 1 && $_POST['userLimbs'] != 2 && $_POST['userLimbs'] != 3)){
        setcookie('userLimbs_wrong', '12', time() + 24 * 60 * 60);
        $errors = TRUE;
    } else {
        $userLimbs = $_POST['userLimbs'];
        setcookie('userLimbs_value', $userLimbs, time() + 30 * 24 * 60 * 60);
    }

    if (!preg_match("/^[0-9\sa-zA-Zа-яА-Я.,!;?:-]+$/",$_POST['userBio'])){
        setcookie('userBio_error', '7', time() + 24 * 60 * 60);
        $errors = TRUE;
    } else {
        $userBio = $_POST['userBio'];
        setcookie('userBio_value', $userBio, time() + 30 * 24 * 60 * 60);
    }

    $userAb = array();

    if (!empty($_POST['ab'])) {
        $n = count($_POST['ab']);
        $abCheck = array(true, true, true);
        for ($i = 0; $i < $n; $i++) {
            if ($_POST['ab'][$i] == 0 || $_POST['ab'][$i] == 1 || $_POST['ab'][$i] == 2) {
                if ($_POST['ab'][$i] == 0 && $abCheck[0]) {
                    $abCheck[0] = false;
                } else if ($_POST['ab'][$i] == 1 && $abCheck[1]) {
                    $abCheck[1] = false;
                } else if ($_POST['ab'][$i] == 2 && $abCheck[2]) {
                    $abCheck[2] = false;
                } else {
                    goBack();
                }
            } else {
                goBack();
            }
        }
        for ($i = 0; $i < 3; $i++) {
            if (!$abCheck[$i]) {
                $userAb[$i] = 1;
            } else {
                $userAb[$i] = 0;
            }
        }
    } else {
        for ($i = 0; $i < 3; $i++) {
            $userAb[$i] = 0;
        }
    }

    for($i=0; $i<3; $i++){
        setcookie('userAb_value'.$i, $userAb[$i], time() + 30 * 24 * 60 * 60);
    }

    if($errors){
        header('Location: index.php');
        exit();
    } else {
        setcookie('userName_error', '', 100000);
        setcookie('userEmail_error', '', 100000);
        setcookie('userBirthdate_error', '', 100000);
        setcookie('userGender_error', '', 100000);
        setcookie('userLimbs_error', '', 100000);
        setcookie('userAb_error', '', 100000);
        setcookie('userBio_error', '', 100000);
        setcookie('check_error', '', 100000);
        setcookie('userName_wrong', '', 100000);
        setcookie('userEmail_wrong', '', 100000);
        setcookie('userBirthdate_wrong', '', 100000);
        setcookie('userGender_wrong', '', 100000);
        setcookie('userLimbs_wrong', '', 100000);
    }

    if (!empty($_COOKIE[session_name()]) &&
        session_start() && !empty($_SESSION['login'])) {
        try {
            $id = getId($_SESSION['login']);
            $db = new PDO('mysql:host=localhost;dbname=u47553', $user, $pass, array(PDO::ATTR_PERSISTENT => true));
            $stmt_1 = $db->prepare("UPDATE user_data SET name=:name, email=:email, birthdate=:birthdate, gender=:gender, limbs=:limbs, bio=:bio WHERE id=:id");
            $stmt_1->bindParam(':name', $userName);
            $stmt_1->bindParam(':email', $userEmail);
            $stmt_1->bindParam(':birthdate', $userBirthdate);
            $stmt_1->bindParam(':gender', $userGender);
            $stmt_1->bindParam(':limbs', $userLimbs);
            $stmt_1->bindParam(':bio', $userBio);
            $stmt_1->bindParam(':id', $id);
            $db->beginTransaction();
            $stmt_1->execute();
            $db->commit();

            $stmt_2 = $db->prepare("UPDATE user_ab SET god=:god, noclip=:noclip, levitation=:levitation WHERE user_data_id=:id");
            $stmt_2->bindParam(':id', $id);
            $stmt_2->bindParam(':god', $userAb[0]);
            $stmt_2->bindParam(':noclip', $userAb[1]);
            $stmt_2->bindParam(':levitation', $userAb[2]);
            $db->beginTransaction();
            $stmt_2->execute();
            $db->commit();

        } catch (PDOException $e) {
            print('Error : ' . $e->getMessage());
            exit();
        }

    } else {
        $login = generateUniqueLogin();
        $password = uniqid();
        $serverpass = md5($password);

        setcookie('login', $login);
        setcookie('pass', $password);
        try {
            $db = new PDO('mysql:host=localhost;dbname=u47553', $user, $pass, array(PDO::ATTR_PERSISTENT => true));
            $stmt_1 = $db->prepare("INSERT INTO user_data (name, email, birthdate, gender, limbs, bio) VALUES (:name, :email, :date, :gender, :limbs, :bio)");
            $stmt_1->bindParam(':name', $userName);
            $stmt_1->bindParam(':email', $userEmail);
            $stmt_1->bindParam(':date', $userBirthdate);
            $stmt_1->bindParam(':gender', $userGender);
            $stmt_1->bindParam(':limbs', $userLimbs);
            $stmt_1->bindParam(':bio', $userBio);
            $db->beginTransaction();
            $stmt_1->execute();
            $id = $db->lastInsertId();
            $db->commit();

            $stmt_2 = $db->prepare("INSERT INTO user_ab (user_data_id, god, noclip, levitation) VALUES (:id, :god, :noclip, :levitation)");
            $stmt_2->bindParam(':id', $id);
            $stmt_2->bindParam(':god', $userAb[0]);
            $stmt_2->bindParam(':noclip', $userAb[1]);
            $stmt_2->bindParam(':levitation', $userAb[2]);
            $db->beginTransaction();
            $stmt_2->execute();
            $db->commit();

            $stmt_3 = $db->prepare("INSERT INTO user_data_login (user_id, login, password) VALUES (:id, :login, :password)");
            $stmt_3->bindParam(':id', $id);
            $stmt_3->bindParam(':login', $login);
            $stmt_3->bindParam(':password', $serverpass);
            $db->beginTransaction();
            $stmt_3->execute();
            $db->commit();

        } catch (PDOException $e) {
            print('Error : ' . $e->getMessage());
            exit();
        }
    }

    setcookie('save', '1');

    if(session_start() && !empty($_SESSION['admin'])){
        header('Location: admin.php');
        exit();
    }


    header('Location: ./');
}