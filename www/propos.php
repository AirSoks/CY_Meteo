<?php 
$title = "Accueil";
$description = "Bienvenue sur mon Meteo COZI";

require './include/header.inc.php'; 
?>
<main>
  <section>
    <h1>À propos de notre projet</h1>
    <p> Ce projet a lieu dans le cadre de notre apprentissage en développement web dans le cursus de la L2 informatique CY Paris université. Nous sommes sous la direction de Marc Lemaire Professeur Certifié qui encadre l'ensemble de l'apprentissage du développement web au sein de l'université.</p>
  </section>

  <section>
    <h2>Qui sommes-nous ?</h2>
    <div>
      <h3>Benjamin ZIVIC</h3>
      <p> Je suis étuidaint en L2 informatique à CY Paris université. J'ai un BAC qui concerne les deux spécialités suivantes : Mathématiques et Histoire Géographie Géopolitique et Sciences Politiques.
	  Après la première année qui est la L1 MIPI (Mathématiques, Informatique, Physique et Ingénierie) je me suis orienté en informatique car cette science me plaît et m'intéresse.</p>
    </div>

    <div>
      <h3>Mathéo COSTA</h3>
      <p>Description Mathéo</p>
    </div>
  </section>

</main>

<?php 
// Utilisation de include pour éviter une erreur fatale si le fichier est manquant
@include './include/footer.inc.php'; 
?>