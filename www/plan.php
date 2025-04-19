<?php
require "include/header.inc.php";
require "include/function.inc.php";

$title = "Plan du Site";
$description = "Voici le plan de notre site avec les liens vers les différentes pages.";

?>
  <main>
    <section>
	<ul>
        <li><a href="index.php" >Page d'accueil</a></li>
        <li><a href="meteo.php" >Page Météo</a></li>
        <li><a href="propos.php" >Page à propos</a></li>
        <li><a href="stats.php" >Page des statistiques</a></li>
        <li><a href="tech.php" >Page tech</a></li>
    </ul>
    </section>
</main>

<?php
	require './include/footer.inc.php'; 
?>