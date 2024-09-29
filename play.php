<?php
require_once "templates/header.php";

if (!playersRegistered()) {
    header("location: index.php");
}

// Handle the move
if ($_POST['cell']) {
    $win = play($_POST['cell']);

    if ($win) {
        header("location: result.php?player=" . getTurn());
    }
}

// If there are 9 plays and no winner, declare a draw
if (playsCount() >= 9) {
    header("location: result.php");
}
?>

<h2><?php echo currentPlayer() ?>'s turn</h2>

<form method="post" action="play.php">
    <table class="tic-tac-toe" cellpadding="0" cellspacing="0">
        <tbody>
        <?php
        $lastRow = 0;
        for ($i = 1; $i <= 9; $i++) {
            $row = ceil($i / 3);

            if ($row !== $lastRow) {
                $lastRow = $row;
                if ($i > 1) echo "</tr>";
                echo "<tr class='row-{$row}'>";
            }

            $additionalClass = ($i == 2 || $i == 8) ? 'vertical-border' : (($i == 4 || $i == 6) ? 'horizontal-border' : (($i == 5) ? 'center-border' : ''));

            echo "<td class='cell-{$i} {$additionalClass}'>";
            echo getCell($i) ?: "<input type='radio' name='cell' value='{$i}' onclick='enableButton()'/>";
            echo "</td>";
        }
        ?>
        </tr>
        </tbody>
    </table>

    <button type="submit" disabled id="play-btn">Play</button>
</form>

<script type="text/javascript">
    function enableButton() {
        document.getElementById('play-btn').disabled = false;
    }
</script>

<?php
require_once "templates/footer.php";
?>
