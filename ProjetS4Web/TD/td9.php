<?php
	require "./include/header.inc.php";
?>
<?php
	require_once "./include/functions.inc.php";
?>
<main>
	<section>
		<h2 class = "centrer"> Exercice 1 Formulaire de recherche </h2>
		<div class = "center" style='color: #FF3399;'>
		<form action="https://www.google.fr/search" method="get">
			<label for="search">Rechercher :</label>
			<input type="search" id="search" name="q" placeholder="Tapez votre recherche">
			<button type="submit">Rechercher</button>
		</form>
		</div>
	</section>
	
	<section>
		<h2 class = "centrer"> Exercice 2 </h2>
		<div class = "center" style='color: #FF3399;'>
		<form action="traitement.php?texte" method="get">
			<label for="texte">Texte (minuscules) :</label>
			<input type="text" name="texte" id="texte" required>
			<button type="submit">Envoyer</button>
		</form>
		</div>
	</section>
	<section>
		<h2 class = "centrer"> Exercice 2 Bis </h2>
		<div class = "center" style='color: #FF3399;'>
		 <form action="provisoire.php" method="get">
			<label for="texte">Texte (minuscules) :</label>
			<input type="text" name="texte" id="texte" required><br><br>
			<label for="decimal">Nombre décimal :</label>
			<input type="number" name="decimal" id="decimal" required><br><br>
			<button type="submit">Envoyer</button>
		</form>
		</div>
	</section>
	<section>
		<h2 class = "centrer"> Exercice 2 ter </h2>
	</section>
</main>
<?php
	require "./include/footer.inc.php";
?>