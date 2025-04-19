<?php
require "include/header.inc.php";
require "include/function.inc.php";

$dateActuelle = date('Y-m-d');

// Appel des fonctions
?>
  <main>
	<section>
<?php
	afficherImageNASA($dateActuelle);
?>
  </section>
  <section>
<?php
	geoLocaliser();
?>
  </section>
  <section>
<?php
	extractionIPInfo();
?>
  </section>
  <section>
<?php
	extractionWhatIsMyIP();
?>
  </section>
</main>
<?php
	require './include/footer.inc.php'; 
?>