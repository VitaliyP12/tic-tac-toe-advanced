<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $conn = new mysqli('localhost', 'root', '', 'tic_tac_toe');
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT id, password FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->bind_result($id, $hash);
    $stmt->fetch();

    if (password_verify($password, $hash)) {
        $_SESSION['user_id'] = $id;
        $_SESSION['username'] = $username;
        header("Location: index.php");
    } else {
        $error = "Неправильний логін або пароль";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="styles.css">
    <title>Авторизація</title>
</head>
<body>
    <form method="POST">
        <h2>Авторизація</h2>
        <input type="text" name="username" placeholder="Логін" required>
        <input type="password" name="password" placeholder="Пароль" required>
        <button type="submit">Увійти</button>
        <?php if (isset($error)): ?>
            <p style="color: red;"><?= $error ?></p>
        <?php endif; ?>
        <p>Немає акаунта? <a href="register.php">Реєстрація</a></p>
    </form>
</body>
</html>
