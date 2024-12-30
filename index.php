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
    <title>Ласкаво просимо!</title>
</head>
<body>
    <h1>Ласкаво просимо, <?= htmlspecialchars($username) ?>!</h1>
    <div class="container-buttons">
        <a href="game.php"><button>Грати</button></a>
        <a href="leaderboard.php"><button>Таблиця лідерів</button></a>
        <a href="logout.php"><button>Вийти</button></a>
    </div>
</body>
</html>
