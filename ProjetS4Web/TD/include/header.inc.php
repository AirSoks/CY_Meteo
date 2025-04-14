<!DOCTYPE html>
	<html lang = "fr">
	<?php
	require "./include/functions.inc.php";
?>
<head>
	<meta charset = "utf-8" />
	<title> TD Benjamin ZIVIC </title>
	<link rel="stylesheet" href="./oui.css"/>
	<link rel = "icon" href = "./illustrations/favicon.jpg" type = "image/jpg"/>
</head>
<body>
<header>
			<h1 class = "centrer"> Développement WEB CY Cergy Paris Université</h1>
			<p> Sous la direction de Marc LEMAIRE</p>
			<a href="index.php?style=oui">Style nuit</a> | 
			<a href="index.php?style=jour">Style jour</a>
			<a href="index.php?lang=french">🇫🇷 Français</a> | 
			<a href="index.php?lang=english">🇬🇧 English</a>
			<a href="index.php?style=oui&lang=french">Mode nuit en français</a> |
			<a href="index.php?style=jour&lang=english">Mode jour en anglais</a>
			<link rel="stylesheet" href="<?php echo $style; ?>.css?v=<?php echo time(); ?>">
			<nav class = "navbar">
				<ul>
					<li><a href = "./index.php"> Accueil </a></li>
					<li><a href = "./td5.php"> TD5 </a></li>
					<li><a href = "./td6.php"> TD6 </a></li>
					<li><a href = "./td7.php"> TD7 </a></li>
					<li><a href = "./td8.php"> TD8 </a></li>
					<li><a href = "./td9.php"> TD9 </a></li>
				</ul>
			</nav>
</header>