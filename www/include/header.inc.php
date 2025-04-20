<?php
// Nom du cookie
$cookieName = 'theme';
// Valeurs valides
$themesValides = ['standard', 'alternatif'];

// Gestion du changement de thème via le lien
if (isset($_GET['style']) && in_array($_GET['style'], $themesValides)) {
    // On place le cookie pour 1 an
    setcookie($cookieName, $_GET['style'], time() + 30*24*3600, "/");
    $theme = $_GET['style'];
    // Rafraîchir la page pour que le cookie soit pris en compte dans $_COOKIE
    header('Location: ' . strtok($_SERVER['REQUEST_URI'], '?'));
    exit;
}

// Lecture du cookie si présent
if (isset($_COOKIE[$cookieName])) {
    if (in_array($_COOKIE[$cookieName], $themesValides)) {
        $theme = $_COOKIE[$cookieName];
    } else {
        // Valeur erronée : suppression du cookie
        setcookie($cookieName, '', time() - 3600, "/");
        $theme = 'standard';
    }
} else {
    $theme = 'standard';
}

if ($theme === 'alternatif') {
    $stylesheet = "css/style-dark.css";
    $modeIcon = '<img src="./images/sun.svg" alt="Mode Clair" style="height:50px; width:50px;"/>';
    $toggleLink = $_SERVER['PHP_SELF'] . '?style=standard';
} else {
    $stylesheet = "css/style-bright.css";
    $modeIcon = '<img src="./images/moon.svg" alt="Mode Sombre" style="height:50px; width:50px;"/>';
    $toggleLink = $_SERVER['PHP_SELF'] . '?style=alternatif';
}
?>

<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title><?= isset($title) ? $title : "costa-matheo" ?></title>
    <meta name="description" content="<?= isset($description) ? $description : "Voici mon site personnel qui contient les exercices de dev web" ?>"/>
    <link rel="stylesheet" href="<?= $stylesheet; ?>"/>
    <link rel="icon" type="image/x-icon" href="logo/favicon.ico" />
  </head>
  <body>
	<header>
		<figure style="margin: 0;">
			<a href="index.php"><img src="./logo/logo5.png" alt="Logo de Meteo CoZi" style="height: 55px;"/></a>
		</figure>
		<nav>
			<ul>
				<li><a href="meteo.php">Page Météo</a></li>
				<li><a href="stats.php">Statistiques</a></li>
				<li><a href="tech.php">Tech</a></li>
				<li><a href="propos.php">À propos</a></li>
			</ul>
			<a href="<?= $toggleLink; ?>" class="mode-toggle" style="display: inline-block;">
				<?= $modeIcon; ?>
			</a>
		</nav>
	</header>