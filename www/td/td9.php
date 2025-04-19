<?php

$title = "TD9";
$description = "Résolution du td9 à venir";

require_once "include/header.inc.php";
require_once "include/functions.inc.php";

$exercicesAafficher = [1, 2, 3, 4, 5, 6, 7];
echo genererMenuExercices($exercicesAafficher);
?>
    <main>
        <h1>TD 9 : formulaires HTML et traitement PHP</h1>
		<section id="ex1" >
		<h2>Exercice 1 : formulaire de recherche en utilisant un site externe (ici, un moteur de recherche)</h2>
		<h3>Formulaire :</h3>
			<form method="GET" action="https://www.google.fr/search?q=">
			    <fieldset>
			        <legend>Rechercher dans votre navigateur préféré</legend>
			        <label for="google">Google</label>
				    <input id="google" type="radio" name="navigateur" value="https://www.google.fr/search?q=" checked="checked"/>
				    <label for="bing">Bing</label>
				    <input id="bing" type="radio" name="navigateur" value="https://www.bing.com/search?q="/>
				    <label for="yahou">Yahou</label>
				    <input id="yahou"  type="radio" name="navigateur" value="https://fr.search.yahoo.com/search?q="/>
				    <label for="recherche">Votre recherche</label>
				    <input id="recherche" type="search" name="q" placeholder="Taper votre recherche"/>
				    <input type="submit" value="Valider" />
				</fieldset>
			</form>
		</section>
		<section id="ex2" >
		<h2>Exercice 2 : test simple de la méthode get</h2>
		<h3>Formulaire :</h3>
			<form method="GET">
				<label for="message">Entrez un texte en minuscule</label>
				<input id="message" type="text" name="message" pattern="[a-z]*" required="required"/>
				<label for="number">Entrez un nombre</label>
				<input id="number" type="text" name="nombre" pattern="[0-9]*" required="required"/>  
				<input type="submit" value="Valider"/>
			</form>
		<h3>Résultat :</h3>
		<?php 
			if (isset($_GET['message'])){
				$message = $_GET['message'];
				echo "<p>Texte reçu : " . strtoupper($message) . "</p>";
			} else {
				echo "<p>Aucun texte reçu</p>";
			}
			if (isset($_GET['nombre'])){
				$nombre = (int) $_GET['nombre'];
				echo "<p>Chiffre reçu : " . dechex($nombre) . "</p>";
			} else {
				echo "<p>Aucun texte reçu</p>";
			}
		?>
		</section>
		<section id="ex3" >
		<h2>Exercice 3: conversion et CSS</h2>
		<h3>Formulaire :</h3>
			<form method="GET">
				<label for="couleur">Entrez une couleur hexa</label>
				<input id="couleur" type="text" name="couleur" pattern="^#?[a-fA-F0-9]{6}" required="required"/>
				<input type="submit" value="Convertir" />
			</form>
		<h3>Résultat :</h3>
		<?php 
			if (isset($_GET['couleur'])){
				$couleur = $_GET['couleur'];
				$r = $g = $b = 0;
				$result = hexEnRgb($couleur, $r, $g, $b);
				echo "<p>" . $couleur . "→" . ($result ? "RGB($r, $g, $b)" : "ERREUR") . "</p>";
			}
			else {
				echo "<p>Aucune couleur reçu</p>";
			}
		?>
		</section>
		<section id="ex4">
		<h2>Exercice 4 : bouton-radio</h2>
		<h3>Formulaire :</h3>
		<form method="POST">
			<label for="number2" >Entrez un nombre :</label>
			<input id="number2" type="text" name="nombre_2" required="required"/>
			<fieldset>
				<legend>Choisissez la base :</legend>
				<label for="2">Base 2 (binaire)</label>
				<input id="2" type="radio" name="base" value="2"/>
				<label for="8">Base 8 (octal)</label>
				<input id="8" type="radio" name="base" value="8"/>
				<label for="10">Base 10 (décimal)</label>
				<input id="10" type="radio" name="base" value="10" checked="checked"/>
				<label for="16">Base 16 (hexadécimal)</label>
				<input id="16" type="radio" name="base" value="16"/>
			</fieldset>
			<input type="submit" value="Convertir"/>
		</form>
		<h3>Résultat :</h3>
		<?php 
		if ($_SERVER["REQUEST_METHOD"] == "POST") {
			if (isset($_POST['nombre_2'])) {
				$nombre_2 = $_POST['nombre_2'];
				$base = intval($_POST['base']);
				switch($base) {
					case 2:
						$decimal = bindec($nombre_2);
						break;
					case 8:
						$decimal = octdec($nombre_2);
						break;
					case 16:
						$decimal = hexdec($nombre_2);
						break;
					default:
						$decimal = intval($nombre_2);
				}
				echo listeTableau_2($decimal);
			}
		}
		?>
		</section>
		<section id="ex5" >
		<h2>Exercice 5 : formulaire de saisie d'URL</h2>
		<h3>Formulaire :</h3>
			<form method="GET">
				<label for="url">Entrez une url</label>
				<input id="url" type="text" name="url" />   
				<input type="submit" value="Extraction"/>
			</form>
		<h3>Résultat :</h3>
		<?php 
			if (isset($_GET['url'])) {
				$url = $_GET['url'];
				echo "<p>";
				print_r(extractUrlInfo($url));
				echo "</p>";
				
				$parsedUrl = parse_url($url);
				$domain = $parsedUrl['host'] ?? '';

				if ($domain) {
					$dnsRecords = dns_get_record($domain, DNS_A);
					if ($dnsRecords) {
						echo "<p>Adresse IP correspondante : " . $dnsRecords[0]['ip'] . "</p>";
					} else {
						echo "<p>Impossible de récupérer l'adresse IP pour ce domaine.</p>";
					}
				} else {
					echo "<p>Impossible d'extraire le nom de domaine de l'URL.</p>";
				}
			} else {
				echo "<p>Aucune url reçue</p>";
			}
		?>
		</section>
		<section id="ex6" > form control does not have a corresponding label.
		<h2>Exercice 6 : contrôle des données en provenance d’un formulaire</h2>
		<h3>Formulaire :</h3>
			<form method="GET">
				<label for="value">Entrez une valeur entre 2 et 16 </label>
				<input id="value" type="text" name="valeur_tableau" pattern="([2-9]|1[0-6])" required="required"/>
				<input type="submit" value="Valider"/>
			</form>
		<h3>Résultat :</h3>
		<?php 
			if (isset($_GET['valeur_tableau'])) {
				$valeur_tableau = intval($_GET['valeur_tableau']);
				if ( $valeur_tableau > 2 || $valeur_tableau < 2) {
					echo "<p>";
					print_r(genererTableMultiplication($valeur_tableau));
					echo "</p>";
				}
				else {
					echo "<p>La valeur n'est pas comprise entre 2 et 16</p>";
				} 
			}
			else {
				echo "<p>Aucune valeur reçue</p>";
			}
		?>
		</section>
		<section id="ex7">
		<h2>Exercice 7 : formulaire avec cases à cocher</h2>
		<form method="POST">
			<table>
				<tr>
					<th>X</th>
					<th>Lecture (r)</th>
					<th>Écriture (w)</th>
					<th>Exécution (x)</th>
				</tr>
				<tr>
					<td>Utilisateur</td>
					<td><label for="ur">user-r</label><input id="ur" type="checkbox" name="permissions[user][r]" value="r"/></td>
					<td><label for="uw">user-w</label><input id="uw" type="checkbox" name="permissions[user][w]" value="w"/></td>
					<td><label for="ux">user-x</label><input id="ux" type="checkbox" name="permissions[user][x]" value="x"/></td>
				</tr>
				<tr>
					<td>Groupe</td>
					<td><label for="gr">group-r</label><input id="gr" type="checkbox" name="permissions[group][r]" value="r"/></td>
					<td><label for="gw">group-w</label><input id="gw" type="checkbox" name="permissions[group][w]" value="w"/></td>
					<td><label for="gx">group-x</label><input id="gx" type="checkbox" name="permissions[group][x]" value="x"/></td>
				</tr>
				<tr>
					<td>Autres</td>
					<td><label for="or">others-r</label><input id="or" type="checkbox" name="permissions[others][r]" value="r"/></td>
					<td><label for="ow">others-w</label><input id="ow" type="checkbox" name="permissions[others][w]" value="w"/></td>
					<td><label for="ox">others-x</label><input id="ox"  type="checkbox" name="permissions[others][x]" value="x"/></td>
				</tr>
			</table>
			<input type="submit" value="Valider"/>
		</form>

		<?php
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			if (isset($_POST['permissions'])) {
				$octal = textToChmod($_POST['permissions']);
				echo "<p>Valeur octale : $octal</p>";
				echo "<p>Représentation textuelle :" . chmodToText($octal) ; "</p>";
			} else {
				echo "<p>Aucune permission sélectionnée</p>";
			}
		}
		?>
		</section>

<?php require_once "include/footer.inc.php"; ?>
