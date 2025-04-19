<?php 

$title = "TD5";
$description = "Voici la résolution du td5 traitant du php pour les débutants";

require_once "include/header.inc.php";
require_once "include/functions.inc.php";

$exercicesAafficher = [1, 2, 3, 4, 5];
echo genererMenuExercices($exercicesAafficher);
?>
    <main>
		<h1>TD5 : PHP - introduction aux pages dynamiques</h1>
        <section  id="ex1" >
			<h2>Exercice 1 : fonction prédéfinie</h2>
			<?php echo "<p>Heure actuelle : " . date("H:i:s") . "</p>"; ?>
		</section>
		
		<section  id="ex2" >
			<h2>Exercice 2 : fonction et boucles</h2>
			<?php echo "<ul>" . listeHello() . "</ul>"; ?>
		</section>
		
		<section  id="ex3" >
			<h2>Exercice 3 : conversions ASCII</h2>
			<?php echo conversion(); ?>
		</section>
		
		<section id="ex4" >
			<h2>Exercice 4 : fonctions prédéfinies et boucles</h2>
			<?php echo "<ul class='liste-hex'>" . listeHexa() . "</ul>"; ?>
		</section>
		
		<section  id="ex5" >
			<h2>Exercice 5 : boucles PHP, fonctions prédéfinies et tableau HTML</h2>
			<?php echo listeTableau(); ?>
		</section>
<? require_once "include/footer.inc.php"; ?>
