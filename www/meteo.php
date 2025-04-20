<?php
	$title = "Météo";
	$description = "La météo de votre ville à tout moment";

	require "include/header.inc.php";
	require "include/function.inc.php";

	$cities = getCitiesFromCSV('csv/cities.csv');
	$departments = getDepartmentsFromCSV('csv/departments.csv');
	$defaultCityId = '35459';

	$city = getCurrentCity($cities, $defaultCityId);

	logCity($city, $departments);
	setCityCookie($city, $departments);

	$dateJour = getCurrentDate();
	$meteoData = chargerMeteoData((float)$city['gps_lat'], (float)$city['gps_lng']);

	try {
		$dataJournalier = getMeteoJournaliere($meteoData, $city['name'], $dateJour);
		$dataHoraire = recupererPrevisions24h($meteoData, $city['name']);
	} catch (RuntimeException $e) {
		die("Erreur de récupération des données météo : " . htmlspecialchars($e->getMessage()));
	}

	$ville = $dataJournalier['ville'];
	$date = new DateTime($dataJournalier['date']);
	$baseUrl = preg_replace('/([?&]date=[^&]*)/', '', $_SERVER['REQUEST_URI']);
	$separator = (strpos($baseUrl, '?') === false) ? '?' : '&';

	$datePrecedent = (clone $date)->modify('-1 day');
	$dateSuivant = (clone $date)->modify('+1 day');
	$urlPrecedent = $baseUrl . $separator . 'date=' . $datePrecedent->format('Y-m-d');
	$urlSuivant = $baseUrl . $separator . 'date=' . $dateSuivant->format('Y-m-d');

	$description = $dataJournalier['conditions']['description'];
	$descWords = explode(' ', $description, 2);
	$line1 = $descWords[0];
	$line2 = $descWords[1] ?? '';

?>
<main>
  <h1>Prévisions Météo</h1>
  <div class="meteo-container">
    <section>
      <h2>Prévisions journalières</h2>
      <svg width="100%" height="180" viewBox="0 0 650 180" xmlns="http://www.w3.org/2000/svg">
        <rect x="0" y="0" width="100%" height="100%" rx="15" ry="15" fill="var(--meteo-card-bg)"/>
        <g font-family="Arial, sans-serif" fill="var(--meteo-text)" text-anchor="middle">
          <text x="50%" y="45" font-size="18" fill="var(--meteo-sun)">
            <?= getLibelleDate($date) ?>
          </text>
          <text x="50%" y="90" font-size="24" font-weight="bold">
            <?= htmlspecialchars($ville) ?>
          </text>
          <text x="50%" y="140" font-size="16" font-weight="bold" fill="var(--meteo-sun)">
            <?= traduireDate($date->format('l d F Y')) ?>
          </text>
          <a href="<?= $urlPrecedent ?>" class="nav-link">
            <rect x="20" y="60" width="40" height="40" rx="8" fill="var(--meteo-nav-bg)"/>
            <text x="40" y="85" font-size="24" fill="var(--meteo-sun)">←</text>
          </a>
          <text x="38" y="120" font-size="14" fill="var(--meteo-text)" text-anchor="middle" font-style="italic">
            <?= traduireDate($datePrecedent->format('d F')) ?>
          </text>
          <a href="<?= $urlSuivant ?>" class="nav-link">
            <rect x="590" y="60" width="40" height="40" rx="8" fill="var(--meteo-nav-bg)"/>
            <text x="610" y="85" font-size="24" fill="var(--meteo-sun)">→</text>
          </a>
          <text x="608" y="120" font-size="14" fill="var(--meteo-text)" text-anchor="middle" font-style="italic">
            <?= traduireDate($dateSuivant->format('d F')) ?>
          </text>
        </g>
      </svg>

      <svg width="100%" height="100" viewBox="0 0 400 100" xmlns="http://www.w3.org/2000/svg">
        <rect x="0" y="0" width="100%" height="100%" rx="15" ry="15" fill="var(--meteo-card-bg)"/>
        <g font-family="Arial, sans-serif" text-anchor="middle" fill="var(--meteo-text)">
          <text x="55" y="40" font-size="16" fill="var(--meteo-sun)" dominant-baseline="middle">
            <?= $dataJournalier['ensoleillement']['lever'] ?> 🌅
          </text>
          <text x="52.5" y="65" font-size="14" dominant-baseline="middle">
            Levé du soleil
          </text>
          <text x="200" y="30" font-size="30" dominant-baseline="middle">
            <?= $dataJournalier['conditions']['icone'] ?>
          </text>
          <text x="200" y="60" font-size="17" dominant-baseline="middle">
            <tspan x="200" dy="0"><?= htmlspecialchars($line1) ?></tspan>
            <?php if ($line2 !== ''): ?>
              <tspan x="200" dy="18"><?= htmlspecialchars($line2) ?></tspan>
            <?php endif; ?>
          </text>
          <text x="375" y="40" font-size="16" fill="var(--meteo-sun)" dominant-baseline="middle" text-anchor="end">
            🌇 <?= $dataJournalier['ensoleillement']['coucher'] ?>
          </text>
          <text x="390" y="65" font-size="14" dominant-baseline="middle" text-anchor="end">
            Couché du soleil
          </text>
        </g>
      </svg>

      <?php require "include/meteo-donuts.inc.php"; ?>
    </section>

	<section id="previsions-horaires">
	  <h2>Prévisions horaires</h2>
	  <table>
	   <tr>
		<th>Heure</th>
		<th>Température</th>
		<th>Vent</th>
		<th>Humidité</th>
		<th>Conditions</th>
	   </tr>
	   <?php foreach ($dataHoraire as $p): ?>
		<tr>
		 <td><?php echo htmlspecialchars($p['date_heure']); ?></td>
		 <?php if (isset($p['erreur'])): ?>
		  <td colspan="5" style="color:red;"><?php echo htmlspecialchars($p['erreur']); ?></td>
		 <?php else: ?>
		  <td><?php echo htmlspecialchars($p['temperature']); ?></td>
		  <td><?php echo htmlspecialchars($p['vent']['vitesse']); ?></td>
		  <td><?php echo htmlspecialchars($p['humidite']); ?></td>
		  <td><?php echo htmlspecialchars($p['conditions']['icone']) . htmlspecialchars($p['conditions']['description']); ?></td>
		 <?php endif; ?>
		</tr>
	   <?php endforeach; ?>
	  </table>
	</section>
  </div>
</main>

<?php require './include/footer.inc.php'; ?>