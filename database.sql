CREATE DATABASE tic_tac_toe;

USE tic_tac_toe;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
);

CREATE TABLE games (
    id INT AUTO_INCREMENT PRIMARY KEY,
    player1_id INT NOT NULL,
    player2_id INT,
    winner_id INT,
    played_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (player1_id) REFERENCES users(id),
    FOREIGN KEY (player2_id) REFERENCES users(id),
    FOREIGN KEY (winner_id) REFERENCES users(id)
);
