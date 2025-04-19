<?php

/**
 * *************************************************************************
 * Fonctions Utilitaires Générales
 * *************************************************************************
 */

/**
 * Vérifie si une variable est définie et non vide, sinon affiche un message d'erreur.
 *
 * @param mixed $variable La variable à vérifier.
 * @param string $message Le message d'erreur personnalisé.
 * @return bool Retourne true si la variable est valide, sinon false.
 */
function verifierVariable($variable, string $message): bool {
    if (!isset($variable) || empty($variable)) {
        echo '<p class="incorect_var">$message</p>';
        return false;
    }
    return true;
}

/**
 * Formate une date et heure en format heure:minute.
 */
function formatHeureMinute(string $dateTime): string {
    $dt = DateTime::createFromFormat('Y-m-d\TH:i', $dateTime);
    return $dt ? $dt->format('G\hi') : 'Invalide';
}

/**
 * Convertit des secondes en heures et minutes.
 */
function convertSecondsToHours(float $seconds): string {
    $seconds = (int)$seconds;
    
    $hours = floor($seconds / 3600);
    $minutes = floor(($seconds % 3600) / 60);
    
    return sprintf("%dh%02d", $hours, $minutes);
}

/**
 * *************************************************************************
 * Fonctions de Gestion des Requêtes API
 * *************************************************************************
 */

/**
 * Récupère l'IP du visiteur
 */
function getIp(): string {
    return $_SERVER['REMOTE_ADDR'];
}

/**
 * Récupère le contenu XML d'une URL et le décode en élément XML.
 *
 * @param string $url L'URL de l'API.
 * @return SimpleXMLElement Les données XML décodées, ou null en cas d'erreur.
 */
function fetchXml(string $url): ?SimpleXMLElement {
    libxml_use_internal_errors(true);
    $content = @file_get_contents($url);
    if ($content === false) {
        return null;
    }
	
    if (strpos(ltrim($content), '<') !== 0) {
        return null;
    }
	
    $xml = simplexml_load_string($content);
    if ($xml === false) {
		
        libxml_clear_errors();
        return null;
    }
    return $xml;
}

/**
 * Récupère le contenu JSON d'une URL et le décode en tableau associatif.
 *
 * @param string $url L'URL de l'API.
 * @return array|null Les données JSON décodées, ou null en cas d'erreur.
 */
function fetchJson(string $url): ?array {
    $contenu = file_get_contents($url);
	
    if ($contenu !== false) {
        $data = json_decode($contenu, true);
        return $data ? $data : null;
    }
    return null;
}

/**
 * *************************************************************************
 * Fonctions d'Affichage et de Rendu
 * *************************************************************************
 */

/**
 * Affiche les informations sous forme de liste HTML.
 *
 * @param string $titre Le titre de la liste.
 * @param array $infos Les informations à afficher.
 */
function afficherInfos(string $titre, array $infos): void {
    echo "<h3>$titre</h3><ul>";
    foreach ($infos as $cle => $val) {
        echo "<li>$cle : " . htmlspecialchars($val) . "</li>";
    }
    echo "</ul>";
}

function getImageAleatoire() {
    $dossier = 'illustrations';
    if (!is_dir($dossier)) {
        return null;
    }

    $images = glob($dossier . '/*.{jpg,jpeg,png,gif,webp}', GLOB_BRACE);
    if (empty($images)) {
        return null;
    }

    return htmlspecialchars($images[array_rand($images)]);
}

/**
 * Séparation de la description en plusieurs parties.
 */
function splitDescription(string $description): array {
    $words = explode(' ', $description, 2);
    if (count($words) === 2) {
        return [$words[0], $words[1]];
    }
    return [$description, ''];
}

/**
 * *************************************************************************
 * Fonctions relatives à la Météo (Open-Meteo API)
 * *************************************************************************
 */

/**
 * Retourne une icône en fonction du code météo Open-Meteo.
 *
 * @param int $code Code météo Open-Meteo.
 * @return string URL de l'icône correspondante.
 */
