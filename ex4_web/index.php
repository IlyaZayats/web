<?php

header('Content-Type: text/html; charset=UTF-8');

function goBack(){
    setcookie('userAb_error', '6', time() + 24 * 60 * 60);
    header('Location: index.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'GET') {

    $messages = array();
    if (!empty($_COOKIE['save'])) {
        setcookie('save', '', 100000);
        $messages[] = '<div style="color:#20c997; background-color:#212529;">Спасибо, результаты сохранены. </div>';
    }

    $errors = array();
    $errors['userName'] = !empty($_COOKIE['userName_error']);
    $errors['userEmail'] = !empty($_COOKIE['userEmail_error']);
    $errors['userBirthdate'] = !empty($_COOKIE['userBirthdate_error']);
    $errors['userGender'] = !empty($_COOKIE['userGender_error']);
    $errors['userLimbs'] = !empty($_COOKIE['userLimbs_error']);
    $errors['userAb'] = !empty($_COOKIE['userAb_error']);
    $errors['check'] =!empty($_COOKIE['check_error']);
    $errors['userBio'] =!empty($_COOKIE['userBio_error']);
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

    include('form.php');

}else{

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
    }else {
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

    try {
        $user = 'u47553';
        $pass = '3584958';
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

    } catch (PDOException $e) {
        print('Error : ' . $e->getMessage());
        exit();
    }

    setcookie('save', '1');

    header('Location: index.php');
}
