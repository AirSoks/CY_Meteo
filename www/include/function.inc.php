<?php

/**
 * @file
 * @brief Fichier principal des fonctions utilitaires du projet Meteo COZI
 * @mainpage Meteo COZI - Documentation technique
 * 
 * Ce projet utilise des fonctions PHP procédurales trié par thème.
 */

/**
 * *************************************************************************
 * Fonctions Utilitaires Générales
 * *************************************************************************
 */
 
/**
 * @param mixed $variable Variable à vérifier
 * @param string $message Message d'erreur format HTML
 * @return bool True si valide, sinon false
 */
function verifierVariable($variable, string $message): bool {
    if (!isset($variable) || empty($variable)) {
        echo "<p class=\"incorrect_var\">$message</p>";
        return false;
    }
    return true;
}

/**
 * Formate une date/heure au format ISO 8601 (ex: 2023-12-25T14:30) en heure:minute
 * 
 * @param string $dateTime Chaîne au format Y-m-d\TH:i (ex: "2023-12-25T14:30")
 * @return string Heure formatée (ex: "14h30") ou "Invalide" si format incorrect
 */
function formatHeureMinute(string $dateTime): string {
    $dt = DateTime::createFromFormat('Y-m-d\TH:i', $dateTime);
    return $dt ? $dt->format('G\hi') : 'Invalide';
}

/**
 * Convertit des secondes en format horaire heures:minutes
 * 
 * @param float $seconds Durée en secondes (décimales ignorées par conversion interne)
 * @return string Durée formatée sous forme "XhYY" (ex: "2h05" pour 2h05min)
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
 * Récupère l'adresse IP publique du client
 *
 * @return string IPv4 ou IPv6
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

/**
 * Récupère un chemin d'image aléatoire depuis le dossier 'illustrations'
 * 
 * @return string|null Chemin HTML-échappé de l'image ou null si dossier invalide/vide
 */
