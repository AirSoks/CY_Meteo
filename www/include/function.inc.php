<?php

// Récupère l'IP du visiteur
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
    $xml = simplexml_load_file($url);
	
    return $xml ? $xml : null;
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
    $apiKey = 'c88014eb661f863183f520317e180bf3';
    $ip = getIp();
    // Requête à l'API WhatIsMyIP avec la clé API et l'adresse IP
    $xml = fetchXml("https://api.whatismyip.com/ip-address-lookup.php?key=$apiKey&input=$ip&output=xml");
    
    if (!$xml || !isset($xml->server_data)) {
        echo "<p>Erreur avec WhatIsMyIP.</p>";
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
 * Récupère les données météo via l'API Open-Meteo.
 *
 * @param float $latitude La latitude de la ville.
 * @param float $longitude La longitude de la ville.
 * @return array|null Les données météo, ou null en cas d'erreur.
 */
function getMeteoData(float $latitude, float $longitude): ?array {
    $url = "https://api.open-meteo.com/v1/forecast?"
        . "latitude=$latitude"
        . "&longitude=$longitude"
        . "&hourly=temperature_2m,apparent_temperature,wind_speed_10m,relative_humidity_2m,weathercode"
        . "&daily=weathercode,temperature_2m_max,temperature_2m_min,temperature_2m_mean,precipitation_sum,wind_speed_10m_max,wind_gusts_10m_max,relative_humidity_2m_mean,sunshine_duration,sunrise,sunset"
        . "&timezone=Europe/Paris";
    
    return fetchJson($url);
}

function formatHeureMinute(string $dateTime): string {
    $dt = DateTime::createFromFormat('Y-m-d\TH:i', $dateTime);
    return $dt ? $dt->format('G\hi') : 'Invalide';
}

function convertSecondsToHours(float $seconds): string {
    $seconds = (int)$seconds;
    
    $hours = floor($seconds / 3600);
    $minutes = floor(($seconds % 3600) / 60);
    
    return sprintf("%dh%02d", $hours, $minutes);
}

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
 * Récupère les données météo horaires pour un créneau spécifique
 * 
 * @param string $ville Nom de la ville
 * @param float $latitude Latitude géographique
 * @param float $longitude Longitude géographique
 * @param string $dateHeure Format 'YYYY-MM-DD HH:MM'
 * @return array Données horaires
 */
function getMeteoHoraire(string $ville, float $latitude, float $longitude, string $dateHeure): array 
{
    $meteoData = getMeteoData($latitude, $longitude);
    
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
        'temperature_ressentie' => $meteoData['hourly']['apparent_temperature'][$timeIndex] . " °C",
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
 * Récupère les données météo consolidées pour une journée
 * 
 * @param string $ville Nom de la ville
 * @param float $latitude Latitude géographique
 * @param float $longitude Longitude géographique
 * @param string $date Format 'YYYY-MM-DD'
 * @return array Données journalières
 */
function getMeteoJournaliere(string $ville, float $latitude, float $longitude, string $date): array 
{
    $meteoData = getMeteoData($latitude, $longitude);
    
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

function filterCitiesByDepartment($cities, $departmentCode): ?array {
    return array_filter($cities, function($city) use ($departmentCode) {
        return $city['department_code'] == $departmentCode;
    });
}

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

function filterDepartmentsByRegion($departments, $regionCode): ?array {
    return array_filter($departments, function($department) use ($regionCode) {
        return $department['region_code'] == $regionCode;
    });
}

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

function getCityById(array $cities, string $id): ?array {
    foreach ($cities as $city) {
        if ($city['id'] == $id) {
            return $city;
        }
    }
    return null;
}

function logCity(array $city, array $departments): void {
    $logFile = 'csv/logs.csv';
    
    // Création du fichier avec entêtes si nécessaire
    if (!file_exists($logFile)) {
        $headers = ['date', 'ip', 'id', 'nom', 'departement', 'region', 'latitude', 'longitude'];
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

function afficherImageAleatoire() {
    $dossier = 'illustrations';
    if (!is_dir($dossier)) {
        echo "Le dossier 'illustrations' n'existe pas.";
        return;
    }

    $images = glob($dossier . '/*.{jpg,jpeg,png,gif,webp}', GLOB_BRACE);
    if (empty($images)) {
        echo "Aucune image trouvée dans le dossier 'illustrations'.";
        return;
    }

    $imageAleatoire = $images[array_rand($images)];
    echo '<img src="' . htmlspecialchars($imageAleatoire) . '" alt="Image aléatoire">';
}

function getRegionCodeByDepartment(array $departments, string $departmentCode): string {
    foreach ($departments as $dept) {
        if ($dept['code'] === $departmentCode) {
            return $dept['region_code'];
        }
    }
    return '';
}

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
 * Affiche 3 donuts pour la température, l'humidité et le vent
 * 
 * @param array $meteoData Tableau des données météo (sortie de getMeteoDataArray)
 */
function afficherDonutsMeteo(array $meteoData): void {
    // Extraction des valeurs numériques
    $temperatureMoy = (float)str_replace(' °C', '', $meteoData['temperatures']['moyenne']);
    $humiditeMoy = (float)str_replace(' %', '', $meteoData['humidite']);
    $ventMax = (float)str_replace(' km/h', '', $meteoData['vent']['vitesse_max']);
    
    // Détermination de la classe de température
    $tempClass = match(true) {
        $temperatureMoy < 0 => 'donut-cold',
        $temperatureMoy < 10 => 'donut-cool',
        $temperatureMoy < 20 => 'donut-mild',
        $temperatureMoy < 30 => 'donut-warm',
        default => 'donut-hot'
    };

    // Configuration des styles via classes CSS
    $styles = [
        'temperature' => [
            'colorClass' => $tempClass,
            'fontSize' => 8.5
        ],
        'humidite' => [
            'colorClass' => 'donut-humidity',
            'fontSize' => 10
        ],
        'vent' => [
            'colorClass' => 'donut-wind',
            'fontSize' => 6.5
        ]
    ];
    ?>
    <div class="donut-row">
        <div class="svg-item">
            <?php renderDonut(
                $humiditeMoy, 
                $meteoData['humidite'], 
                'Humidité', 
                $styles['humidite']['colorClass'],
                $styles['humidite']['fontSize']
            ); ?>
        </div>
        <div class="svg-item">
            <?php renderDonut(
                $temperatureMoy, 
                $meteoData['temperatures']['moyenne'], 
                'Température', 
                $styles['temperature']['colorClass'],
                $styles['temperature']['fontSize']
            ); ?>
        </div>
        <div class="svg-item">
            <?php renderDonut(
                $ventMax, 
                $meteoData['vent']['vitesse_max'], 
                'Vitesse du vent',
                $styles['vent']['colorClass'],
                $styles['vent']['fontSize']
            ); ?>
        </div>
    </div>
    <?php
}

function splitDescription(string $description): array {
    $words = explode(' ', $description, 2);
    if (count($words) === 2) {
        return [$words[0], $words[1]];
    }
    return [$description, ''];
}

function afficherCarteMeteo(array $meteoData): void {
    [$line1, $line2] = splitDescription($meteoData['conditions']['description']);
    ?>
    <svg width="100%" height="100" viewBox="0 0 400 100" xmlns="http://www.w3.org/2000/svg">
        <rect x="0" y="0" width="100%" height="100%" rx="15" ry="15" fill="var(--meteo-card-bg)"/>

        <g font-family="Arial, sans-serif" text-anchor="middle" fill="var(--meteo-text)">
		
            <text x="55" y="40" font-size="16" fill="var(--meteo-sun)" dominant-baseline="middle">
                <?= $meteoData['ensoleillement']['lever'] ?> 🌅
            </text>
            <text x="52.5" y="65" font-size="14" dominant-baseline="middle">
                Levé du soleil
            </text>
			
            <text x="200" y="30" font-size="30" dominant-baseline="middle">
                <?= $meteoData['conditions']['icone'] ?>
            </text>
            <text x="200" y="60" font-size="17" dominant-baseline="middle">
                <tspan x="200" dy="0"><?= htmlspecialchars($line1) ?></tspan>
                <?php if ($line2 !== ''): ?>
                    <tspan x="200" dy="18"><?= htmlspecialchars($line2) ?></tspan>
                <?php endif; ?>
            </text>
			
			<text x="375" y="40" font-size="16" fill="var(--meteo-sun)" dominant-baseline="middle" text-anchor="end">
                🌇 <?= $meteoData['ensoleillement']['coucher'] ?>
            </text>
            <text x="390" y="65" font-size="14"  dominant-baseline="middle" text-anchor="end">
                Couché du soleil
            </text>
			
        </g>
    </svg>
    <?php
}

function afficherHeaderMeteo(array $data): void {
    $ville = $data['ville'];
    $date = new DateTime($data['date']);
    $baseUrl = $_SERVER['REQUEST_URI'];
    $baseUrl = preg_replace('/([?&]date=[^&]*)/', '', $baseUrl);
    $separator = (strpos($baseUrl, '?') === false) ? '?' : '&';

    $datePrecedent = (clone $date)->modify('-1 day');
    $dateSuivant = (clone $date)->modify('+1 day');

	$libellePrecedent = traduireDate($datePrecedent->format('d F'));
	$libelleSuivant = traduireDate($dateSuivant->format('d F'));
    ?>
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
            
            <a href="<?= $baseUrl . $separator ?>date=<?= $datePrecedent->format('Y-m-d') ?>" class="nav-link">
                <rect x="20" y="60" width="40" height="40" rx="8" fill="var(--meteo-nav-bg)"/>
                <text x="40" y="85" font-size="24" fill="var(--meteo-sun)">←</text>
            </a>
            <text x="38" y="120" font-size="14" fill="var(--meteo-text)" text-anchor="middle" font-style="italic">
                <?= $libellePrecedent ?>
            </text>
            
            <a href="<?= $baseUrl . $separator ?>date=<?= $dateSuivant->format('Y-m-d') ?>" class="nav-link">
                <rect x="590" y="60" width="40" height="40" rx="8" fill="var(--meteo-nav-bg)"/>
                <text x="610" y="85" font-size="24" fill="var(--meteo-sun)">→</text>
            </a>
            <text x="608" y="120" font-size="14" fill="var(--meteo-text)" text-anchor="middle" font-style="italic">
                <?= $libelleSuivant ?>
            </text>
        </g>
    </svg>
    <?php
}

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
?>