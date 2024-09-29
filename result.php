<?php
require_once "templates/header.php";

if (!playersRegistered()) {
    header("location: index.php");
}

resetBoard();
?>

<div class="welcome">
    <h1>
        <?php
        if ($_GET['player']) {
            echo currentPlayer() . " won!";
        } else {
            echo "It's a tie!";
        }
        ?>
    </h1>

    <div class="player-name">
        <?php echo playerName('x')?>'s score: <b><?php echo score('x')?></b>
    </div>

    <div class="player-name">
        <?php echo playerName('o')?>'s score: <b><?php echo score('o')?></b>
    </div>

    <a href="play.php">Play again</a><br />
    <a href="index.php" class="reset-btn">Reset</a>
</div>

<?php
require_once "templates/footer.php";
?>
