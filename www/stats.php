<?php
	$title = "Statistiques";
	$description = "Voici les statistqiues des villes les plus consultées.";
	
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
		genererGraphique($topVilles, $imagePath,$theme);
	}
?>

<main>
	<h1>Top 10 des villes les plus consultées</h1>
	<section>
	<h2>Graphique des villes</h2>
		<img src="images/graphique_villes.png" alt="Graphique des villes les plus visitées"/>
	</section>
</main>

<?php require './include/footer.inc.php'; ?>