<?php 
$title = "Accueil";
$description = "Bienvenue sur mon Meteo COZI";

require './include/header.inc.php'; 
?>

<main>

<div class="container">
    <!-- Colonne gauche - Qui sommes-nous ? -->
    <div class="card">
        <h2>Qui sommes-nous ?</h2>
		<div class="row-images">
		<figure>
        <img src="./images/masque2Parfait.png" alt="Logo">
		<figcaption class="propos-figcaption">ZIVIC Benjamin</figcaption>
		</figure>
		<figure>
        <img src="./images/masque2Parfait.png" alt="Chat">
		<figcaption class="propos-figcaption">COSTA Mathéo</figcaption>
		</figure>
		</div>
        <img src="./images/masque2Parfait.png" alt="Bâtiment universitaire">
    </div>

    <!-- Colonne droite - Notre Projet -->
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
// Utilisation de include pour éviter une erreur fatale si le fichier est manquant
@include './include/footer.inc.php'; 
?>