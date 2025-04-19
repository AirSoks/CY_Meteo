<?php

$title = "TD7";
$description = "Voici la résolution du td7 traitant les fonctions, constantes, tableaux et constructions multi-fichiers";

require_once "include/header.inc.php";
require_once "include/functions.inc.php";

$exercicesAafficher = [3, 4];
echo genererMenuExercices($exercicesAafficher);
?>
    <main>
		<h1>TD7 : PHP - fonctions, constantes, tableaux et constructions multi-fichiers</h1>
        <section id="ex3" >
			<h2>Exercice 3 : fonction PHP et tableau PHP</h2>
			<h3>Liste des régions par défaut</h3>
			<?php echo genererListeRegions(); ?>
			
			<h3>Liste des régions par liste numéroté</h3>
			<?php echo genererListeRegions('ol'); ?>
		</section>
		<section id="ex4" >
			<h2>Exercice 4 : fonctions PHP et tableaux associatifs PHP</h2>
			<?php echo "<p>" . origineDateCourante() . "</p>"; ?>
		</section>
		
<? require_once "include/footer.inc.php"; ?>
