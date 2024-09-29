<?php

session_start();
error_reporting(E_ERROR | E_PARSE);

// Registers the players and initializes the game state
function registerPlayers($playerX="", $playerO="") {
    $_SESSION['PLAYER_X_NAME'] = $playerX;
    $_SESSION['PLAYER_O_NAME'] = $playerO;
    setTurn('x');
    resetBoard();
    resetWins();
}

// Resets the game board
function resetBoard() {
    resetPlaysCount();
    $_SESSION['MOVES'] = [];  // Store moves for the current game - 29/09/2024
    for ($i = 1; $i <= 9; $i++) {
        unset($_SESSION['CELL_' . $i]);
    }
}

// Resets win counts for both players
function resetWins() {
    $_SESSION['PLAYER_X_WINS'] = 0;
    $_SESSION['PLAYER_O_WINS'] = 0;
}

// Counts the number of plays
function playsCount() {
    return $_SESSION['PLAYS'] ?? 0;
}

// Increases the play count
function addPlaysCount() {
    $_SESSION['PLAYS'] = $_SESSION['PLAYS'] ?? 0;
    $_SESSION['PLAYS']++;
}

// Resets the play count to 0
function resetPlaysCount() {
    $_SESSION['PLAYS'] = 0;
}

// Returns the name of the player
function playerName($player='x') {
    return $_SESSION['PLAYER_' . strtoupper($player) . '_NAME'];
}

// Checks if players are registered
function playersRegistered() {
    return isset($_SESSION['PLAYER_X_NAME'], $_SESSION['PLAYER_O_NAME']);
}

// Sets the turn for the player
function setTurn($turn='x') {
    $_SESSION['TURN'] = $turn;
}

// Returns the current player's turn
function getTurn() {
    return $_SESSION['TURN'] ?? 'x';
}

// Marks a win for the current player
function markWin($player='x') {
    $_SESSION['PLAYER_' . strtoupper($player) . '_WINS']++;
}

// Switches turn between players
function switchTurn() {
    $_SESSION['TURN'] = ($_SESSION['TURN'] === 'x') ? 'o' : 'x';
}

// Returns the current player's name
function currentPlayer() {
    return playerName(getTurn());
}

// Processes a play
function play($cell='') {
    if (getCell($cell)) {
        return false;
    }

    $_SESSION['CELL_' . $cell] = getTurn();
    $_SESSION['MOVES'][$cell] = getTurn();  // Log the move
    addPlaysCount();

    $win = playerPlayWin($cell);
    if ($win) {
        markWin(getTurn());
        logResult(getTurn() . " wins");
        logResult_db(getTurn() . " wins");
        resetBoard();
    } elseif (playsCount() >= 9) {
        logResult("Draw");
        logResult_db("Draw");
        return 'draw';
    } else {
        switchTurn();
    }

    return $win;
}


// Retrieves the value of a cell (X or O)
function getCell($cell='') {
    return $_SESSION['CELL_' . $cell] ?? '';
}

// Checks for a win based on the current player's move
function playerPlayWin($cell=1) {
    if (playsCount() < 3) {
        return false;
    }

    $column = $cell % 3 ?: 3;
    $row = ceil($cell / 3);

    return isVerticalWin($column, getTurn()) || isHorizontalWin($row, getTurn()) || isDiagonalWin(getTurn());
}

// Checks for vertical win
function isVerticalWin($column=1, $turn='x') {
    return getCell($column) == $turn &&
           getCell($column + 3) == $turn &&
           getCell($column + 6) == $turn;
}

// Checks for horizontal win
function isHorizontalWin($row=1, $turn='x') {
    $start = ($row - 1) * 3 + 1;
    return getCell($start) == $turn &&
           getCell($start + 1) == $turn &&
           getCell($start + 2) == $turn;
}

// Checks for diagonal win
function isDiagonalWin($turn='x') {
    return (getCell(1) == $turn && getCell(5) == $turn && getCell(9) == $turn) ||
           (getCell(3) == $turn && getCell(5) == $turn && getCell(7) == $turn);
}

// Returns the score for a player
function score($player='x') {
    return $_SESSION['PLAYER_' . strtoupper($player) . '_WINS'] ?? 0;
}

function logResult($outcome) {
    $data = [
        'player_x' => playerName('x'),
        'player_o' => playerName('o'),
        'moves' => $_SESSION['MOVES'],  
        'outcome' => $outcome,
        'timestamp' => date('Y-m-d H:i:s')
    ];

    // Convert data to JSON and append to a file
    $file = fopen('game_results.json', 'a');
    fwrite($file, json_encode($data) . "\n");
    fclose($file);
}

function logResult_db($outcome) {

    $db = new PDO('mysql:host=localhost;dbname=tictactoe', 'root', '');
    $stmt = $db->prepare("
        INSERT INTO games (player_x_name, player_o_name, moves, outcome)
        VALUES (:player_x_name, :player_o_name, :moves, :outcome)
    ");
    $stmt->execute([
        ':player_x_name' => playerName('x'),
        ':player_o_name' => playerName('o'),
        ':moves' => json_encode($_SESSION['MOVES']),  // Store moves as JSON
        ':outcome' => $outcome,
    ]);
}

?>
