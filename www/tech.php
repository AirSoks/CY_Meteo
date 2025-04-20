<?php
	$title = "Page technique";
	$description = "Voici la page tech qui contient la parti API.";
	
	require "include/header.inc.php";
	require "include/function.inc.php";

	$dateActuelle = date('Y-m-d');
?>
  <main>
  <h1>Page Technique</h1>
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