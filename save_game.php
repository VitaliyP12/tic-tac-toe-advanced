<?php
session_start();
$conn = new mysqli('localhost', 'root', '', 'tic_tac_toe');

if ($conn->connect_error) {
    die(json_encode(['message' => 'Помилка з\'єднання: ' . $conn->connect_error]));
}

$data = json_decode(file_get_contents('php://input'), true);

if (isset($data['winner'])) {
    $winner = $data['winner'];

    // Знаходимо ID переможця
    $stmt = $conn->prepare("SELECT id FROM users WHERE username = ?");
    $stmt->bind_param("s", $winner);
    $stmt->execute();
    $stmt->bind_result($winner_id);
    $stmt->fetch();
    $stmt->close();

    if ($winner_id) {
        // Зберігаємо результат гри
        $player1_id = $_SESSION['user_id'];
        $insert_game = $conn->prepare("INSERT INTO games (player1_id, winner_id) VALUES (?, ?)");
        $insert_game->bind_param("ii", $player1_id, $winner_id);
        if ($insert_game->execute()) {
            echo json_encode(['message' => 'Результат гри збережено.']);
        } else {
            echo json_encode(['message' => 'Помилка збереження результату: ' . $conn->error]);
        }
        $insert_game->close();
    } else {
        echo json_encode(['message' => 'Переможця не знайдено.']);
    }
} else {
    echo json_encode(['message' => 'Неправильні дані.']);
}

$conn->close();
?>
