<?php
if (!empty($_POST['superpower'])) {
  setcookie('superpower_id', $_POST['superpower']);
}
header('Location: admin.php');
?>