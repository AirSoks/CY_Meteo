<?php 
	require './include/header.inc.php'; 
?>

	<h2 class = "centrer">Résultat du traitement</h2>

<?php
$method = $_SERVER['REQUEST_METHOD']; // GET ou POST
$data = $method === 'POST' ? $_POST : $_GET;

	if (isset($data['texte']) && isset($data['decimal'])) {
		$texte = strtoupper($data['texte']);
		$decimal = (int)$data['decimal'];
		$hex = strtoupper(dechex($decimal));

		echo "<p>Texte en majuscules : <strong>$texte</strong></p>";
		echo "<p>Décimal : <strong>$decimal</strong></p>";
		echo "<p>Hexadécimal : <strong>$hex</strong></p>";
	} else {
		echo "<p>Formulaire non rempli correctement.</p>";
	}
?>

<?php 
	require './include/footer.inc.php'; 
?>