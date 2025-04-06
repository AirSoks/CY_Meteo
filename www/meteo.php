<?php
require "include/header.inc.php";
require "include/function.inc.php";

// Récupération de l'ID
$villeId = $_GET['ville'] ?? null;
$dateActuelle = date('Y-m-d H:00');

// Validation
if (!$villeId) die("Paramètre ville manquant");

// Récupération des données ville
$cities = getCitiesFromCSV('csv/cities.csv');
$city = getCityById($cities, $villeId);

if (!$city) die("Ville introuvable");

// Journalisation
logCityUsage($city);

// Cookie utilisateur
setcookie('last_city', json_encode([ 
	'id' => $villeId, 
	'date' => date('Y-m-d H:i:s'), 
	'name' => $city['name']]), time() + 30*24*3600, '/');

// Appel de l'API météo
afficherMeteo($city['name'], (float)$city['gps_lat'], (float)$city['gps_lng'], $dateActuelle);

?>