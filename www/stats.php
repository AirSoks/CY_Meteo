<?php

require "include/header.inc.php";
require "include/function.inc.php";

// Génération du graphique en fichier PNG
$csvPath = './csv/logs.csv';
$imagePath = './images/graphique_villes.png';

$topVilles = getTop10Villes($csvPath);

// Si le dossier n'existe pas, le créer
if (!is_dir('./images')) {
    mkdir('./images', 0777, true);
}

// Générer l'image sur le serveur
if (!empty($topVilles)) {
    genererGraphique($topVilles, $imagePath,$modeText);
}
?>
<main>
	<h2>Top 10 des villes les plus fréquentes</h2>
	<div class="image-container">
		<img src="images/graphique_villes.png" alt="Graphique des villes">
	</div>
</main>
<?php require './include/footer.inc.php'; ?>