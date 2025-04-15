<?php

if (isset($_GET['style']) && !empty($_GET['style']) && $_GET['style'] === 'alternatif') {
    $stylesheet = "css/style-dark.css";
    $modeText = "Mode Clair";
    $toggleLink = $_SERVER['PHP_SELF'] . '?style=standard';
} else {
    $stylesheet = "css/style-bright.css";
    $modeText = "Mode Sombre";
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
    <link rel="icon" type="image/x-icon" href="images/favicon.ico" />
  </head>
  <body>
    <header>
      <div class="header-content" style="display: flex; align-items: center;">
        <figure>
          <div>
            <a href="index.php"><img src="./logo/logo5.png" alt="Logo"/></a>
          </div>
        </figure>
        <nav style="font-size: 1.2em; font-weight: bold; margin-left: 20px;">
          <ul style="list-style-type: none; display: flex; gap: 40px;">
            <li><a href="meteo.php">Page Météo</a></li>
			<li><a href="stats.php">Statistiques</a></li>
			<li><a href="propos.php">A propos</a></li>
          </ul>
        </nav>
        <div class="toggle-mode">
          <a href="<?= $toggleLink; ?>"><?= $modeText; ?></a>
        </div>
      </div>
    </header>
