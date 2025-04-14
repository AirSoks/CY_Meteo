

<?php
	require "./include/header.inc.php";
?>
<main>
<?php
	require_once "./include/functions.inc.php";
?>
	<h1 class = "centrer">TD6 PHP</h1>
    <h2 class = "centrer">Table par défaut (10x10)</h2>
	<div class = "center">
    <?php echo generateMultiplicationTable(); ?>
	</div>
    
    <h2 class = "centrer">Table avec dimension spécifique (5x5)</h2>
	<div class = "center">
    <?php echo generateMultiplicationTable(5); ?>
	</div>
	<h1 class = "centrer">Conversion Couleurs</h1>
    <h2 class = "centrer">RGB → Hexadécimal</h2>
    <p>RGB(255, 0, 128) → <?php echo rgbToHex(255, 0, 128); ?></p>
    
    <h2 class = "centrer">Hexadécimal → RGB</h2>
    <?php 
        $r = $g = $b = 0;
        if (hexToRgb("#FF0080", $r, $g, $b)) {
            echo "<p>#FF0080 → RGB($r, $g, $b)</p>";
        } else {
            echo "<p>Conversion échouée</p>";
        }
    ?>
	 <h1 class = "centrer">Conversion Chiffres Romains</h1>
    <h2 class = "centrer">Romain → Décimal</h2>
    <p>"XIV" → <?php echo romanToDecimal("XIV"); ?></p>
    <p>"MMXXIV" → <?php echo romanToDecimal("MMXXIV"); ?></p>
	    <h1 class = "centrer">Table ASCII</h1>
		<div class = "center">
    <?php echo generateAsciiTable(); ?>
		</div>
	</main>
		<?php
	require "./include/footer.inc.php";
?>
	
