<?php

function goBack(){
    print('<div style="color:#dc3545; background-color:#212529;">Неверно введены суперспособности. </div>');
    include('form.php');
    exit();
}

header('Content-Type: text/html; charset=UTF-8');

if($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (!empty($_GET['save'])) {
        print('<div style="color:#198754; background-color:#212529;">Данные успешно сохранены! </div>');
    }
    include('form.php');
    exit();
}else {
    $errors = FALSE;
    $errors_string = array();
    for($i=0; $i<9; $i++){
        $errors_string[$i]='';
    }

    if (empty($_POST['userName'])) {
        $errors_string[0] = '<div style="color:#dc3545; background-color:#212529;">Заполните имя. </div>';
        $errors = TRUE;
    }
    if (empty($_POST['userEmail'])) {
        $errors_string[1] = '<div style="color:#dc3545; background-color:#212529;">Заполните email. </div>';
        $errors = TRUE;
    } else if (!preg_match("/^([a-z0-9_-]+\.)*[a-z0-9_-]+@[a-z0-9_-]+(\.[a-z0-9_-]+)*\.[a-z]{2,6}$/", $_POST['userEmail'])) {
        $errors_string[2]='<div style="color:#dc3545; background-color:#212529;">Неверно введён email.</div>';
        $errors = TRUE;
    }
    if (empty($_POST['userBirthdate'])) {
        $errors_string[3]=('<div style="color:#dc3545; background-color:#212529;">Заполните дату рождения. </div>');
        $errors = TRUE;
    } else if (!preg_match("(([0-9]{3}[1-9]|[0-9]{2}[1-9][0-9]{1}|[0-9]{1}[1-9][0-9]{2}|[1-9][0-9]{3})-(((0[13578]|1[02])-(0[1-9]|[12][0-9]|3[01]))|((0[469]|11)-(0[1-9]|[12][0-9]|30))|(02-(0[1-9]|[1][0-9]|2[0-8])))|((([0-9]{2})(0[48]|[2468][048]|[13579][26])|((0[48]|[2468][048]|[3579][26])00))-02-29))", $_POST['userBirthdate'])) {
        $errors_string[4]=('<div style="color:#dc3545; background-color:#212529;">Неверно введена дата рождения. </div>');
        $errors = TRUE;
    }
    if (empty($_POST['userGender'])) {
        $errors_string[5]=('<div style="color:#dc3545; background-color:#212529;">Заполните пол. </div>');
        $errors = TRUE;
    } else if ($_POST['userGender'] != 1 && $_POST['userGender'] != 2) {
        $errors_string[6]=('<div style="color:#dc3545; background-color:#212529;">Неверно введен пол. </div>');
        $errors = TRUE;
    }

    if (empty($_POST['userLimbs'])) {
        $errors_string[7]=('<div style="color:#dc3545; background-color:#212529;">Заполните конечности. </div>');
        $errors = TRUE;
    } else if ($_POST['userLimbs'] != 1 && $_POST['userLimbs'] != 2 && $_POST['userLimbs'] != 3) {
        $errors_string[8]=('<div style="color:#dc3545; background-color:#212529;">Неверно введены конечности. </div>');
        $errors = TRUE;
    }

    if ($errors) {
        for($i=0; $i<9; $i++){
            print($errors_string[$i]);
        }
        include('form.php');
        exit();
    }

    $userName = $_POST['userName'];
    $userEmail = $_POST['userEmail'];
    $userBirthdate = $_POST['userBirthdate'];
    $userGender = $_POST['userGender'];
    $userLimbs = $_POST['userLimbs'];
    $userBio = $_POST['userBio'];


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
        if (!$stmt_1->execute()) {
            print('execute1 error ');
        }

        $get_id = $db->prepare("select max(id) from user_data");
        $get_id->execute();
        $id = $get_id->fetchColumn();


        $stmt_2 = $db->prepare("INSERT INTO user_ab (user_data_id, god, noclip, levitation) VALUES (:id, :god, :noclip, :levitation)");
        $stmt_2->bindParam(':id', $id);
        $stmt_2->bindParam(':god', $userAb[0]);
        $stmt_2->bindParam(':noclip', $userAb[1]);
        $stmt_2->bindParam(':levitation', $userAb[2]);
        if (!$stmt_2->execute()) {
            print('execute2 error ');
        }
    } catch (PDOException $e) {
        print('Error : ' . $e->getMessage());
        exit();
    }
    header('Location: ?save=1');
}
