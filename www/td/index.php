<?php
$lang = isset($_GET['lang']) ? $_GET['lang'] : 'fr';
$title = "Accueil";
$description = "Bienvenue sur mon site web qui traite de l'html et du php";

require "include/header.inc.php";

if ($lang == 'fr') {
    require "include/french.inc.php";
} else {
    require "include/english.inc.php";
}
?>

<p><a href="index.php?lang=fr" class="link">Français</a> | <a href="index.php?lang=en" class="link">English</a></p>

<?php
require "include/footer.inc.php";
?>