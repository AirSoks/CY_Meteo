<?php 

$title = "Accueil";
$description = "Bienvenue sur mon Meteo COZI";

require './include/header.inc.php'; 
?>
<main>
<h1>Météo CoZi</h1>
    <button> Choisir votre ville</button>

<div class="main-section">
	<?php 
		require './include/carte-interactive.php'; 
	?>

  <div class="search-form">
    <label for="region">Région</label>
    <input type="text" id="region" placeholder="Île de France">

    <label for="departement">Département</label>
    <input type="text" id="departement" placeholder="Val d'Oise">

    <label for="ville">Ville</label>
    <input type="text" id="ville" placeholder="Paris">

    <button type="submit">Chercher</button>
  </div>
</div>
</main>

<?php 
require './include/footer.inc.php'; 
?>