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
    <style type="text/css">
		.carte {
			width: 40%;
			margin: 0 auto;
		}
		path {
			stroke: #000000;
			stroke-width: 1px;
			stroke-linecap: round;
			stroke-linejoin: round;
			stroke-opacity: .25;
			fill: #525252;
		}
		g:hover path {
			fill: #909090;
		}
		g path:hover {
			fill: #B2B0B0;
		}

		footer {
			text-align: center;
			font-size: 12px;
		}
	</style>
  </head>
  <body>
    <header>
      <div class="header-content" style="display: flex; align-items: center;">
        <figure>
          <div class="image-zoom">
            <a href="index.php"><img src="images/logo.png" alt="Logo"/></a>
          </div>
        </figure>
        <nav style="font-size: 1.2em; font-weight: bold; margin-left: 20px;">
          <ul style="list-style-type: none; display: flex; gap: 40px;">
            <li><a href="td5.php">TD5</a></li>
            <li><a href="td6.php">TD6</a></li>
            <li><a href="td7.php">TD7</a></li>
            <li><a href="td8.php">TD8</a></li>
            <li><a href="td9.php">TD9</a></li>
            <li><a href="td10.php">TD10</a></li>
          </ul>
        </nav>
        <div class="toggle-mode">
          <a href="<?= $toggleLink; ?>"><?= $modeText; ?></a>
        </div>
      </div>
    </header>
