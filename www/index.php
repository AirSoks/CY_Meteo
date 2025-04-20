<?php
	$title = "Accueil";
	$description = "Bienvenue sur la Meteo COZI";

	require './include/header.inc.php';
	require './include/function.inc.php';

	// Chargement des données en premier
	$cities = getCitiesFromCSV('csv/cities.csv');
	$departments = getDepartmentsFromCSV('csv/departments.csv');
	$regions = getRegionsFromCSV('csv/regions.csv');

	// Récupération de la dernière sélection
	[$lastRegion, $lastDepartment, $lastCityId] = getLastCitySelection();

	// Gestion des paramètres avec priorité au GET
	$regionCode = $_GET['region'] ?? $lastRegion ?? '11';
	$departmentCode = $_GET['departement'] ?? $lastDepartment ?? '95';
	$cityId = $_GET['ville'] ?? $lastCityId ?? '35459';

	// Filtrage dynamique
	$filteredDepartments = filterDepartmentsByRegion($departments, $regionCode);
	$filteredCities = filterCitiesByDepartment($cities, $departmentCode);
	
	$currentDate = date('Y-m-d');
?>

<main>
<?php 
	$imageBg = getImageAleatoire(); 
?>
	<div class="hero-section" style="background-image: url('<?php echo $imageBg; ?>'); background-size: cover; background-position: center; background-repeat: no-repeat;">
		<h1>Météo CoZi</h1>
		<a href="#search-form" class="button">Connaître la météo</a>
	</div>
	
	<div id="tooltip" style="position: absolute; background: var(--bg-color); color: var(--text-color); border: 1px solid var(--border-color); padding: 5px; display: none; font-size: 14px;"></div>
	
	<div class="main-section">
		<?php require './include/carte-interactive.php';?>
		
		<form method="GET" action="meteo.php" id="search-form">
			
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
document.addEventListener("DOMContentLoaded", function () {
    const tooltip = document.getElementById("tooltip");

    // === Gestion du survol de la carte === \\
	
    // Quand la souris survole un élément de la carte
    document.addEventListener("mouseover", function (e) {
        if (e.target.matches("path[data-nom]")) {
            tooltip.textContent = e.target.getAttribute("data-nom"); // Affiche le nom dans le tooltip
            tooltip.style.display = "block";
        }
    });

    // Met à jour la position du tooltip en fonction de la souris
    document.addEventListener("mousemove", function (e) {
        if (tooltip.style.display === "block") {
            tooltip.style.left = (e.pageX + 10) + "px";
            tooltip.style.top = (e.pageY + 10) + "px";
        }
    });

    // Cache le tooltip quand la souris quitte la carte
    document.addEventListener("mouseout", function (e) {
        if (e.target.matches("path[data-nom]")) {
            tooltip.style.display = "none";
        }
    });

    // === Gestion des changements dans les listes déroulantes === \\
	
    const regionSelect = document.getElementById('region-select');
    const departementSelect = document.getElementById('departement-select');
    const villeSelect = document.getElementById('ville-select');

    document.getElementById('region-select').addEventListener('change', function() {
        document.getElementById('departement-select').value = ''; // Réinitialise le département
        document.getElementById('ville-select').value = ''; // Réinitialise la ville
        this.form.action = '#search-form';
        this.form.submit();
    });

    // Quand l'utilisateur sélectionne un département
    document.getElementById('departement-select').addEventListener('change', function() {
        document.getElementById('ville-select').value = ''; // Réinitialise la ville
        this.form.action = '#search-form';
        this.form.submit();
    });

    // Quand l'utilisateur sélectionne une ville
    document.getElementById('ville-select').addEventListener('change', function() {
        this.form.action = '#search-form';
        this.form.submit();
    });
	
    // Quand l'utilisateur envoie le formulaire
	document.getElementById('search-form').addEventListener('submit', (e) => {
        e.preventDefault();
        const ville = villeSelect.value;
        const date = '<?= date('Y-m-d') ?>';
        window.location.href = `meteo.php?ville=${ville}&amp;date=${date}`;
    });

    // === Gestion du clic sur un département de la carte === \\
	
    document.querySelectorAll('.departement').forEach(el => {
        el.addEventListener('click', function (e) {
			
            const regionCode = e.target.closest('.region')?.getAttribute('data-code_insee');
            const departementCode = e.target.getAttribute('data-numerodepartement');

            // Met à jour les paramètres de l'URL
            const params = new URLSearchParams(window.location.search);
            params.set('region', regionCode);
            params.set('departement', departementCode);
            params.delete('ville'); // Supprime la ville sélectionnée (le cas échéant)

            // Recharge la page avec les nouveaux paramètres
            window.location.href = `${window.location.pathname}?${params.toString()}#search-form`;
        });
    });
});
</script>

<?php 
	require './include/footer.inc.php'; 
?>