<?php
session_start();
if (!isset($_SESSION['user_id']) || !isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}

$username = $_SESSION['username'];
?>
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="styles.css">
    <title>Гра "Хрестики-нулики"</title>
</head>
<body>
    <h1>Гра "Хрестики-нулики"</h1>
    <div id="game-board"></div>
    <p id="status"></p>
    <button id="restart">Почати заново</button>
    <a href="index.php">Повернутися на головну</a>
    <script>
        const currentPlayer = "<?= htmlspecialchars($username) ?>"; // Передаємо ім'я гравця
    </script>
    <script src="game.js"></script>
</body>
</html>