function getImageAleatoire(): ?string {
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
 * Sépare une chaîne au premier espace
 * @param string $description Texte à séparer
 * @return array{0: string, 1: string} Tableau avec 2 éléments
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
 * 
 * @param array $meteoData Données météo brutes (doit contenir une clé 'daily')
 * @param string $ville Nom de la ville analysée
 * @param string $date Date au format YYYY-MM-DD
 * 
 * @return array{
 *     ville: string,
 *     date: string,
 *     temperatures: array{min: string, max: string, moyenne: string},
 *     precipitation: string,
 *     vent: array{vitesse_max: string, rafales_max: string},
 *     humidite: string,
 *     ensoleillement: array{lever: string, coucher: string, duree: string},
 *     conditions: array{code: int, icone: string, description: string}
 * }
 * 
 * @throws RuntimeException Si données manquantes ou date introuvable
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
 * 
 * @param array $meteoData Données météo brutes (doit contenir une clé 'hourly')
 * @param string $ville Nom de la ville analysée
 * @param string $dateHeure Créneau horaire au format YYYY-MM-DD HH:MM
 * 
 * @return array{
 *     ville: string,
 *     date_heure: string,
 *     temperature: string,
 *     vent: array{vitesse: string},
 *     humidite: string,
 *     conditions: array{code: int, icone: string, description: string}
 * }
 * 
 * @throws RuntimeException Si données manquantes ou créneau introuvable
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
 * Génère le rendu d'un donut (graphique circulaire)
 * 
 * @param int|float $percent Pourcentage (-100 à 100)
 * @param string $mainText Texte principal centré
 * @param string $subText Sous-texte informatif
 * @param string $colorClass Classe CSS pour la couleur du segment
 * @param int $fontSize Taille du texte principal (défaut: 7)
 * @param string|null $textColorClass Classe CSS optionnelle pour le texte principal
 */
function renderDonut(int|float $percent, string $mainText, string $subText, string $colorClass, float $fontSize = 7, ?string $textColorClass = null): void {
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
 * Génération d'un graphique en barres horizontales
 * 
 * @param array<string, int> $data Données à visualiser (ville => valeur)
 * @param string $cheminImage Chemin de sortie pour l'image PNG
 * @param 'standard'|'alternatif' $theme Palette de couleurs
 * @param int $width Largeur de l'image en pixels
 * @param int $height Hauteur de l'image en pixels
 * 
 * @return bool True si succès, false si l'extension GD manquante
 */
function genererGraphique(array $data, string $cheminImage, string $theme = 'standard', int $width = 1200, int $height = 600): bool {
    if (!extension_loaded('gd')) return false;

    $fontFile = __DIR__ . '/../fonts/OpenSans-Regular.ttf';
    $fontSize = 12;
    
    $image = imagecreatetruecolor($width, $height);
    
    if ($theme === 'alternatif') {
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

    $i = 0;
    foreach ($data as $city => $count) {
        $y = (int)($chartTop + $i * ($barHeight + $gap));
        
        $bbox = imagettfbbox($fontSize, 0, $fontFile, $city);
        $textWidth = $bbox[2] - $bbox[0];
        $textHeight = $bbox[1] - $bbox[7];
        
        imagettftext(
            $image, 
            $fontSize, 
            0, 
            (int) ($marginGauche - 20 - $textWidth), 
            (int) ($y + $barHeight/2 + $textHeight/2), 
            $texte, 
            $fontFile, 
            $city
        );
        
        $barLen = (int)($count * $scale);
        imagefilledrectangle($image, $marginGauche, $y, $marginGauche + $barLen, $y + $barHeight, $barres);
        
        imagettftext(
            $image, 
            $fontSize, 
            0, 
            (int) ($marginGauche + $barLen + 15), 
            (int) ($y + $barHeight/2 + $textHeight/2), 
            $texte, 
            $fontFile, 
            $count
        );
        
        $i++;
    }

    $nbGraduations = 5;
    for ($j = 0; $j <= $nbGraduations; $j++) {
        $val = round($maxValue * ($j / $nbGraduations));
        $x = $marginGauche + (int)($val * $scale);
        imageline($image, $x, $chartTop - 5, $x, $chartTop + $chartHeight, $axes);
        
        $bbox = imagettfbbox($fontSize, 0, $fontFile, $val);
        $textWidth = $bbox[2] - $bbox[0];
        imagettftext($image, $fontSize, 0, (int) ($x - $textWidth/2), (int) ($chartTop + $chartHeight + 25), $texte, $fontFile, $val);
    }

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
 * @param string $date La date à traiter au format YYYY-MM-DD (défaut: 2025-03-23)
 */
function afficherImageNASA(string $date = '2025-03-23'): void {
    $apiKey = 'kuSSwvl8vDlTfE2tLqV8tfqxGYJ3wOyTvpSBMTkU';
    $url = "https://api.nasa.gov/planetary/apod?api_key=$apiKey&date=$date&thumbs=True";
    $data = fetchJson($url);
    
    if (!$data || !isset($data['url'])) {
        echo "<p>Erreur lors de la récupération de l'image NASA.</p>";
        return;
    }
    
    echo "<h2>" . htmlspecialchars($data['title']) . "</h2>";
    
    switch ($data['media_type']) {
        case 'image':
            echo "<img src='" . htmlspecialchars($data['url']) . "' alt='Image du jour de la NASA' style='max-width:100%; height:auto;'/>";
            break;
            
        case 'video':
            $thumbnail = isset($data['thumbnail_url']) ? " poster='" . htmlspecialchars($data['thumbnail_url']) . "'" : '';
            echo "<video controls{$thumbnail} style='max-width:100%; height:auto;'><source src='" . htmlspecialchars($data['url']) . "' type='video/mp4'>
                    Votre navigateur ne supporte pas les vidéos HTML5.</video>";
            break;
            
        default: // Cas 'other' et types inconnus
            echo "<img src='images/default.jpg' alt='Média non supporté' style='max-width:100%; height:auto;'>";
            break;
    }
	
    echo "<div class='description'>" . htmlspecialchars($data['explanation']) . "</div>";
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
    $apiKey = '0510b702f39d101ba4da0196e9dd5685';
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
 * Récupère les villes à partir d'un fichier CSV
 * 
 * @param string $filename Chemin du fichier CSV
 * @return array[] Tableau de villes (structure garantie même si vide)
 * 
 * @throws RuntimeException Si le fichier est illisible (non trouvé ou permissions)
 */
function getCitiesFromCSV(string $filename): array {
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
 * Filtre les villes par code de département
 * 
 * @param array[] $cities Tableau de villes ([['department_code' => string, ...], ...])
 * @param string $departmentCode Code départemental (ex: "75")
 * 
 * @return array[] Sous-ensemble des villes correspondantes
 * 
 * @throws InvalidArgumentException Si structure des villes invalide
 */
function filterCitiesByDepartment(array $cities, string $departmentCode): array {
    return array_filter($cities, function($city) use ($departmentCode) {
        return $city['department_code'] == $departmentCode;
    });
}

/**
 * Affiche une liste déroulante de villes
 * 
 * @param array[] $cities Tableau de villes [['id' => string, 'name' => string], ...]
 * @param string $selected ID de la ville présélectionnée
 * 
 * @throws InvalidArgumentException Si structure de ville invalide
 */
function displayCityDropdown(array $cities, string $selected = ''): void {
    echo '<select name="ville" id="ville-select" required="required">';
    echo '<option value="">Sélectionnez une ville</option>';

    foreach ($cities as $city) {
        if (!isset($city['id']) || !isset($city['name'])) {
            throw new InvalidArgumentException('Structure de ville invalide');
        }

        echo sprintf(
            '<option value="%s" %s>%s</option>',
            htmlspecialchars($city['id']),
            ($city['id'] === $selected) ? 'selected="selected"' : '',
            htmlspecialchars($city['name'])
        );
    }
    
    echo '</select>';
}

/**
 * Récupère les départements à partir d'un fichier CSV
 * 
 * @param string $filename Chemin du fichier CSV
 * @return array[] Tableau de départements [['code' => string, ...], ...]
 * 
 * @throws RuntimeException Si le fichier est illisible
 * @throws UnexpectedValueException Si structure CSV invalide
 */
function getDepartmentsFromCSV(string $filename): array {
    if (!is_readable($filename)) {
        throw new RuntimeException("Fichier $filename inaccessible");
    }

    $handle = fopen($filename, 'r');
    if ($handle === false) {
        return [];
    }

    $headers = fgetcsv($handle, 1000, ',');
    if ($headers === false) {
        fclose($handle);
        return [];
    }

    $requiredColumns = ['code', 'region_code', 'name'];
    if (count(array_intersect($requiredColumns, $headers)) !== 3) {
        fclose($handle);
        throw new UnexpectedValueException('Colonnes manquantes dans le CSV');
    }

    $departments = [];
    while (($data = fgetcsv($handle, 1000, ',')) !== false) {
        $department = array_combine($headers, $data);
        $departments[] = [
            'code' => $department['code'] ?? '',
            'region_code' => $department['region_code'] ?? '',
            'name' => $department['name'] ?? ''
        ];
    }

    fclose($handle);
    return $departments;
}

/**
 * Filtre les départements par code de région
 * 
 * @param array[] $departments Tableau de départements [['region_code' => string, ...], ...]
 * @param string $regionCode Code régional à filtrer (ex: "11")
 * 
 * @return array[] Départements correspondants (conservent leur structure d'origine)
 * 
 * @throws InvalidArgumentException Si structure des départements invalide
 */
function filterDepartmentsByRegion(array $departments, string $regionCode): array {
    if (!empty($departments) && !isset($departments[0]['region_code'])) {
        throw new InvalidArgumentException('Structure de département invalide');
    }

    return array_filter($departments, function($department) use ($regionCode) {
        return $department['region_code'] === $regionCode;
    });
}

/**
 * Affiche une liste déroulante de départements
 * 
 * @param array[] $departments Tableau de départements [['code' => string, 'region_code' => string, 'name' => string], ...]
 * @param string $selected Code départemental présélectionné
 */
function displayDepartmentDropdown($departments, $selected = ''): void {
    echo '<select name="departement" id="departement-select">';
    echo '<option value="">Sélectionnez un département</option>';
    foreach ($departments as $department) {
        $sel = ($department['code'] == $selected) ? 'selected="selected"' : '';
        echo '<option value="' . $department['code'] . '" data-region="' . $department['region_code'] . '" ' . $sel . '>';
        echo $department['name'];
        echo '</option>';
    }
    echo '</select>';
}

/**
 * Récupère les régions à partir d'un fichier CSV
 * 
 * @param string $filename Chemin du fichier CSV
 * @return array[] Tableau de régions [['code' => string, 'name' => string, 'slug' => string], ...]
 * 
 * @throws RuntimeException Si le fichier est illisible
 * @throws UnexpectedValueException Si structure CSV invalide
 */
function getRegionsFromCSV(string $filename): array {
    if (!is_readable($filename)) {
        throw new RuntimeException("Fichier $filename inaccessible");
    }

    $handle = fopen($filename, 'r');
    if ($handle === false) {
        return [];
    }

    $headers = fgetcsv($handle, 1000, ',');
    if ($headers === false) {
        fclose($handle);
        return [];
    }

    $requiredColumns = ['code', 'name', 'slug'];
    if (count(array_intersect($requiredColumns, $headers)) !== 3) {
        fclose($handle);
        throw new UnexpectedValueException('Colonnes manquantes dans le CSV');
    }

    $regions = [];
    while (($data = fgetcsv($handle, 1000, ',')) !== false) {
        $region = array_combine($headers, $data);
        $regions[] = [
            'code' => $region['code'] ?? '',
            'name' => $region['name'] ?? '',
            'slug' => $region['slug'] ?? ''
        ];
    }

    fclose($handle);
    return $regions;
}

/**
 * Affiche une liste déroulante de régions
 * 
 * @param array[] $regions Tableau de régions [['code' => string, 'slug' => string, 'name' => string], ...]
 * @param string $selected Code régional présélectionné
 * 
 * @throws InvalidArgumentException Si structure des régions invalide
 */
function displayRegionDropdown(array $regions, string $selected = ''): void {
    if (!empty($regions) && !isset($regions[0]['code'], $regions[0]['slug'], $regions[0]['name'])) {
        throw new InvalidArgumentException('Structure des régions invalide');
    }

    echo '<select name="region" id="region-select" required="required">';
    echo '<option value="">Sélectionnez une région</option>';

    foreach ($regions as $region) {
        echo sprintf(
            '<option value="%s" data-slug="%s" %s>%s</option>',
            htmlspecialchars($region['code'], ENT_QUOTES),
            htmlspecialchars($region['slug'], ENT_QUOTES),
            ($region['code'] === $selected) ? 'selected="selected"' : '',
            htmlspecialchars($region['name'])
        );
    }

    echo '</select>';
}

/**
 * Récupère une ville par son ID
 * 
 * @param array[] $cities Tableau de villes [['id' => string, ...], ...]
 * @param string $id Identifiant à rechercher
 * 
 * @return array|null Ville trouvée ou null
 * 
 * @throws InvalidArgumentException Si structure des villes invalide
 */
function getCityById(array $cities, string $id): ?array {
    foreach ($cities as $city) {
        if (!isset($city['id'])) {
            throw new InvalidArgumentException('Structure de ville invalide');
        }

        if ($city['id'] === $id) {
            return $city;
        }
    }
    return null;
}

/**
 * Récupère le code de région associé à un département
 * 
 * @param array[] $departments Tableau de départements [['code' => string, 'region_code' => string], ...]
 * @param string $departmentCode Code départemental à rechercher
 * 
 * @return string Code régional ou chaîne vide si non trouvé
 * 
 * @throws InvalidArgumentException Si structure des départements invalide
 */
function getRegionCodeByDepartment(array $departments, string $departmentCode): string {
    foreach ($departments as $dept) {
        if (!isset($dept['code'], $dept['region_code'])) {
            throw new InvalidArgumentException('Structure de département invalide');
        }

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
 * Enregistre les informations de la ville sélectionnée
 * 
 * @param array $city Ville à logger [
 *     'id' => string,
 *     'name' => string,
 *     'department_code' => string,
 *     'gps_lat' => string,
 *     'gps_lng' => string
 * ]
 * @param array[] $departments Tableau de départements [['code' => string, 'region_code' => string], ...]
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
 * Récupère la dernière sélection de ville depuis les cookies
 * 
 * @return array Structure normalisée [
 *     'region' => ?string,
 *     'department_code' => ?string,
 *     'city_id' => ?string
 * ]
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
 * Définit un cookie pour la ville sélectionnée
 * 
 * @param array $city Ville [
 *     'id' => string,
 *     'name' => string,
 *     'department_code' => string
 * ]
 * @param array[] $departments Tableau de départements [['code' => string, 'region_code' => string], ...]
 */
function setCityCookie(array $city, array $departments): void {
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
 * Traduit une date anglaise en français
 * 
 * @param string $dateAnglaise Date au format "Jour Mois Année" (ex: "Monday 25 January 2025")
 * @return string Date traduite (ex: "Lundi 25 janvier 2025")
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
 * Génère un libellé de date relatif ou traduit
 * 
 * @param DateTimeInterface $date Date à formater
 * @return string Libellé formaté (ex: "Aujourd'hui à", "Lundi à")
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
 * Valide qu'une date est au format YYYY-MM-DD et dans les X prochains jours
 * 
 * @param string $date Date à valider
 * @param int $maxJours Nombre maximal de jours dans le futur (défaut: 5)
 * 
 * @return bool True si valide, false sinon
 */
function validateDateInterval(string $date, int $maxJours = 5): bool {
	
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

    return $daysDifference >= 0 && $daysDifference <= $maxJours;
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
 * Récupère les prévisions météorologiques horaires pour les 24 prochaines heures
 * 
 * @param array $meteoData Données météo brutes (format attendu par getMeteoHoraire)
 * @param string $ville Identifiant de ville (format attendu par getMeteoHoraire)
 * 
 * @return array[] Tableau de prévisions [
 *     [
 *         'date_heure' => string (format Y-m-d H:i),
 *         'temperature' => float,
 *         'conditions' => string,
 *         'erreur' => string|null
 *     ]
 * ]
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
 * Récupère et valide la date courante
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
 * @param string $csvFilePath Chemin du fichier CSV
 * @return int Le nouveau compteur
 */
function compteurVisites(string $csvFilePath) {
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
 *
 * @param string $csvFilePath Chemin du fichier CSV
 */
function getTop10Villes(string $csvFilePath) {
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