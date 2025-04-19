<?php

$title = "TD6";
$description = "Voici la résolution du td6 traitant XHTML5 et le php (tests, boucles et fonctions)";

require_once "include/header.inc.php";
require_once "include/functions.inc.php";

$exercicesAafficher = [1, 2, 3, 4];
echo genererMenuExercices($exercicesAafficher);
?>
    <main>
		<h1>TD6 : XHTML5 et PHP (tests, boucles et fonctions)</h1>
        <section id="ex1">
			<h2>Exercice 1 : fonctions PHP : boucles PHP + tableau HTML</h2>
			<h3>Table de multiplication par défaut</h3>
			<?php echo genererTableMultiplication(); ?>

			<h3>Table de multiplication avec une dimension de 5</h3>
			<?php echo genererTableMultiplication(5); ?>
		</section>
		<section id="ex2" >
			<h2>Exercice 2 : couleurs, passage de paramètre par valeur et par adresse.</h2>
			<h3>Tests de conversion RGB → Hex</h3>
			<?php 
				$test_rgb = [255, 221, 119];
				$hex = rgbEnHex($test_rgb[0], $test_rgb[1], $test_rgb[2]);
				echo "<p>RGB(255, 221, 119) → $hex</p>";
			?>

			<h3>Tests de conversion Hex → RGB</h3>
			<?php 
				$test_hex = "Fd7";
				$r = $g = $b = 0;
				$result = hexEnRgb($test_hex, $r, $g, $b);
				echo "<p>" . "Fd7 → " . ($result ? "RGB($r, $g, $b)" : "ERREUR") . "</p>";
			?>
		</section>
		<section id="ex3">
			<h2>Exercice 3 : chiffres romains</h2>

			<h3>Test avec 2025 (MMXXV)</h3>
			<?php 
				$test_2025 = "MMXXV";
				$result_2025 = romainEnDecimal($test_2025);
				echo "<p>$test_2025 → " . ($result_2025 !== false ? $result_2025 : "ERREUR") . "</p>";
			?>

			<h3>Test avec 999 (CMXCIX)</h3>
			<?php 
				$test_999 = "CMXCIX";
				$result_999 = romainEnDecimal($test_999);
				echo "<p>$test_999 → " . ($result_999 !== false ? $result_999 : "ERREUR") . "</p>";
			?>
		</section>
		<section id="ex4">
			<h2>Exercice 4 : boucles, tests et styles internes</h2>
			<?php echo genererTableAscii(); ?>
		</section>
<? require_once "include/footer.inc.php"; ?>
