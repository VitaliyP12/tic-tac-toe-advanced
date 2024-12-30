const board = Array(9).fill(null);
let currentPlayerName = currentPlayer;
let currentPlayerSymbol = 'X';
let gameActive = true;
const statusText = document.getElementById('status');
const gameBoard = document.getElementById('game-board');

// Створення ігрової дошки
function renderBoard() {
    gameBoard.innerHTML = '';
    for (let i = 0; i < board.length; i++) {
        const cell = document.createElement('div');
        cell.classList.add('cell');
        cell.dataset.index = i;
        cell.addEventListener('click', handleCellClick);
        cell.textContent = board[i];
        gameBoard.appendChild(cell);
    }
    statusText.textContent = `Хід гравця: ${currentPlayerName} (${currentPlayerSymbol})`;
}

// Обробка кліку на клітинку
function handleCellClick(e) {
    const index = e.target.dataset.index;

    if (!gameActive || board[index]) return;

    board[index] = currentPlayerSymbol;
    renderBoard();

    if (checkWin()) {
        statusText.textContent = `Гравець ${currentPlayerName} виграв!`;
        sendGameResult(currentPlayerName);
        gameActive = false;
    } else if (board.every(cell => cell)) {
        statusText.textContent = 'Нічия!';
        gameActive = false;
    } else {
        currentPlayerSymbol = currentPlayerSymbol === 'X' ? 'O' : 'X';
        currentPlayerName = currentPlayerName === currentPlayer ? 'Другий гравець' : currentPlayer;
        renderBoard();
    }
}

// Перевірка перемоги
function checkWin() {
    const winConditions = [
        [0, 1, 2], [3, 4, 5], [6, 7, 8],
        [0, 3, 6], [1, 4, 7], [2, 5, 8],
        [0, 4, 8], [2, 4, 6]
    ];

    for (const condition of winConditions) {
        const [a, b, c] = condition;
        if (board[a] && board[a] === board[b] && board[a] === board[c]) {
            return true;
        }
    }
    return false;
}

// Відправка результату
function sendGameResult(winner) {
    fetch('save_game.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ winner: winner })
    })
    .then(response => response.json())
    .then(data => {
        console.log(data.message);
    })
    .catch(error => console.error('Помилка:', error));
}

// Скидання гри
document.getElementById('restart').addEventListener('click', () => {
    board.fill(null);
    currentPlayerSymbol = 'X';
    currentPlayerName = currentPlayer;
    gameActive = true;
    renderBoard();
});

renderBoard();
