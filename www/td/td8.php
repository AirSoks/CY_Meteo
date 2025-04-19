<?php

$title = "TD8";
$description = "Résolution du td8 à venir";

require_once "include/header.inc.php";
require_once "include/functions.inc.php";

$size = isset($_GET['size']) && ctype_digit($_GET['size']) ? (int) $_GET['size'] : TAILLE_PAR_DEFAUT;

$exercicesAafficher = [1, 2, 3];
echo genererMenuExercices($exercicesAafficher);
?>
    <main>
        <h1>TD8</h1>
		<section id="ex1" >
			<h2>Exercice 1 : fonction, tableau PHP et manipulations de chaînes de caractères : URL</h2>
			<h3>Test avec : "https://www.cyu.fr"</h3>
			<?php 
				$url = "https://www.cyu.fr";
				echo "<p>";
				print_r(extractUrlInfo($url));
				echo "</p>";
			?>
			<h3>Test avec : "http://ratp.fr/"</h3>
			<?php 
				$url = "http://ratp.fr/";
				echo "<p>";
				print_r(extractUrlInfo($url));
				echo "</p>";
			?>
		</section>
		<section id="ex2" >
			<h2>Exercice 2 : fonction et tableaux PHP : chmod</h2>
			<h3>Test avec : 400</h3>
			<?php 
				echo "<p>"."400 => " . chmodToText(400) . "</p>";
			?>
			<h3>Test avec : 640</h3>
			<?php 
				echo "<p>"."640 => " . chmodToText(640) . "</p>";
			?>
			<h3>Test avec : 755</h3>
			<?php 
				echo "<p>"."755 => " . chmodToText(755) . "</p>";
			?>
			<h3>Test avec : 890 (une valeur fausse)</h3>
			<?php 
				echo "<p>"."890 => " . chmodToText(890) . "</p>";
			?>
		</section>
		
		<section id="ex3" >
			<h2>Exercice 3 : liens paramétrés : passage d’information du client(navigateur) au serveur Web.</h2>
			<h3>Test des liens avec 2 paramètres </h3>
				<p><a href="index.php?lang=fr&amp;style=alternatif" class="link">Version Française - Mode Sombre</a></p>
				<p><a href="index.php?lang=en&amp;style=bright" class="link">English Version - Light Mode</a></p>
			<h3>Changer la taille de la table de multiplication</h3>
				<p><a href="td8.php?size=5" class="link">5x5</a></p>
				<p><a href="td8.php?size=10" class="link">10x10 (défaut)</a></p>
				<p><a href="td8.php?size=12" class="link">12x12</a></p>
				<p><a href="td8.php?size=20" class="link">20x20</a></p>
				<?= genererTableMultiplication($size); ?>
		</section>

<?php require_once "include/footer.inc.php"; ?>
