	<?php
	require "./include/header.inc.php";
?>

	<?php
	require_once "./include/functions.inc.php";
?>
<main>
	<h1 class = "centrer"> Liste des Régions en France </h1>
		<?php
		// Tableau contenant les noms des régions françaises
		$regionsFrance = [
			"Guadeloupe", "Martinique", "Guyane", "La Réunion", "Mayotte",
			"Île-de-France", "Centre-Val de Loire", "Bourgogne-Franche-Comté",
			"Normandie", "Hauts-de-France", "Grand Est", "Pays de la Loire",
			"Bretagne", "Nouvelle-Aquitaine", "Occitanie", "Auvergne-Rhône-Alpes",
			"Provence-Alpes-Côte d’Azur", "Corse"
		];
		?>

			<div class = "center" style='color: #FF3399;'>
				<?php echo afficherRegions($regionsFrance); ?>
			</div>
			<h1 class = "centrer"> Liste des Régions en France avec numérotation </h1>
			<div class = "center" style='color: #FF3399;'>
				<?php echo afficherRegions($regionsFrance, true); ?>
			</div>
		
		<h1 class = "centrer"> Exerice 4 TD7 </h1>
		<?php
			// Définition des tableaux associatifs pour les jours et les mois
			$joursOrigine = [
				"lundi" => "Lune",
				"mardi" => "Mars",
				"mercredi" => "Mercure",
				"jeudi" => "Jupiter",
				"vendredi" => "Vénus",
				"samedi" => "Saturne",
				"dimanche" => "Soleil"
			];

			$moisOrigine = [
				1 => "Janus (dieu romain des commencements et des fins)",
				2 => "Februa (festival romain de purification)",
				3 => "Mars (dieu romain de la guerre)",
				4 => "Apru (nom étrusque d'Aphrodite, déesse de l'amour)",
				5 => "Maia (déesse romaine de la croissance)",
				6 => "Junon (déesse romaine du mariage et de la protection)",
				7 => "Julius (nom de Jules César, qui a donné son nom au mois de juillet)",
				8 => "Augustus (nom de l'empereur Auguste, qui a donné son nom au mois d'août)",
				9 => "Sept (septième mois dans le calendrier romain original)",
				10 => "Octo (huitième mois dans le calendrier romain original)",
				11 => "Novem (neuvième mois dans le calendrier romain original)",
				12 => "Decem (dixième mois dans le calendrier romain original)"
			];
			?>
			<div class = "center" style='color: #FF3399;'>
				<?php echo origineDate($joursOrigine, $moisOrigine) ?>;
			</div>
	<h1 class = "centrer"> Exercice 5 TD7 </h1>
		<p> 
			<span style='color: #FF3399;'>
				<?php echo get_Navigateur(); ?>
			</span></p>
	</main>
	<?php
	require "./include/footer.inc.php";
	?>