function getWeatherIcon(int $code): string {
    $icons = [
        0 => "☀️",
        1 => "🌤️",
        2 => "⛅",
        3 => "☁️",
        45 => "🌫️",
        48 => "❄️",
        51 => "🌦️",
        53 => "🌦️",
        55 => "🌦️",
        56 => "🌧️",
        57 => "🌧️",
        61 => "🌧️",
        63 => "🌧️",
        65 => "🌧️",
        66 => "🌨️",
        67 => "🌨️",
        71 => "🌨️",
        73 => "🌨️",
        75 => "🌨️",
        77 => "🌨️",
        80 => "🌧️",
        81 => "🌧️",
        82 => "🌧️",
        85 => "🌨️",
        86 => "🌨️",
        95 => "⛈️",
        96 => "⛈️",
        99 => "⛈️"
    ];
    return $icons[$code] ?? " ";
}

/**
 * Retourne une description en fonction du code météo Open-Meteo.
 *
 * @param int $code Code météo Open-Meteo.
 * @return string Description textuelle.
 */
function getWeatherDescription(int $code): string {
    $descriptions = [
        0 => "Ciel dégagé",
        1 => "Légère couverture nuageuse",
        2 => "Partiellement nuageux",
        3 => "Ciel couvert",
        45 => "Brouillard",
        48 => "Brouillard givrant",
        51 => "Bruine légère",
        53 => "Bruine modérée",
        55 => "Bruine dense",
        56 => "Bruine verglaçante légère",
        57 => "Bruine verglaçante dense",
        61 => "Pluie légère",
        63 => "Pluie modérée",
        65 => "Forte pluie",
        66 => "Pluie verglaçante légère",
        67 => "Pluie verglaçante intense",
        71 => "Neige légère",
        73 => "Neige modérée",
        75 => "Forte neige",
        77 => "Grésil",
        80 => "Averses légères",
        81 => "Averses modérées",
        82 => "Violentes averses",
        85 => "Averses de neige légères",
        86 => "Averses de neige abondantes",
        95 => "Orage modéré",
        96 => "Orage avec grêle légère",
        99 => "Orage avec grêle destructrice"
    ];
    return $descriptions[$code] ?? "Conditions inconnues";
}

/**
 * Charge et retourne les données météo Open-Meteo pour une ville donnée.
 * À appeler UNE SEULE FOIS par page, puis passer $meteoData aux autres fonctions.
 *
 * @param float $latitude
 * @param float $longitude
 * @return array|null
 */
function chargerMeteoData(float $latitude, float $longitude): ?array {
    $url = "https://api.open-meteo.com/v1/forecast?"
        . "latitude=$latitude"
        . "&longitude=$longitude"
        . "&hourly=temperature_2m,wind_speed_10m,relative_humidity_2m,weathercode"
        . "&daily=weathercode,temperature_2m_max,temperature_2m_min,temperature_2m_mean,precipitation_sum,wind_speed_10m_max,wind_gusts_10m_max,relative_humidity_2m_mean,sunshine_duration,sunrise,sunset"
        . "&timezone=Europe/Paris";
    return fetchJson($url);
}

/**
 * Récupère les données météo consolidées pour une journée
 */
