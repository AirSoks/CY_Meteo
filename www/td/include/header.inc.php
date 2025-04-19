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
    <style>
      /* Style pour le tableau */
      table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
      }
      table caption {
        font-weight: bold;
        margin-bottom: 10px;
      }
      th, td {
        border: 1px solid #ddd;
        padding: 8px;
        text-align: center;
      }
      th {
        background-color: #f4f4f4;
      }
      /* Couleurs des caractères */
      .chiffre {
        color: red;
        font-weight: bold;
      }
      .majuscule {
        color: green;
        font-weight: bold;
      }
      .minuscule {
        color: blue;
        font-weight: bold;
      }
      .center-image {
        display: block;
        margin-left: auto;
        margin-right: auto;
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
