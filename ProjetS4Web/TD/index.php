<?php
	require "./include/header.inc.php";
?>
<main>
	<?php
$lang = "french"; // langue par défaut

if (isset($_GET["lang"]) && ($_GET["lang"] == "english" || $_GET["lang"] == "french")) {
    $lang = $_GET["lang"];
}

// Chargement du fichier de langue
include_once "./include/".$lang.".inc.php";
?>
	<section>
		<h2 class = "centrer" > Qui suis-je ? </h2>
		<p> Bonjour, je suis Benjamin ZIVIC (Benji pour les intimes) et je suis actuellement étudiant en deuxième année de licence informatique (L2) à Cy Cergy Paris Université. 
		J'ai appris l'informatique à l'université de Cergy lors de ma première année de L1 MIPI. J'ai fait un bacchelor accès sur deux spécialités qui sont : Mathématiques et HGGSP (Histoire 
		géographie géopolitique et science politique). </p>
		<p> Bien que j'ai un réel intérêt pour les mathématiques je me suis toute même orienté vers une L2 informatique après ma première année universitaire car je trouve cette matière très intéressante 
		et ouvre de nombreuses portes pour la vie professionnelle.</p>
		<p> En espérant que vous trouverez des qualités à mes traveaux qui sont devant vous actuellement et qui servent mon apprentissage pour le développement web</p>
	</section>
	<section>
		<h2 class = "centrer"> Où êtes vous ? </h2>
		<p> Ceci est ma page d'accueil pour la consultation de l'ensemble de mes traveaux dirigés qui ont lieu à CY Cergy Paris Université sous la direction de Marc Lemaire professeur certifié.
		Cette page d'accueil est créé dans l'optique de mener à bien mon TD 7.</p>
		<p> Vous trouverez dans l'en-tête de cette page le menu de navigation qui vous permettra de consulter mes TD précédents qui sont le TD5 et le TD6 ainsi que le TD7 ce dernier étant celui
		sur lequel je me trouve actuellement</p>
	</section>
	<img class = "centrer" src = "./illustrations/fleurLys2.png" alt = "fleur de Lys" />
</main>
<?php
	require "./include/footer.inc.php";
?>