function getMeteoJournaliere(array $meteoData, string $ville, string $date): array {
    if (!$meteoData || !isset($meteoData['daily'])) {
        throw new RuntimeException("Données journalières indisponibles pour " . htmlspecialchars($ville));
    }
    $dailyIndex = array_search($date, $meteoData['daily']['time']);
    if ($dailyIndex === false) {
        throw new RuntimeException("Données introuvables pour le : " . htmlspecialchars($date));
    }
    return [
        'ville' => $ville,
        'date' => $date,
        'temperatures' => [
            'min' => $meteoData['daily']['temperature_2m_min'][$dailyIndex] . " °C",
            'max' => $meteoData['daily']['temperature_2m_max'][$dailyIndex] . " °C",
            'moyenne' => $meteoData['daily']['temperature_2m_mean'][$dailyIndex] . " °C"
        ],
        'precipitation' => $meteoData['daily']['precipitation_sum'][$dailyIndex] . " mm",
        'vent' => [
            'vitesse_max' => $meteoData['daily']['wind_speed_10m_max'][$dailyIndex] . " km/h",
            'rafales_max' => $meteoData['daily']['wind_gusts_10m_max'][$dailyIndex] . " km/h"
        ],
        'humidite' => $meteoData['daily']['relative_humidity_2m_mean'][$dailyIndex] . " %",
        'ensoleillement' => [
            'lever' => formatHeureMinute($meteoData['daily']['sunrise'][$dailyIndex]),
            'coucher' => formatHeureMinute($meteoData['daily']['sunset'][$dailyIndex]),
            'duree' => convertSecondsToHours($meteoData['daily']['sunshine_duration'][$dailyIndex])
        ],
        'conditions' => [
            'code' => $meteoData['daily']['weathercode'][$dailyIndex],
            'icone' => getWeatherIcon($meteoData['daily']['weathercode'][$dailyIndex]),
            'description' => getWeatherDescription($meteoData['daily']['weathercode'][$dailyIndex])
        ]
    ];
}

/**
 * Récupère les données météo horaires pour un créneau spécifique
 */
function getMeteoHoraire(array $meteoData, string $ville, string $dateHeure): array {
    if (!$meteoData || !isset($meteoData['hourly'])) {
        throw new RuntimeException("Données horaires indisponibles pour " . htmlspecialchars($ville));
    }
    $dateAPI = str_replace(" ", "T", $dateHeure);
    $timeIndex = array_search($dateAPI, $meteoData['hourly']['time']);
    if ($timeIndex === false) {
        throw new RuntimeException("Données introuvables pour : " . htmlspecialchars($dateHeure));
    }
    return [
        'ville' => $ville,
        'date_heure' => $dateHeure,
        'temperature' => $meteoData['hourly']['temperature_2m'][$timeIndex] . " °C",
        'vent' => [
            'vitesse' => $meteoData['hourly']['wind_speed_10m'][$timeIndex] . " km/h"
        ],
        'humidite' => $meteoData['hourly']['relative_humidity_2m'][$timeIndex] . " %",
        'conditions' => [
            'code' => $meteoData['hourly']['weathercode'][$timeIndex],
            'icone' => getWeatherIcon($meteoData['hourly']['weathercode'][$timeIndex]),
            'description' => getWeatherDescription($meteoData['hourly']['weathercode'][$timeIndex])
        ]
    ];
}

/**
 * *************************************************************************
 * Fonctions relatives aux Rendu Météo et Graphiques Visiteurs
 * *************************************************************************
 */


/**
 * Génère le rendu d'un donut (graphique circulaire).
 */
function renderDonut($percent, $mainText, $subText, $colorClass, $fontSize = 7, $textColorClass = null): void {
    $isNegative = $percent < 0;
    $dash = abs($percent);
    $gap = 100 - $dash;
    $transform = $isNegative ? 'scale(-1,1) translate(-40,0)' : '';
    ?>
    <svg width="100%" height="100%" viewBox="0 0 40 40" class="donut">
        <circle class="donut-hole" cx="20" cy="20" r="15.91549430918954" fill="var(--donut-hole)"></circle>
        <circle class="donut-ring" cx="20" cy="20" r="15.91549430918954" fill="transparent" stroke-width="3.5" stroke="var(--donut-ring)"></circle>
        <circle class="donut-segment" cx="20" cy="20" r="15.91549430918954"
            fill="transparent" stroke-width="3"
            stroke="var(--<?= htmlspecialchars($colorClass) ?>)"
            stroke-dasharray="<?= $dash ?> <?= $gap ?>"
            stroke-dashoffset="25"
            transform="<?= $transform ?>"></circle>
        <g class="donut-text">
            <text y="50%">
                <tspan x="50%" text-anchor="middle" class="donut-percent" fill="var(--<?= htmlspecialchars($textColorClass ?? $colorClass) ?>)" style="font-size:<?= htmlspecialchars($fontSize) ?>px"><?= htmlspecialchars($mainText) ?></tspan>
            </text>
            <text y="70%">
                <tspan x="50%" text-anchor="middle" class="donut-data" fill="var(--donut-subtext)"><?= htmlspecialchars($subText) ?></tspan>
            </text>
        </g>
    </svg>
    <?php
}

