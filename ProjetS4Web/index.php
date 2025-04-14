<?php 
$title = "Accueil";
$description = "Bienvenue sur mon Meteo COZI";

require './include/header.inc.php'; 
?>

<?php 
require './include/function.inc.php'; 
?>

<main>

  <div class="hero-section">
  <h1 class="hero-title">Météo CoZi</h1>
  <button class="hero-button">Connaître la météo</button>
</div>
  <?php afficherImageAleatoire(); ?>
  <div class="main-section">
  <div class="carte-container">
    <?php 
      require './include/carte-interactive.php'; 
    ?>
	</div>
	<div class="search-wrapper">
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
  </div>

</main>

<?php 
// Utilisation de include pour éviter une erreur fatale si le fichier est manquant
@include './include/footer.inc.php'; 
?>
