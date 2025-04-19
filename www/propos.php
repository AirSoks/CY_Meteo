<?php 
	$title = "Accueil";
	$description = "Bienvenue sur mon Meteo COZI";

	require './include/header.inc.php'; 
	require "include/function.inc.php";
?>
<main>

<div class="container">
    <div class="card">
		<h2>Qui sommes-nous ?</h2>
		<div class="team-profiles">
			<figure>
				<img src="./images/moon.jpg" alt="Logo Mathéo">
				<figcaption>COSTA Mathéo</figcaption>
			</figure>
			<figure>
				<img src="./images/fleurLys.jpg" alt="Logo Benjamin">
				<figcaption>ZIVIC Benjamin</figcaption>
			</figure>
		</div>
	</div>
    <div class="card">
        <h2>Notre Projet</h2>
			<p>Nous sommes ZIVIC Benjamin et Costa Mathéo, deux étudiants en licence d'informatique à l’université CY Cergy Paris Université, sur le site de Saint-Martin à Cergy.</p>
			<p>Ce site web a été réalisé dans le cadre de notre projet final collaboratif pour l’UE de développement web, encadrée par notre professeur Marc Lemaire.</p>
			<p>Notre objectif est simple : proposer une application web fonctionnelle, intuitive et accessible, permettant aux utilisateurs de consulter la météo en temps réel partout en France.</p>
			<p>Ce projet reflète l’ensemble des compétences que nous avons acquises durant le semestre. Il va des bases du HTML et du CSS, jusqu’à des technologies plus avancées comme PHP et JavaScript, notamment pour la mise en place de formulaires et d'une carte interactive.
			   Nous avons également découvert une nouvelle dimension du développement web avec l’intégration de plusieurs API comme notamment une API météo, qui nous a permis d’afficher des données fiables, actualisées et lisibles pour l’utilisateur.</p>
    </div>
</div>


</main>

<?php 
	require './include/footer.inc.php'; 
?>