/**
 * Génération d'un graphique.
 */
function genererGraphique($data, $cheminImage, $theme = 'Mode Sombre', $width = 1200, $height = 600) {
    if (!extension_loaded('gd')) return false;

    // Couleurs
    $image = imagecreatetruecolor($width, $height);
    if ($theme === 'Mode Clair') {
        $fond   = imagecolorallocate($image, 26, 26, 26);
        $barres = imagecolorallocate($image, 92, 219, 149);
        $texte  = imagecolorallocate($image, 255, 255, 255);
        $axes   = imagecolorallocate($image, 200, 200, 200);
    } else {
        $fond   = imagecolorallocate($image, 255, 255, 255);
        $barres = imagecolorallocate($image, 70, 130, 180);
        $texte  = imagecolorallocate($image, 0, 0, 0);
        $axes   = imagecolorallocate($image, 100, 100, 100);
    }
    imagefilledrectangle($image, 0, 0, $width, $height, $fond);

    $marginGauche = 350;
    $marginDroite = 50;
    $marginHaut = 50;
    $marginBas = 50;
    $barHeight = 30;
    $gap = 20;
    $maxValue = max($data);
    $nbVilles = count($data);
    $chartHeight = $nbVilles * ($barHeight + $gap) - $gap;
    $chartTop = $marginHaut + ($height - $marginHaut - $marginBas - $chartHeight) / 2;
    $chartWidth = $width - $marginGauche - $marginDroite;
    $scale = $chartWidth / $maxValue;

    // Axe vertical (ordonnées) : noms des villes
	$font = 4;
	$i = 0;
	foreach ($data as $city => $count) {
		$y = (int)($chartTop + $i * ($barHeight + $gap));
		$cityWidth = imagefontwidth($font) * strlen($city);
		$cityX = $marginGauche - 10 - $cityWidth;
		imagestring($image, $font, $cityX, $y + $barHeight / 2 - 8, $city, $texte);
		$barLen = (int)($count * $scale);
		imagefilledrectangle($image, $marginGauche, $y, $marginGauche + $barLen, $y + $barHeight, $barres);
		imagestring($image, $font, $marginGauche + $barLen + 10, $y + $barHeight / 2 - 8, $count, $texte);
		$i++;
	}

    // Axe horizontal (abscisses) : graduations
    $nbGraduations = 5;
    for ($j = 0; $j <= $nbGraduations; $j++) {
        $val = round($maxValue * ($j / $nbGraduations));
        $x = $marginGauche + (int)($val * $scale);
        imageline($image, $x, $chartTop - 5, $x, $chartTop + $chartHeight, $axes);
        imagestring($image, 3, $x - 10, $chartTop + $chartHeight + 10, $val, $texte);
    }

    // Axe principal horizontal
    imageline($image, $marginGauche, $chartTop + $chartHeight, $marginGauche + $chartWidth, $chartTop + $chartHeight, $axes);

    imagepng($image, $cheminImage);
    imagedestroy($image);
    return true;
}

/**
 * *************************************************************************
 * Fonctions relatives à l'API de la NASA - TECH
 * *************************************************************************
 */

/**
 * Affiche les données du jour (media et description) via l'API de la NASA.
 *
 * @param string $date La date à traiter (2025-03-23 par défaut).
 */
function afficherImageNASA(string $date = '2025-03-23'): void {
    $apiKey = 'DEMO_KEY';
    $data = fetchJson("https://api.nasa.gov/planetary/apod?api_key=$apiKey&date=$date");
    
    if (!$data || !isset($data['url'])) {
        echo "<p>Erreur lors de la récupération de l'image NASA.</p>";
        return;
    }
    
    echo "<h2>" . htmlspecialchars($data['title']) . "</h2>";
    // Affichage conditionnel selon le type de média (image ou vidéo)
    if ($data['media_type'] === 'image') {
		
        echo "<img src='" . htmlspecialchars($data['url']) . "' alt='Image du jour de la NASA' style='max-width:100%; height:auto;'>";
    } 
	elseif ($data['media_type'] === 'video') {
		
        echo "<iframe width='560' height='315' src='" . htmlspecialchars($data['url']) . "' frameborder='0' allowfullscreen></iframe>";
    }
    echo "<p>Description : " . htmlspecialchars($data['explanation']) . "</p>";
}

