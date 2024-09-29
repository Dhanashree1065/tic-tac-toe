# tic-tac-toe
This is a simple Tic Tac Toe game built using PHP for the backend and HTML/CSS for the frontend. The game allows two players to compete against each other by taking turns marking Xs and Os on a 3x3 grid. It features functionality for tracking player scores, displaying the game board, and determining the winner or a draw.

## Technologies Used
- **PHP:** For backend logic and session management.
- **HTML/CSS:** For the user interface.
- **MySQL:** For storing game results and player statistics.

## Local Setup
To run the game locally:
1. Clone the repository.
2. Set up a local server (like XAMPP, MAMP, or WAMP).
3. Place the files in the server's root directory (e.g., `htdocs` for XAMPP).
4. Access the game in your browser at `http://localhost/tic-tac-toe/index.php`.

## Database Configuration

**Database Name**: `tictactoe`  
**Table Name**: `games`

```sql
CREATE TABLE games (
    id INT AUTO_INCREMENT PRIMARY KEY,
    player_x_name VARCHAR(255),
    player_o_name VARCHAR(255),
    moves TEXT,           
    outcome VARCHAR(50),  
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);


