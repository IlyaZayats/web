<!DOCTYPE html>
<html lang="ru">
<head>
    <style>
        .error{
            border: 2px solid #dc3545;
        }
    </style>
    <meta charset="UTF-8">
    <meta http-equiv='X-UA-Compatible' content='IE=edge'/>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
    <title>Ex5</title>
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>

<?php
if(!empty($messages)){
    print('<div id="messages">');
  foreach ($messages as $message) {
    print($message);
  }
  print('</div>');
}
?>

    <div class="container-fluid">
        <div class="row d-flex">
            <div class="col-12 main-label text-center text-light bg-dark">
                Exercise №5
            </div>
            <div class="col-sm-8 col-md-4 mx-auto">
                <form id="thatForm" action="index.php" method="POST" enctype="multipart/form-data" accept-charset="UTF-8">
                    <div class="form-row text-light">
                        <div class="col pt-1">
                            <div>
                                Имя:
                            </div>
                            <label <?php if ($errors['userName'] || $errors['userName_wrong']) {print 'class="error"';} ?>>
                                <input class="form-control form-control-md info" type="text" name="userName" placeholder="Ваше имя" autocomplete="off" value="<?php print $values['userName']; ?>">
                            </label><br/>
                        </div>
                        <div class="col pt-1">
                            <div>
                                Email:
                            </div>
                            <label <?php if ($errors['userEmail'] || $errors['userEmail_wrong']) {print 'class="error"';} ?>>
                                <input class="form-control form-control-md info" type="text" name="userEmail" placeholder="E-mail" autocomplete="off" value="<?php print $values['userEmail']; ?>">
                            </label><br/>
                        </div>
                        <div class="col pt-1">
                            <div>
                                Дата рождения:
                            </div>
                            <label>
                                <input class="form-control form-control-md info" <?php if ($errors['userBirthdate'] || $errors['userBirthdate_wrong']) {print 'class="error"';} ?> type="date" name="userBirthdate" autocomplete="off" value="<?php print $values['userBirthdate']; ?>">
                            </label><br/>
                        </div>
                        <div class="col pt-1">
                            <div>
                                Пол:
                            </div>
                            <div <?php if ($errors['userGender'] || $errors['userGender_wrong']) {print 'class="error"';} ?>>
                                <div class="form-check">
                                    <input class="form-check-input form-check-custom-bg" type="radio" value="1" name="userGender" id="userMale" checked="<?php if($values['userGender'] == 1) {print 'checked';}?>">
                                    <label class="form-check-label" for="userMale">
                                        Мужской
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input form-check-custom-bg" type="radio" value="2" name="userGender" id="userFemale" "<?php if($values['userGender'] == 2) {print 'checked="checked"';} ?>">
                                    <label class="form-check-label" for="userFemale">
                                        Женский
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="col pt-1">
                            <div>
                                Кол-во конечностей:
                            </div>
                            <div <?php if ($errors['userLimbs'] || $errors['userLimbs_wrong']) {print 'class="error"';} ?>>
                                <div class="form-check">
                                    <input class="form-check-input form-check-custom-bg" type="radio" value="1" name="userLimbs" id="userHealthy" checked="<?php if($values['userLimbs'] == 1){print 'checked';}?>">
                                    <label class="form-check-label" for="userHealthy">
                                        2 ноги и 2 руки
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input form-check-custom-bg" type="radio" value="2" name="userLimbs" id="userDisabled" <?php if($values['userLimbs'] == 2){print 'checked="checked"';}?>>
                                    <label class="form-check-label" for="userDisabled">
                                        Чего-то не хватает
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input form-check-custom-bg" type="radio" value="3" name="userLimbs" id="userGodrik" <?php if($values['userLimbs'] == 3){print 'checked="checked"';}?>>
                                    <label class="form-check-label" for="userGodrik">
                                        Годрик сторукий
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="col pt-1">
                            <div>
                                 Ваша биография:
                            </div>
                            <label  <?php if ($errors['userBio']) {print 'class="error"';} ?>>
                                <textarea class="form-control form-control-md" name="userBio" placeholder="Ваша биография" autocomplete="off"><?php print $values['userBio']; ?></textarea>
                            </label><br/>
                        </div>
                        <div class="col pt-1">
                            <div>
                                Сверхспособности:
                            </div>
                            <label <?php if ($errors['userAb']) {print 'class="error"';} ?>>
                                <select class="form-select form-select-md" multiple aria-label="multiple select" name="ab[]">
                                    <option value="0" <?php if($values['userAb0'] == 1){print 'selected="selected"';}?>>Бессмертие</option>
                                    <option value="1" <?php if($values['userAb1'] == 1){print 'selected="selected"';}?>>Прохождение сквозь стены</option>
                                    <option value="2" <?php if($values['userAb2'] == 1){print 'selected="selected"';}?>>Левитация</option>
                                </select>
                            </label>
                        </div>
                        <div class="col pt-1">
                            <label class="text-light">
                                <input type="checkbox" id="check" name="check">
                                С контрактом согласен!
                            </label><br/>
                        </div>
                        <div class="col mt-3 pb-3">
                            <input class="btn btn-danger btn-lg" type="submit" id="submitButton" value="Свяжитесь с нами!">
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-12 fixed-bottom bg-dark text-light footer">
                (c) Ilya Zayats
            </div>
        </div>
    </div>

    <script src="js/jquery_v3.6.0.js"></script>
    <script src="js/bootstrap.js"></script>
    <script src="js/script.js"></script>

</body>

</html>