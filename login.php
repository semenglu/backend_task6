<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Вход</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <style>
      .error {
        border: 2px solid red;
      }
    </style>

<?php

// Начинаем сессию.
session_start();

// В суперглобальном массиве $_SESSION хранятся переменные сессии.
// Будем сохранять туда логин после успешной авторизации.
// Если есть логин в сессии, то пользователь уже авторизован.
if (!empty($_SESSION['login'])) {
  if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
      $params["path"], $params["domain"],
      $params["secure"], $params["httponly"]
    );
  }

  setcookie('login_value', '', 100000);
  setcookie('pass_value', '', 100000);
  // Окончание сессии при нажатии на кнопку Выход.
  session_destroy();
  // Делаем перенаправление на форму.
  header('Location: index.php');
  exit();
}

// В суперглобальном массиве $_SERVER PHP сохраняет некторые заголовки запроса HTTP
// и другие сведения о клиненте и сервере, например метод текущего запроса $_SERVER['REQUEST_METHOD'].
if ($_SERVER['REQUEST_METHOD'] == 'GET') {

  $errors = array();
  $errors['login'] = isset($_COOKIE['login_error']) ? $_COOKIE['login_error'] : 0;
  $errors['pass'] = isset($_COOKIE['pass_error']) ? $_COOKIE['pass_error'] : 0;

  $messages = array();
  if ($errors['login'] == 1) {
    setcookie('login_error', '', 100000);
    $messages['login'] = '<div class="error-msg">Пользователя с таким логином не существует!</div>';
  } else if ($errors['login'] == 2) {
    setcookie('login_error', '', 100000);
    $messages['login'] = '<div class="error-msg">Это поле обязательно к заполнению!</div>';
  }

  if ($errors['pass'] == 1) {
    setcookie('pass_error', '', 100000);
    $messages['pass'] = '<div class="error-msg">Неверный пароль!</div>';
  } else if ($errors['pass'] == 2) {
    setcookie('pass_error', '', 100000);
    $messages['pass'] = '<div class="error-msg">Это поле обязательно к заполнению!</div>';
  }

  $values = array();
  $values['login'] = empty($_COOKIE['login_value']) ? '' : $_COOKIE['login_value'];
  $values['pass'] = empty($_COOKIE['pass_value']) ? '' : $_COOKIE['pass_value'];
?>
<body>
  <section class="vh-100">
    <div class="container py-5 h-100">
      <div class="row d-flex justify-content-center align-items-center h-100">
        <div class="col-12 col-md-8 col-lg-6 col-xl-5">
          <div class="card bg-dark text-white" style="border-radius: 1rem;">
            <div class="card-body p-5 text-center">

              <div class="mb-md-3 mt-md-4 pb-5">
                <form action="" method="POST">

                <h2 class="fw-bold mb-2 text-uppercase">Вход</h2>
                <p class="text-white-50 mb-5">Введите свой логин и пароль!</p>

                <div class="form-outline form-white mb-4">
                  <label class="form-label fw-bold" for="typeLoginX">Логин</label>
                  <input type="login" name="login" id="typeLoginX" class="form-control form-control-lg<?php if ($errors['login']) {print ' error';} ?>" placeholder="Введите логин" value="<?php print $values['login']; ?>"/>
                  <?php if (!empty($messages['login'])) {print($messages['login']);}?>
                </div>

                <div class="form-outline form-white mb-4">
                  <label class="form-label fw-bold" for="typePasswordX">Пароль</label>
                  <input type="password" name="pass" id="typePasswordX" class="form-control form-control-lg<?php if ($errors['pass']) {print ' error';} ?>" placeholder="Введите пароль" value="<?php print $values['pass']; ?>"/>
                  <?php if (!empty($messages['pass'])) {print($messages['pass']);}?>
                </div>

                <button class="btn btn-outline-light btn-lg mt-4 px-5" type="submit">Войти</button>

                </form>
              </div>

            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</body>
</html>

<?php
}
// Иначе, если запрос был методом POST, т.е. нужно сделать авторизацию с записью логина в сессию.
else {
  $login = $_POST['login'];
  $pass = $_POST['pass'];
  setcookie('login_value', $login);
  setcookie('pass_value', $pass);

  if (empty($login) || empty($pass)) {

    if (empty($login)) {
      setcookie('login_error', '2');
    }

    if (empty($pass)) {
      setcookie('pass_error', '2');
    }

    header('Location: login.php');
    exit();
  }

  // Проверяем есть ли такой логин и пароль в базе данных.
  // Выдаём сообщение об ошибках.
  $conn = new mysqli('localhost','u52980','7655906','u52980');
  $result = $conn->query("SELECT * FROM users WHERE login = '$login' LIMIT 1");
  $count = mysqli_num_rows($result);

  if ( $count == 0 ) {
    setcookie('login_error', '1');
    header('Location: login.php');
    exit();
  } else {
    $pass_hash = mysqli_fetch_assoc($result);
    $pass_hash = $pass_hash['pass_hash'];
    if (md5($pass.'ljsrg') != $pass_hash) {
      setcookie('pass_error', '1');
      header('Location: login.php');
      exit();
    }
  }
  $conn->close();

  // Если все ок, то авторизуем пользователя.
  $_SESSION['login'] = $login;

  // Делаем перенаправление.
  header('Location: index.php');
}
?>