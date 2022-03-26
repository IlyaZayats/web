<?php

header('Content-Type: text/html; charset=UTF-8');

$errors = FALSE;
if (empty($_POST['userName'])) {
    print('Заполните имя.<br/>');
    $errors = TRUE;
}
if (empty($_POST['userEmail'])) {
    print('Заполните email.<br/>');
    $errors = TRUE;
} else if (!preg_match("/^([a-z0-9_-]+\.)*[a-z0-9_-]+@[a-z0-9_-]+(\.[a-z0-9_-]+)*\.[a-z]{2,6}$/", $_POST['userEmail'])){
    print('Неверно введен email.<br/>');
    $errors = TRUE;
}
if (empty($_POST['userBirthdate'])) {
    print('Заполните дату рождения.<br/>');
    $errors = TRUE;
} else if(!preg_match("(([0-9]{3}[1-9]|[0-9]{2}[1-9][0-9]{1}|[0-9]{1}[1-9][0-9]{2}|[1-9][0-9]{3})-(((0[13578]|1[02])-(0[1-9]|[12][0-9]|3[01]))|((0[469]|11)-(0[1-9]|[12][0-9]|30))|(02-(0[1-9]|[1][0-9]|2[0-8])))|((([0-9]{2})(0[48]|[2468][048]|[13579][26])|((0[48]|[2468][048]|[3579][26])00))-02-29))", $_POST['userBirthdate'])){
    print('Неверно введена дата.<br/>');
    $errors = TRUE;
}
if (empty($_POST['userGender'])){
    print('Заполните пол.<br/>');
    $errors = TRUE;
} else if ($_POST['userGender']!=1 && $_POST['userGender']!=2){
    print('Неверно введен пол.<br/>');
    $errors = TRUE;
}

if (empty($_POST['userLimbs'])){
    print('Заполните конечности.<br/>');
    $errors = TRUE;
} else if ($_POST['userLimbs']!=1 && $_POST['userLimbs']!=2 && $_POST['userLimbs']!=3){
    print('Неверно введено кол-во конечностей.<br/>');
    $errors = TRUE;
}

if($errors){
    exit();
}

$userName = $_POST['userName'];
$userEmail = $_POST['userEmail'];
$userBirthdate = $_POST['userBirthdate'];
$userGender = $_POST['userGender'];
$userLimbs = $_POST['userLimbs'];
$userBio = $_POST['userBio'];



$userAb = array();

if(!empty($_POST['ab'])){
    $n = count($_POST['ab']);
    $abCheck = array(true, true, true);
    for($i = 0; $i<$n; $i++){
        if($_POST['ab'][$i]==0 || $_POST['ab'][$i]==1 || $_POST['ab'][$i]==2){
            if($_POST['ab'][$i]==0 && $abCheck[0]){
                $abCheck[0] = false;
            } else if($_POST['ab'][$i]==1 && $abCheck[1]){
                $abCheck[1] = false;
            } else if($_POST['ab'][$i]==2 && $abCheck[2]){
                $abCheck[2] = false;
            } else{
                print("Incorrect input='select' data");
                exit();
            }
        }else{
            print("Incorrect input='select' data");
            exit();
        }
    }
    for($i=0; $i<3; $i++){
        if(!$abCheck[$i]){
            $userAb[$i] = 1;
        } else{
            $userAb[$i] = 0;
        }
    }
} else {
    for($i=0; $i<3; $i++){
        $userAb[$i]=0;
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
    if(!$stmt_1->execute()){
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
    if(!$stmt_2->execute()){
        print('execute2 error ');
    }
}

catch(PDOException $e){
    print('Error : ' . $e->getMessage());
    exit();
}

print("Успешно!");
exit();
