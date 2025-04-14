	<?php
	require "./include/header.inc.php";
?>
	<main>
<?php
	require_once "./include/functions.inc.php";
?>
    <h1 class = "centrer">TD PHP - Introduction aux pages dynamiques</h1>
    
    <h2 class = "centrer">Exercice 1 : Heure du serveur</h2>
    <p>Il est actuellement : <span style='color: #FF3399;'><?php echo $date; ?></span></p>
    
    <h2 class = "centrer">Exercice 2 : Liste dynamique</h2>
	<div class = "center" style='color: #FF3399;'>
    <?php echo generateList(); ?>
	</div>
    
    <h2 class = "centrer">Exercice 3 : Conversions ASCII</h2>
    <p style='color: #FF3399;'><?php echo "$hex1 = $dec1 = '$char1'"; ?></p>
    <p style='color: #FF3399;'><?php echo "$hex2 = $dec2 = '$char2'"; ?></p>
    
    <h2 class = "centrer">Exercice 4 : Liste hexadécimale</h2>
	<div class = "center" style='color: #FF3399;'>
    <?php echo hexList(); ?>
	</div>
    
    <h2 class = "centrer">Exercice 5 : Tableaux des bases numériques</h2>
	<div class = "center" style='color: #FF3399;'>
    <?php echo generateTable(); ?>
	</div>
	</main>
	<?php
	require "./include/footer.inc.php";
?>
