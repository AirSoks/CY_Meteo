<?php 
$title = "Accueil";
$description = "Bienvenue sur mon Meteo COZI";

require './include/header.inc.php'; 
?>

<main>


<div class="donut-wrapper">
  <svg viewBox="0 0 200 200" class="donut-svg">
    <path
      d="M40,120 
         A70,70 0 1,1 160,120 
         L135,120 
         A50,50 0 1,0 65,120 
         Z"
      fill="#555"
    />
  </svg>

  <div class="donut-center-text">Nom de la ville</div>
  <div class="donut-label top-left">Température</div>
  <div class="donut-label top-right">Vitesse vent</div>
  <div class="donut-label bottom">Humidité</div>
</div>

</main>
<?php 
// Utilisation de include pour éviter une erreur fatale si le fichier est manquant
@include './include/footer.inc.php'; 
?>