/**
 * *************************************************************************
 * Fonctions relatives à la Géolocalisation - TECH
 * *************************************************************************
 */

/**
 * Affiche les données de localisation de l'utilisateur via l'API geoPlugin.
 */
function geoLocaliser(): void {
    $ip = getIp();
    $xml = fetchXml("http://www.geoplugin.net/xml.gp?ip=$ip");
    
    if (!$xml) {
        echo "<p>Impossible de récupérer la géolocalisation.</p>";
        return;
    }
    
    // Extraction et affichage des données pertinentes du XML
    afficherInfos("Géolocalisation via GeoPlugin", [
        "IP" => $xml->geoplugin_request,
        "Pays" => $xml->geoplugin_countryName,
        "Région" => $xml->geoplugin_region,
        "Ville" => $xml->geoplugin_city,
        "Latitude" => $xml->geoplugin_latitude,
        "Longitude" => $xml->geoplugin_longitude
    ]);
}

/**
 * Affiche les données de l'IP de l'utilisateur via l'API ipInfo.
 */
function extractionIPInfo(): void {
    $ip = getIp();
    $data = fetchJson("https://ipinfo.io/$ip/geo");
    
    if (!$data || !isset($data['ip'])) {
        echo "<p>Impossible d'obtenir les infos IPInfo.</p>";
        return;
    }
    
    // Extraction et affichage des données géographiques depuis le JSON
    afficherInfos("Localisation via IPInfo", [
        "IP" => $data['ip'],
        "Pays" => $data['country'],
        "Région" => $data['region'],
        "Ville" => $data['city'],
        "Coordonnées" => $data['loc']
    ]);
}

/**
 * Affiche les données de l'IP de l'utilisateur via l'API WhatsMyIP.
 */
function extractionWhatIsMyIP(): void {
    $apiKey = '90b4b51cee24d67abf27dbb17e3b6bb7';
    $ip = getIp();
    // Requête à l'API WhatIsMyIP avec la clé API et l'adresse IP
    $xml = fetchXml("https://api.whatismyip.com/ip-address-lookup.php?key=$apiKey&input=$ip&output=xml");
    
    if (!$xml || !isset($xml->server_data)) {
        echo "<p>Impossible de récupérer les données avec WhatIsMyIP.</p>";
        return;
    }
    
    $data = $xml->server_data;
    // Extraction et affichage des informations détaillées de l'IP
    afficherInfos("Infos IP via WhatIsMyIP", [
        "IP" => $data->ip,
        "Pays" => $data->country,
        "Région" => $data->region,
        "Ville" => $data->city,
        "Fournisseur" => $data->isp,
        "Latitude" => $data->latitude,
        "Longitude" => $data->longitude
    ]);
}

/**
 * *************************************************************************
 * Fonctions de Gestion des Villes, Départements et Régions
 * *************************************************************************
 */

/**
 * Récupère les villes à partir d'un fichier CSV.
 */
function getCitiesFromCSV($filename): ?array {
    if (($handle = fopen($filename, "r")) !== FALSE) {
        $headers = fgetcsv($handle, 1000, ",");
        $cities = [];
        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
            $city = array_combine($headers, $data);
            $cities[] = [
                'id' => $city['id'],
                'name' => $city['name'],
                'department_code' => $city['department_code'],
                'gps_lat' => $city['gps_lat'],
                'gps_lng' => $city['gps_lng']
            ];
        }
        fclose($handle);
        return $cities;
    }
    return [];
}

/**
 * Filtre les villes par code de département.
 */
