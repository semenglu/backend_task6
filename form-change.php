<?php
$id = $_COOKIE['id_choose_value'];
setcookie('id_choose_value', '', 100000);
$name = $_POST['name'];
$email = $_POST['email'];
$birth_date = $_POST['birth_date'];
$gender = $_POST['gender'];
$limbs = $_POST['limbs'];
$superpowers = $_POST['superpowers'];
$bio = $_POST['bio'];
$login = $_POST['login'];
$conn = new mysqli('localhost','u52980','7655906','u52980');
$query = $conn->query("SELECT * FROM users WHERE id = '$id' LIMIT 1");
$result = mysqli_fetch_assoc($query);
$user_id = $id;
$conn->query("DELETE FROM user_superpowers WHERE user_id = $user_id LIMIT 4");
$conn->query("UPDATE users SET name='$name', email='$email', birth_date='$birth_date', gender='$gender', limbs=$limbs, bio='$bio', login='$login' WHERE id='$id'");
foreach ($superpowers as $item) {
  switch ($item) {
    case 'immortality':
      $superpower_id = 1;
      break;
    case 'levitation':
      $superpower_id = 2;
      break;
    case 'wall_passing':
      $superpower_id = 3;
      break;
    case 'telekinesis':
      $superpower_id = 4;
      break;
  }
  $stmt = $conn->prepare("INSERT INTO user_superpowers (user_id, superpower_id) VALUES (?, ?)");
  $stmt->bind_param("ii", $user_id, $superpower_id);
  $stmt->execute();
}
$stmt->close();
$conn->close();
setcookie('choose_msg', "<h6 class=\"fw-bold mb-3\">Данные пользователя с id = $id успешно изменены.</h6>");
header('Location: admin.php');
?>