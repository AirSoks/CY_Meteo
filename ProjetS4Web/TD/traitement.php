<?php 
	require './include/header.inc.php'; 
?>

<h2 class = "centrer">Résultat du traitement</h2>

<?php
	$texte = $_GET['texte'];
	if (isset($_GET['texte'])) {
		$texte = $_GET['texte'];
		echo "<p>En majuscules : <strong>" . strtoupper($texte) . "</strong></p>";
	} else {
		echo "<p>Aucune donnée reçue.</p>";
	}
?>

<?php 
	require './include/footer.inc.php'; 
?>