function filterCitiesByDepartment($cities, $departmentCode): ?array {
    return array_filter($cities, function($city) use ($departmentCode) {
        return $city['department_code'] == $departmentCode;
    });
}

/**
 * Affiche une liste déroulante de villes.
 */
function displayCityDropdown($cities, $selected = ''): void {
    echo '<select name="ville" id="ville-select" required>';
    echo '<option value="">Sélectionnez une ville</option>';
    foreach ($cities as $city) {
        $sel = ($city['id'] == $selected) ? 'selected' : '';
        echo sprintf(
            '<option value="%s" %s>%s</option>',
            htmlspecialchars($city['id']), // On envoie l'ID
            $sel,
            htmlspecialchars($city['name'])
        );
    }
    echo '</select>';
}

/**
 * Récupère les départements à partir d'un fichier CSV.
 */
function getDepartmentsFromCSV($filename): ?array {
    if (($handle = fopen($filename, "r")) !== FALSE) {
        $headers = fgetcsv($handle, 1000, ",");
        $departments = [];
        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
            $department = array_combine($headers, $data);
            $departments[] = [
                'code' => $department['code'],
                'region_code' => $department['region_code'],
                'name' => $department['name']
            ];
        }
        fclose($handle);
        return $departments;
    }
    return [];
}

/**
 * Filtre les départements par code de région.
 */
function filterDepartmentsByRegion($departments, $regionCode): ?array {
    return array_filter($departments, function($department) use ($regionCode) {
        return $department['region_code'] == $regionCode;
    });
}

/**
 * Affiche une liste déroulante de départements.
 */
function displayDepartmentDropdown($departments, $selected = ''): void {
    echo '<select name="departement" id="departement-select">';
    echo '<option value="">Sélectionnez un département</option>';
    foreach ($departments as $department) {
        $sel = ($department['code'] == $selected) ? 'selected' : '';
        echo '<option value="' . $department['code'] . '" data-region="' . $department['region_code'] . '" ' . $sel . '>';
        echo $department['name'];
        echo '</option>';
    }
    echo '</select>';
}

/**
 * Récupère les régions à partir d'un fichier CSV.
 */
function getRegionsFromCSV($filename): ?array {
    if (($handle = fopen($filename, "r")) !== FALSE) {
        $headers = fgetcsv($handle, 1000, ",");
        $regions = [];
        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
            $region = array_combine($headers, $data);
            $regions[] = [
                'code' => $region['code'],
                'name' => $region['name'],
                'slug' => $region['slug']
            ];
        }
        fclose($handle);
        return $regions;
    }
    return [];
}

/**
 * Affiche une liste déroulante de régions.
 */
function displayRegionDropdown($regions, $selected = ''): void {
    echo '<select name="region" id="region-select">';
    echo '<option value="">Sélectionnez une région</option>';
    foreach ($regions as $region) {
        $sel = ($region['code'] == $selected) ? 'selected' : '';
        echo '<option value="' . $region['code'] . '" data-slug="' . $region['slug'] . '" ' . $sel . '>';
        echo $region['name'];
        echo '</option>';
    }
    echo '</select>';
}

/**
 * Récupère une ville par son ID.
 */
function getCityById(array $cities, string $id): ?array {
    foreach ($cities as $city) {
        if ($city['id'] == $id) {
            return $city;
        }
    }
    return null;
}

/**
 * Récupère le code de région à partir du code de département.
 */
function getRegionCodeByDepartment(array $departments, string $departmentCode): string {
    foreach ($departments as $dept) {
        if ($dept['code'] === $departmentCode) {
            return $dept['region_code'];
        }
    }
    return '';
}

/**
 * *************************************************************************
 * Fonctions de Suivi et de Personnalisation
 * *************************************************************************
 */

/**
 * Enregistre les informations de la ville sélectionnée.
 */
