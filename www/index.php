<?php

$title = "Accueil";
$description = "Bienvenue sur mon Meteo COZI";

require './include/header.inc.php';
require './include/function.inc.php';

// Récupération des paramètres GET
$regionCode = $_GET['region'] ?? '84';
$departmentCode = $_GET['departement'] ?? '95';
$cityId = $_GET['ville'] ?? '';

// Chargement des données
$cities = getCitiesFromCSV('csv/cities.csv');
$departments = getDepartmentsFromCSV('csv/departments.csv');
$regions = getRegionsFromCSV('csv/regions.csv');

// Filtrage dynamique
$filteredDepartments = filterDepartmentsByRegion($departments, $regionCode);
$filteredCities = filterCitiesByDepartment($cities, $departmentCode);

?>

<main>
<h1>Météo CoZi</h1>
<button>Choisir votre ville</button>

<div class="main-section">
    <?php require './include/carte-interactive.php';?>
	
	<?php displayLastCity(); ?>
	
    <form method="GET" action="meteo.php" class="search-form">
        <label for="region-select">Région</label>
        <?php displayRegionDropdown($regions, $regionCode) ?>
        
        <label for="departement-select">Département</label>
        <?php displayDepartmentDropdown($filteredDepartments, $departmentCode) ?>
        
        <label for="ville-select">Ville</label>
        <?php displayCityDropdown($filteredCities, $cityId) ?>
        
        <button type="submit">Voir la météo</button>
    </form>

</div>
</main>

<script>
document.getElementById('region-select').addEventListener('change', function() {
    document.getElementById('departement-select').value = '';
    document.getElementById('ville-select').value = '';
    this.form.action = '';
    this.form.submit();
});

document.getElementById('departement-select').addEventListener('change', function() {
    document.getElementById('ville-select').value = '';
    this.form.action = '';
    this.form.submit();
});
</script>