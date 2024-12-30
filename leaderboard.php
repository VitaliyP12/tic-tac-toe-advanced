<?php
session_start();
if (!isset($_SESSION['user_id']) || !isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}

$conn = new mysqli('localhost', 'root', '', 'tic_tac_toe');

if ($conn->connect_error) {
    die("Помилка з'єднання: " . $conn->connect_error);
}

$query = "SELECT users.username, COUNT(games.winner_id) AS wins 
          FROM users 
          LEFT JOIN games 
          ON users.id = games.winner_id 
          GROUP BY users.id 
          ORDER BY wins DESC";
$result = $conn->query($query);
?>
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="styles.css">
    <title>Таблиця лідерів</title>
</head>
<body>
    <h1>Таблиця лідерів</h1>
    <table>
        <thead>
            <tr>
                <th>Гравець</th>
                <th>Перемоги</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($row['username']) ?></td>
                    <td><?= htmlspecialchars($row['wins']) ?></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
    <div class="container-buttons">
        <a href="index.php"><button>На головну</button></a>
    </div>
</body>
</html>