function logCity(array $city, array $departments): void {
    $logFile = 'csv/logs.csv';
    
    // Création du fichier avec entêtes si nécessaire
    if (!file_exists($logFile)) {
        $headers = ['date', 'ip', 'id', 'ville', 'departement', 'region', 'latitude', 'longitude'];
        file_put_contents($logFile, implode(',', $headers) . "\n");
    }
    
    // Trouver la région correspondante
    $regionCode = array_reduce($departments, function($carry, $dept) use ($city) {
        return ($dept['code'] == $city['department_code']) ? $dept['region_code'] : $carry;
    }, '');

    // Préparation des données
    $data = [
        date('Y-m-d H:i:s'),
        $_SERVER['REMOTE_ADDR'],
        $city['id'],
        $city['name'],
        $city['department_code'],
        $regionCode,
        $city['gps_lat'],
        $city['gps_lng']
    ];
    
    // Écriture dans le fichier
    file_put_contents($logFile, implode(',', $data) . "\n", FILE_APPEND);
}

/**
 * Récupère la dernière sélection de ville.
 */
function getLastCitySelection() {
    if (!isset($_COOKIE['last_city'])) return [null, null, null];

    $lastCity = json_decode($_COOKIE['last_city'], true);
    if (!$lastCity) return [null, null, null];

    return [
        $lastCity['region'] ?? null,
        $lastCity['department_code'] ?? null,
        $lastCity['id'] ?? null
    ];
}

/**
 * Définit un cookie pour la ville sélectionnée.
 */
function setCityCookie($city, $departments) {
    $cookieData = [
        'id' => $city['id'],
        'date' => date('Y-m-d H:i:s'),
        'name' => $city['name'],
        'department_code' => $city['department_code'],
        'region' => getRegionCodeByDepartment($departments, $city['department_code'])
    ];
    setcookie('last_city', json_encode($cookieData), time() + 30*24*3600, '/', '', true, true);
}


/**
 * Récupère la ville actuelle avec fallback sur la valeur par défaut.
 * 
 * @param array $cities Tableau des villes disponibles
 * @param string $defaultCityId ID de la ville par défaut
 * @return array Données de la ville
 */
function getCurrentCity(array $cities, string $defaultCityId): array {
    [$lastRegion, $lastDepartment, $lastCityId] = getLastCitySelection();
    $villeId = $_GET['ville'] ?? $lastCityId ?? $defaultCityId;
    
    $city = getCityById($cities, $villeId);
    
    if (!$city) {
        $city = getCityById($cities, $lastCityId);
    }
	
	if (!$city) {
        $city = getCityById($cities, $defaultCityId);
    }
    
    return $city;
}


/**
 * *************************************************************************
 * Fonctions de Gestion des Dates et Heures
 * *************************************************************************
 */

/**
 * Traduit une date du format anglais au format français.
 */
function traduireDate(string $dateAnglaise): string {
    // Tableaux de traduction
    $jours = [
        'Monday' => 'Lundi', 
        'Tuesday' => 'Mardi',
        'Wednesday' => 'Mercredi',
        'Thursday' => 'Jeudi',
        'Friday' => 'Vendredi',
        'Saturday' => 'Samedi',
        'Sunday' => 'Dimanche'
    ];
    
    $mois = [
        'January' => 'janvier', 
        'February' => 'février',
        'March' => 'mars',
        'April' => 'avril',
        'May' => 'mai',
        'June' => 'juin',
        'July' => 'juillet',
        'August' => 'août',
        'September' => 'septembre',
        'October' => 'octobre',
        'November' => 'novembre',
        'December' => 'décembre'
    ];

    // Remplace les termes anglais par les termes français
    return str_replace(
        array_merge(array_keys($jours), array_keys($mois)),
        array_merge(array_values($jours), array_values($mois)),
        $dateAnglaise
    );
}

/**
 * Obtient le libellé d'une date à partir d'un objet DateTime.
 */
function getLibelleDate(DateTime $date): string {
    $aujourdhui = new DateTime('today');
    $demain = (new DateTime('tomorrow'))->setTime(0, 0);
    $apresDemain = (new DateTime('tomorrow'))->modify('+1 day')->setTime(0, 0);

    return match(true) {
        $date == $aujourdhui => "Aujourd'hui à",
        $date == $demain => "Demain à",
        $date == $apresDemain => "Après-demain à",
        default => traduireDate($date->format('l')) . " à"
    };
}

