# tic-tac-toe
This is a simple Tic Tac Toe game built using PHP for the backend and HTML/CSS for the frontend. The game allows two players to compete against each other by taking turns marking Xs and Os on a 3x3 grid. It features functionality for tracking player scores, displaying the game board, and determining the winner or a draw.

Technologies Used
PHP: For backend logic and session management.
HTML/CSS: For the user interface.
MySQL: For storing game results and player statistics.

How to start game:
Open the index.php file in your web browser to start playing.
Follow the on-screen instructions to register players and make moves.

Database Configuration
Database Name: tictactoe
Table Name: games
CREATE TABLE games (
    id INT AUTO_INCREMENT PRIMARY KEY,
    player_x_name VARCHAR(255),
    player_o_name VARCHAR(255),
    moves TEXT,           
    outcome VARCHAR(50),  
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

