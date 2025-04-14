<?php
require "include/header.inc.php";
require "include/function.inc.php";

$villeId = $_GET['ville'] ?? null;
$dateActuelle = date('Y-m-d H:00');

if (!$villeId) die("Paramètre ville manquant");

$cities = getCitiesFromCSV('csv/cities.csv');
$departments = getDepartmentsFromCSV('csv/departments.csv'); // Chargement des départements
$city = getCityById($cities, $villeId);

if (!$city) die("Ville introuvable");

logCity($city, $departments);

setcookie('last_city', json_encode([
    'id' => $villeId,
    'date' => date('Y-m-d H:i:s'),
    'name' => $city['name'],
    'department_code' => $city['department_code'],
    'region' => array_reduce($departments, function($carry, $dept) use ($city) {
        return ($dept['code'] == $city['department_code']) ? $dept['region_code'] : $carry;
    }, '')
]), time() + 30*24*3600, '/');

afficherMeteo($city['name'], (float)$city['gps_lat'], (float)$city['gps_lng'], $dateActuelle);

?>