/**
 * Valide un intervalle de date.
 */
function validateDateInterval($date) {
	
    if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $date)) {
        return false;
    }

    $dateObj = DateTime::createFromFormat('Y-m-d', $date);
    if (!$dateObj || $dateObj->format('Y-m-d') !== $date) {
        return false;
    }

    $now = new DateTime();
    $interval = $now->diff($dateObj);
    $daysDifference = (int)$interval->format('%r%a');

    return $daysDifference >= 0 && $daysDifference <= 5;
}

/**
 * Génère un tableau des 24 prochaines heures à partir de l'heure actuelle
 * @return array Tableau de chaînes au format 'YYYY-MM-DD HH:00'
 */
function genererHoraires24h(): array {
    $dateActuelle = new DateTime();
    $heures = [];
    for ($i = 0; $i < 24; $i++) {
        $heures[] = $dateActuelle->format('Y-m-d H:00');
        $dateActuelle->modify('+1 hour');
    }
    return $heures;
}

/**
 * Récupère les prévisions pour les 24 prochaines heures.
 */
function recupererPrevisions24h(array $meteoData, string $ville): array {
    $heures = genererHoraires24h();
    $previsions = [];
    foreach ($heures as $heure) {
        try {
            $previsions[] = getMeteoHoraire($meteoData, $ville, $heure);
        } catch (RuntimeException $e) {
            $previsions[] = [
                'date_heure' => $heure,
                'erreur' => $e->getMessage()
            ];
        }
    }
    return $previsions;
}


/**
 * Récupère la date actuelle.
 */
function getCurrentDate() {
    $dateJour = $_GET['date'] ?? date('Y-m-d');
    if (!validateDateInterval($dateJour)) {
        $newParams = $_GET;
        $newParams['date'] = date('Y-m-d');
        header('Location: meteo.php?' . http_build_query($newParams));
        exit;
    }
    return $dateJour;
}

/**
 * *************************************************************************
 * Fonctions de Gestion des Visites et Statistiques
 * *************************************************************************
 */

/**
 * Incrémente le compteur de visites dans un fichier CSV.
 * Crée le fichier si besoin.
 *
 * @param string $csvFilePath
 * @return int Le nouveau compteur
 */
function compteurVisites($csvFilePath) {
    $compteur = 0;

    // Si le fichier existe, lire la valeur actuelle
    if (file_exists($csvFilePath) && is_readable($csvFilePath)) {
        $handle = fopen($csvFilePath, 'r');
        if ($handle !== false) {
            fgetcsv($handle); // Ignore l'en-tête
            $row = fgetcsv($handle);
            if ($row && isset($row[0])) {
                $compteur = (int)$row[0];
            }
            fclose($handle);
        }
    }

    // Incrémente le compteur
    $compteur++;

    // Écrit la nouvelle valeur dans le fichier (avec en-tête)
    $handle = fopen($csvFilePath, 'w');
    if ($handle !== false) {
        fputcsv($handle, ['Nombre de visiteur']);
        fputcsv($handle, [$compteur]);
        fclose($handle);
    }

    return $compteur;
}

/**
 * Récupère le top 10 des villes avec le comptage des visites.
 */
function getTop10Villes($csvFilePath) {
    $cityCounts = [];

    if (!file_exists($csvFilePath) || !is_readable($csvFilePath)) {
        return [];
    }

    if (($handle = fopen($csvFilePath, 'r')) !== false) {
        $header = fgetcsv($handle);
        $cityIndex = array_search('ville', array_map('strtolower', $header));

        if ($cityIndex === false) {
            fclose($handle);
            return [];
        }

        while (($data = fgetcsv($handle)) !== false) {
            $city = trim($data[$cityIndex]);
            if ($city !== '') {
                $cityCounts[$city] = ($cityCounts[$city] ?? 0) + 1;
            }
        }
        fclose($handle);
    }

    arsort($cityCounts);
    return array_slice($cityCounts, 0, 10, true);
}