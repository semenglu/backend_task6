<?php
if (!isset($_SERVER['PHP_AUTH_USER']) || !isset($_SERVER['PHP_AUTH_PW'])) {
    header('HTTP/1.1 401 Unauthorized');
    header('WWW-Authenticate: Basic realm="Admin Page"');
    print('<h1>401 Требуется авторизация</h1>');
    exit();
} else {
    $login = $_SERVER['PHP_AUTH_USER'];
    $pass = $_SERVER['PHP_AUTH_PW'];
    $conn = new mysqli('localhost','u52980','7655906','u52980');
    $result = $conn->query("SELECT * FROM admins WHERE login = '$login' LIMIT 1");
    $conn->close();
    $pass_hash = mysqli_fetch_assoc($result);
    $pass_hash = $pass_hash['pass_hash'];
    if (md5($pass.'adjfk') != $pass_hash) {
        header('HTTP/1.1 401 Unauthorized');
        header('WWW-Authenticate: Basic realm="Admin Page"');
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Page</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <style>
        .error {
            border: 2px solid red;
        }
    </style>
</head>

<?php
$values = array();
if (isset($_COOKIE['id_delete_value'])) {
    $values['id_delete'] = $_COOKIE['id_delete_value'];
    setcookie('id_delete_value', '', 100000);
} else {
    $values['id_delete'] = '';
}

if (isset($_COOKIE['confirm_delete_value'])) {
    $values['confirm_delete'] = $_COOKIE['confirm_delete_value'];
    setcookie('confirm_delete_value', '', 100000);
} else {
    $values['confirm_delete'] = '';
}

if (isset($_COOKIE['id_choose_value'])) {
    $values['id_choose'] = $_COOKIE['id_choose_value'];
    //setcookie('id_choose_value', '', 100000);
} else {
    $values['id_choose'] = '';
}

if (isset($_COOKIE['name_choose_value'])) {
    $values['name_choose'] = $_COOKIE['name_choose_value'];
    setcookie('name_choose_value', '', 100000);
} else {
    $values['name_choose'] = '';
}

if (isset($_COOKIE['email_choose_value'])) {
    $values['email_choose'] = $_COOKIE['email_choose_value'];
    setcookie('email_choose_value', '', 100000);
} else {
    $values['email_choose'] = '';
}

if (isset($_COOKIE['birth_date_choose_value'])) {
    $values['birth_date_choose'] = $_COOKIE['birth_date_choose_value'];
    setcookie('birth_date_choose_value', '', 100000);
} else {
    $values['birth_date_choose'] = '';
}

if (isset($_COOKIE['gender_choose_value'])) {
    $values['gender_choose'] = $_COOKIE['gender_choose_value'];
    setcookie('gender_choose_value', '', 100000);
} else {
    $values['gender_choose'] = '';
}

if (isset($_COOKIE['limbs_choose_value'])) {
    $values['limbs_choose'] = $_COOKIE['limbs_choose_value'];
    setcookie('limbs_choose_value', '', 100000);
} else {
    $values['limbs_choose'] = '';
}

if (isset($_COOKIE['immortality_choose_value'])) {
    $values['immortality_choose'] = $_COOKIE['immortality_choose_value'];
    setcookie('immortality_choose_value', '', 100000);
} else {
    $values['immortality_choose'] = '';
}

if (isset($_COOKIE['levitation_choose_value'])) {
    $values['levitation_choose'] = $_COOKIE['levitation_choose_value'];
    setcookie('levitation_choose_value', '', 100000);
} else {
    $values['levitation_choose'] = '';
}

if (isset($_COOKIE['wall_passing_choose_value'])) {
    $values['wall_passing_choose'] = $_COOKIE['wall_passing_choose_value'];
    setcookie('wall_passing_choose_value', '', 100000);
} else {
    $values['wall_passing_choose'] = '';
}

if (isset($_COOKIE['telekinesis_choose_value'])) {
    $values['telekinesis_choose'] = $_COOKIE['telekinesis_choose_value'];
    setcookie('telekinesis_choose_value', '', 100000);
} else {
    $values['telekinesis_choose'] = '';
}

if (isset($_COOKIE['bio_choose_value'])) {
    $values['bio_choose'] = $_COOKIE['bio_choose_value'];
    setcookie('bio_choose_value', '', 100000);
} else {
    $values['bio_choose'] = '';
}

if (isset($_COOKIE['login_choose_value'])) {
    $values['login_choose'] = $_COOKIE['login_choose_value'];
    setcookie('login_choose_value', '', 100000);
} else {
    $values['login_choose'] = '';
}

$messages = array();
if (isset($_COOKIE['delete_msg'])) {
    $messages['delete'] = $_COOKIE['delete_msg'];
    setcookie('delete_msg', '', 100000);
} else {
    $messages['delete'] = '';
}

if (isset($_COOKIE['choose_msg'])) {
    $messages['choose'] = $_COOKIE['choose_msg'];
    setcookie('choose_msg', '', 100000);
} else {
    $messages['choose'] = '';
}

$errors = array();
if (isset($_COOKIE['delete_error'])) {
    $errors['delete'] = $_COOKIE['delete_error'];
    setcookie('delete_error', '', 100000);
} else {
    $errors['delete'] = '';
}

if (isset($_COOKIE['id_choose_error'])) {
    $errors['id_choose'] = $_COOKIE['id_choose_error'];
    setcookie('id_choose_error', '', 100000);
} else {
    $errors['id_choose'] = '';
}

if (isset($_COOKIE['superpower_id'])) {
    $superpower_id = $_COOKIE['superpower_id'];
    setcookie('superpower_id', '', 100000);
} else {
    $superpower_id = '';
}
?>

<body>
    <div class="w-100 bg-dark">
        <div class="container p-5 mb-2 text-center text-white">
            <h1>Admin Page</h1>
        </div>
    </div>

    <div class="container text-center">
        <div class="row mt-5">
            <div class="col mb-4">
                <div class="card bg-dark text-white" style="border-radius: 1rem;">
                    <div class="card-body p-5 text-center">
                        <form action="form-choose-id.php" method="POST">
                            <h5 class="fw-bold mb-3 text-uppercase">Изменение данных пользователя</h5>
                            <label>
                                ID пользователя:<br />
                                <input name="id_choose" placeholder="Введите id" class="form-control<?php if (!empty($errors['id_choose'])) {print ' error';} ?>" value="<?php print $values['id_choose']; ?>" />
                            </label><br /><br />
                            <button class="btn btn-success mb-3">Применить</button>
                        </form>

                        <form action="form-change.php" method="POST">
                            <?php if (isset($messages['choose'])) {
                                print($messages['choose']);
                            } ?>
                            <label>
                                Логин:<br />
                                <input name="login" placeholder="Логин" class="form-control" value="<?php print $values['login_choose']; ?>"/>
                            </label><br /><br />
                            <label>
                                Поле для имени:<br />
                                <input name="name" placeholder="Имя" class="form-control" value="<?php print $values['name_choose']; ?>"/>
                            </label><br /><br />
                            <label>
                                Поле для email:<br />
                                <input name="email" placeholder="test@example.com" class="form-control" value="<?php print $values['email_choose']; ?>"/>
                            </label><br /><br />
                            <label>
                                Поле для даты рождения:<br />
                                <input name="birth_date" type="date" class="form-control" value="<?php print $values['birth_date_choose']; ?>"/>
                            </label><br /><br />
                            Пол:<br />
                            <label><input type="radio" name="gender" value="m" <?php if ($values['gender_choose'] == 'm') {print 'checked';} ?>/>
                                Мужчина
                            </label>
                            <label><input type="radio" name="gender" value="f" <?php if ($values['gender_choose'] == 'f') {print 'checked';} ?>/>
                                Женщина
                            </label><br /><br />
                            Количество конечностей:<br />
                            <label><input type="radio" name="limbs" value="4" <?php if ($values['limbs_choose'] == 4) {print 'checked';} ?>/>
                                4
                            </label>
                            <label><input type="radio" name="limbs" value="6" <?php if ($values['limbs_choose'] == 6) {print 'checked';} ?>/>
                                6
                            </label>
                            <label><input type="radio" name="limbs" value="8" <?php if ($values['limbs_choose'] == 8) {print 'checked';} ?>/>
                                8
                            </label><br /><br />
                            <label>
                                Сверхспособности:<br />
                                <select name="superpowers[]" multiple="multiple" class="form-control<?php if ($errors['superpowers']) {print ' error';} ?>">
                                    <option <?php print $values['immortality_choose']; ?> value="immortality">бессмертие</option>
                                    <option <?php print $values['levitation_choose']; ?> value="levitation">левитация</option>
                                    <option <?php print $values['wall_passing_choose']; ?> value="wall_passing">прохождение сквозь стены</option>
                                    <option <?php print $values['telekinesis_choose']; ?> value="telekinesis">телекинез</option>
                                </select>
                            </label><br /><br />
                            <label>
                                Биография:<br />
                                <textarea name="bio" placeholder="Введите информацию о себе" class="form-control"><?php print $values['bio_choose']; ?></textarea>
                            </label><br /><br />
                            <button class="btn btn-outline-light mb-3">Изменить</button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col">
                <div class="card bg-dark text-white p-5" style="border-radius: 1rem;">
                    <a class="btn btn-outline-light" href="screenshots.html" role="button">Скриншоты</a>
                </div>

                <div class="card bg-dark text-white my-4 my-md-5" style="border-radius: 1rem;">
                    <div class="card-body p-5 text-center">
                        <form action="form-delete.php" method="POST">
                            <h5 class="fw-bold mb-3 text-uppercase">Удаление пользователя</h5>
                            <label>
                                ID пользователя:<br />
                                <input name="id_delete" placeholder="Введите id" class="form-control<?php if ($errors['delete'] == 1) {print ' error';} ?>" value="<?php print $values['id_delete']; ?>" />
                            </label><br />
                            <?php if ($errors['delete'] == 1) {
                                print($messages['delete']);
                            } ?>
                            <label class="mt-4">
                                Подтверждение удаления:<br />
                                <input name="confirm_delete" placeholder="Напишите &quot;Удалить&quot;" class="form-control<?php if ($errors['delete'] == 2) {print ' error';} ?>" value="<?php print $values['confirm_delete']; ?>" />
                            </label><br />
                            <?php if ($errors['delete'] == 2) {
                                print($messages['delete']);
                            } ?>
                            <button class="btn btn-danger mt-4 mb-3">ОК</button>
                            <?php if (empty($errors['delete'])) {
                                print($messages['delete']);
                            } ?>
                        </form>
                    </div>
                </div>

                <div class="card bg-dark text-white" style="border-radius: 1rem;">
                    <div class="card-body p-5 text-center">
                        <form action="form-statistics.php" method="POST">
                            <h5 class="fw-bold mb-3 text-uppercase">Вывод статистики</h5>
                            <p class="text-white-50 my-4">Вывести всех пользователей со сверхспособностью</p>
                            <label>
                                <select name="superpower" class="form-control text-center">
                                    <option value="">--Выберите сверхспособность--</option>
                                    <option value="1">бессмертие</option>
                                    <option value="2">левитация</option>
                                    <option value="3">прохождение сквозь стены</option>
                                    <option value="4">телекинез</option>
                                </select>
                            </label><br /><br />
                            <button class="btn btn-success mb-3">Применить</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <?php if (!empty($superpower_id)) {
            switch ($superpower_id) {
                case 1:
                  $superpower = 'бессмертие';
                  break;
                case 2:
                  $superpower = 'левитация';
                  break;
                case 3:
                  $superpower = 'прохождение сквозь стены';
                  break;
                case 4:
                  $superpower = 'телекинез';
                  break;
            } ?>
            <div class="container bg-dark text-white mt-3">
                <p class="fs-3 fw-bold mb-0">Все пользователи со сверхспособностью "<?php print($superpower)?>"</p>
            </div>
            <div class="table-responsive">
                <table class="table table-dark table-striped table-bordered">
                    <thead>
                        <th>id</th>
                        <th>name</th>
                        <th>email</th>
                        <th>birth_date</th>
                        <th>gender</th>
                        <th>limbs</th>
                        <th>bio</th>
                        <th>login</th>
                        <th>pass_hash</th>
                    </thead>
                    <tbody>
                        <?php
                        $conn = new mysqli('localhost','u52980','7655906','u52980');
                        $query = "SELECT * FROM users u LEFT JOIN (SELECT * FROM user_superpowers us WHERE us.superpower_id = $superpower_id) us_r ON u.id = us_r.user_id WHERE us_r.user_id IS NOT NULL";
                        $query_run = mysqli_query($conn, $query);
                        foreach ($query_run as $row) {
                        ?>
                            <tr>
                                <td><?= $row['id'] ?></td>
                                <td><?= $row['name'] ?></td>
                                <td><?= $row['email'] ?></td>
                                <td><?= $row['birth_date'] ?></td>
                                <td><?= $row['gender'] ?></td>
                                <td><?= $row['limbs'] ?></td>
                                <td><?= $row['bio'] ?></td>
                                <td><?= $row['login'] ?></td>
                                <td><?= $row['pass_hash'] ?></td>
                            </tr>
                        <?php
                        }
                        $conn->close();
                        ?>
                    </tbody>
                </table>
            </div>
        <?php
        }
        ?>

        <div class="row mt-3">
            <div class="col">
                <div class="container bg-dark text-white">
                    <p class="fs-3 fw-bold mb-0">superpowers</p>
                </div>
                <div class="table-responsive">
                    <table class="table table-dark table-striped table-bordered">
                        <thead>
                            <th>id</th>
                            <th>superpower_name</th>
                        </thead>
                        <tbody>
                            <?php
                            $conn = new mysqli('localhost','u52980','7655906','u52980');
                            $query = "SELECT * FROM superpowers";
                            $query_run = mysqli_query($conn, $query);
                            foreach ($query_run as $row) {
                            ?>
                                <tr>
                                    <td><?= $row['id'] ?></td>
                                    <td><?= $row['superpower_name'] ?></td>
                                </tr>
                            <?php
                            }
                            $conn->close();
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col">
                <div class="container bg-dark text-white">
                    <p class="fs-3 fw-bold mb-0">admins</p>
                </div>
                <div class="table-responsive">
                    <table class="table table-dark table-striped table-bordered">
                        <thead>
                            <th>id</th>
                            <th>login</th>
                            <th>pass_hash</th>
                        </thead>
                        <tbody>
                            <?php
                            $conn = new mysqli('localhost','u52980','7655906','u52980');
                            $query = "SELECT * FROM admins";
                            $query_run = mysqli_query($conn, $query);
                            foreach ($query_run as $row) {
                            ?>
                                <tr>
                                    <td><?= $row['id'] ?></td>
                                    <td><?= $row['login'] ?></td>
                                    <td><?= $row['pass_hash'] ?></td>
                                </tr>
                            <?php
                            }
                            $conn->close();
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="row my-3">
            <div class="col-3">
                <div class="container bg-dark text-white">
                    <p class="fs-3 fw-bold mb-0">user_superpowers</p>
                </div>
                <div class="table-responsive">
                    <table class="table table-dark table-striped table-bordered">
                        <thead>
                            <th>user_id</th>
                            <th>superpower_id</th>
                        </thead>
                        <tbody>
                            <?php
                            $conn = new mysqli('localhost','u52980','7655906','u52980');
                            $query = "SELECT * FROM user_superpowers";
                            $query_run = mysqli_query($conn, $query);
                            foreach ($query_run as $row) {
                            ?>
                                <tr>
                                    <td><?= $row['user_id'] ?></td>
                                    <td><?= $row['superpower_id'] ?></td>
                                </tr>
                            <?php
                            }
                            $conn->close();
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="col-9">
                <div class="container bg-dark text-white">
                    <p class="fs-3 fw-bold mb-0">users</p>
                </div>
                <div class="table-responsive">
                    <table class="table table-dark table-striped table-bordered">
                        <thead>
                            <th>id</th>
                            <th>name</th>
                            <th>email</th>
                            <th>birth_date</th>
                            <th>gender</th>
                            <th>limbs</th>
                            <th>bio</th>
                            <th>login</th>
                            <th>pass_hash</th>
                        </thead>
                        <tbody>
                            <?php
                            $conn = new mysqli('localhost','u52980','7655906','u52980');
                            $query = "SELECT * FROM users";
                            $query_run = mysqli_query($conn, $query);
                            foreach ($query_run as $row) {
                            ?>
                                <tr>
                                    <td><?= $row['id'] ?></td>
                                    <td><?= $row['name'] ?></td>
                                    <td><?= $row['email'] ?></td>
                                    <td><?= $row['birth_date'] ?></td>
                                    <td><?= $row['gender'] ?></td>
                                    <td><?= $row['limbs'] ?></td>
                                    <td><?= $row['bio'] ?></td>
                                    <td><?= $row['login'] ?></td>
                                    <td><?= $row['pass_hash'] ?></td>
                                </tr>
                            <?php
                            }
                            $conn->close();
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <footer class="bg-dark text-white p-5">
        <div>(c) Семён Глуховский 2023</div>
    </footer>
</body>

</html>