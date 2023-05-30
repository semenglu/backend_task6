<?php
if (!empty($_POST['id_delete'])) {
    $id_delete = $_POST['id_delete'];
    $confirm_delete = $_POST['confirm_delete'];
    $conn = new mysqli('localhost','u52980','7655906','u52980');
    $result = $conn->query("SELECT 1 FROM users WHERE id = '$id_delete' LIMIT 1");
    if (mysqli_num_rows($result) <= 0) {
        setcookie('id_delete_value', $id_delete);
        setcookie('delete_error', '1');
        setcookie('delete_msg', '<div class="error-msg">Пользователь с таким id не найден.</div>');
    }
    else if (mb_strtolower($confirm_delete) != 'удалить') {
        setcookie('id_delete_value', $id_delete);
        setcookie('delete_error', '2');
        setcookie('confirm_delete_value', $confirm_delete);
        setcookie('delete_msg', '<div class="error-msg">Введите слово "Удалить", чтобы подтвердить удаление.</div>');
    }
    else {
        $conn->query("SET FOREIGN_KEY_CHECKS = 0");
        $conn->query("DELETE FROM users WHERE id = '$id_delete'");
        $conn->query("DELETE FROM user_superpowers WHERE user_id = '$id_delete'");
        $conn->query("SET FOREIGN_KEY_CHECKS = 1");
        setcookie('delete_msg', "<h6 class=\"fw-bold mb-3\">Пользователь с id = $id_delete успешно удалён.</h6>");
    }
    $conn->close();
}

header('Location: admin.php');
?>