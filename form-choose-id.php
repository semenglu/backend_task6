<?php
if (!empty($_POST['id_choose'])) {
    $id_choose = $_POST['id_choose'];
    $conn = new mysqli('localhost','u52980','7655906','u52980');
    $result = $conn->query("SELECT 1 FROM users WHERE id = '$id_choose' LIMIT 1");
    setcookie('id_choose_value', $id_choose);
    if (mysqli_num_rows($result) <= 0) {
        setcookie('id_choose_error', '1');
        setcookie('choose_msg', '<div class="error-msg">Пользователь с таким id не найден.</div>');
    }
    else {
      $query = $conn->query("SELECT * FROM users WHERE id = '$id_choose' LIMIT 1");
      $result = mysqli_fetch_assoc($query);
    
      setcookie('name_choose_value', $result['name']);
      setcookie('email_choose_value', $result['email']);
      setcookie('birth_date_choose_value', $result['birth_date']);
      setcookie('gender_choose_value', $result['gender']);
      setcookie('limbs_choose_value', $result['limbs']);

      $query = "SELECT * FROM user_superpowers WHERE user_id = '$id_choose' LIMIT 4";
      $query_run = mysqli_query($conn, $query);
      foreach ($query_run as $row) {
        switch ($row['superpower_id']) {
          case 1:
            setcookie('immortality_choose_value', 'selected');
            break;
          case 2:
            setcookie('levitation_choose_value', 'selected');
            break;
          case 3:
            setcookie('wall_passing_choose_value', 'selected');
            break;
          case 4:
            setcookie('telekinesis_choose_value', 'selected');
            break;
        }
      }

      setcookie('bio_choose_value', $result['bio']);
      setcookie('login_choose_value', $result['login']);
      setcookie('choose_msg', "<h6 class=\"fw-bold mb-3\">Данные пользователя с id = $id_choose</h6>");
    }
    $conn->close();
}

header('Location: admin.php');
?>