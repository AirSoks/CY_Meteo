<?php
require "include/header.inc.php";
require "include/function.inc.php";

$cities = getCitiesFromCSV('csv/cities.csv');
$departments = getDepartmentsFromCSV('csv/departments.csv');

$defaultCityId = '35459';
[$lastRegion, $lastDepartment, $lastCityId] = getLastCitySelection();
$villeId = $_GET['ville'] ?? $lastCityId ?? $defaultCityId;

if (!$villeId || !($city = getCityById($cities, $villeId))) {
    die("Paramètre ville invalide : $villeId");
}

logCity($city, $departments);

$cookieData = [
    'id' => $villeId,
    'date' => date('Y-m-d H:i:s'),
    'name' => $city['name'],
    'department_code' => $city['department_code'],
    'region' => getRegionCodeByDepartment($departments, $city['department_code'])
];
setcookie('last_city', json_encode($cookieData), time() + 30*24*3600, '/', '', true, true);

$dateJour = $_GET['date'] ?? date('Y-m-d');

if (!validateDateInterval($dateJour)) {
	
    $newParams = $_GET;
    $newParams['date'] = date('Y-m-d');
    
    header('Location: meteo.php?' . http_build_query($newParams));
    exit;
}

$dateJourHeure = $dateJour . ' ' . date('H:00');
?>
<div class="meteo-container">
<?php	
try {
	
    $dataJournalier = getMeteoJournaliere(
        $city['name'], 
        (float)$city['gps_lat'], 
        (float)$city['gps_lng'], 
        $dateJour 
    );
    
    $dataHoraire = getMeteoHoraire(
        $city['name'], 
        (float)$city['gps_lat'], 
        (float)$city['gps_lng'], 
        $dateJourHeure 
    );
	
	// echo '<h2>Données Journalières</h2>';
    // print_r($dataJournalier);
    // echo '<hr>';
    
    // echo '<h2>Données Horaire</h2>';
    // print_r($dataHoraire);
    // echo '<hr>';


    afficherHeaderMeteo($dataJournalier);
    afficherCarteMeteo($dataJournalier);
	
	require "include/meteo-donuts.inc.php";

} catch (RuntimeException $e) {
    die("Erreur de récupération des données météo : " . htmlspecialchars($e->getMessage()));
}
?>
</div>
<?php

require './include/footer.inc.php';

?>