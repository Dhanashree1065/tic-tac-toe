<?php
require_once "functions.php";

// Register players and redirect to game page
registerPlayers($_POST['player-x'], $_POST['player-o']);

if (playersRegistered()) {
    header("location: play.php");
} else {
    echo "Error: Could not register players.";
}
