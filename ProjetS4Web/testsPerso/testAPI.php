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
 * Récupère les coordonnées d'une ville via l'API Open-Meteo.
 *
 * @param string $ville Le nom de la ville.
 * @return array|null Un tableau associatif avec 'latitude' et 'longitude', ou null en cas d'erreur.
 */
function getCityCoordinates(string $ville): ?array {
    $url = "https://geocoding-api.open-meteo.com/v1/search?name=" . urlencode($ville) . "&count=1&language=fr&format=json";
    $data = fetchJson($url);

    if ($data !== null && isset($data['results'][0])) {
        return [
            'latitude' => $data['results'][0]['latitude'],
            'longitude' => $data['results'][0]['longitude']
        ];
    }
    return null;
}

/**
 * Récupère les données météo via l'API Open-Meteo.
 *
 * @param float $latitude La latitude de la ville.
 * @param float $longitude La longitude de la ville.
 * @return array|null Les données météo, ou null en cas d'erreur.
 */
function getMeteoData(float $latitude, float $longitude): ?array {
    $url = "https://api.open-meteo.com/v1/forecast?latitude=$latitude&longitude=$longitude&hourly=temperature_2m,wind_speed_10m,relative_humidity_2m&timezone=UTC";
    return fetchJson($url);
}

/**
 * Affiche les données météo pour une ville et une date spécifiées.
 *
 * @param string $ville Le nom de la ville.
 * @param string $dateHeure La date et l'heure au format 'YYYY-MM-DD HH:MM'.
 */
function afficherMeteo(string $ville, string $date): void {
    
	// Récupérer les coordonnées de la ville
    $coordinates = getCityCoordinates($ville);

    if (!$coordinates) {
        echo "<p>Impossible de trouver les coordonnées pour la ville : " . htmlspecialchars($ville) . "</p>";
        return;
    }

    // Récupérer les données météo
    $meteoData = getMeteoData($coordinates['latitude'], $coordinates['longitude']);

    if (!$meteoData) {
        echo "<p>Impossible de récupérer les données météo pour " . htmlspecialchars($ville) . "</p>";
        return;
    }

    // Trouver la date au format attendu par l'API
    $newDate = str_replace(" ", "T", $date);
    $timeIndex = array_search($newDate, $meteoData['hourly']['time']);

    if ($timeIndex === false) {
        echo "<p>Impossible de trouver les données météo pour la date et l'heure spécifiées : " . htmlspecialchars($date) . "</p>";
        return;
    }
	
    // Extraction et affichage des informations météo
    afficherInfos($ville, [
        'Date' => $date,
        'Température' => $meteoData['hourly']['temperature_2m'][$timeIndex] . " °C",
        'Vitesse du vent' => $meteoData['hourly']['wind_speed_10m'][$timeIndex] . " km/h",
        'Humidité' => $meteoData['hourly']['relative_humidity_2m'][$timeIndex] . " %"
    ]);
}

// Appel des fonctions
// afficherImageNASA();
// geoLocaliser();
// ExtractionIPInfo();
// ExtractionWhatIsMyIP();
afficherMeteo("Cergy", "2025-04-05 14:00");
afficherMeteo("Cergy", "2025-04-05 15:00");
afficherMeteo("Cergy", "2025-04-05 16:00");
afficherMeteo("Cergy", "2025-04-05 17:00");
afficherMeteo("Cergy", "2025-04-05 18:00");
afficherMeteo("Cergy", "2025-04-05 19:00");
afficherMeteo("Cergy", "2025-04-05 20:00");
afficherMeteo("Cergy", "2025-04-05 21:00");
afficherMeteo("Cergy", "2025-04-05 22:00");
afficherMeteo("Cergy", "2025-04-05 23:00");
afficherMeteo("Cergy", "2025-04-05 00:00");
afficherMeteo("Cergy", "2025-04-05 01:00");
afficherMeteo("Cergy", "2025-04-05 02:00");
afficherMeteo("Cergy", "2025-04-05 03:00");
afficherMeteo("Cergy", "2025-04-05 04:00");
afficherMeteo("Cergy", "2025-04-05 05:00");
afficherMeteo("Cergy", "2025-04-05 06:00");
afficherMeteo("Cergy", "2025-04-05 07:00");
afficherMeteo("Cergy", "2025-04-05 08:00");
afficherMeteo("Cergy", "2025-04-05 09:00");
afficherMeteo("Cergy", "2025-04-05 10:00");
afficherMeteo("Cergy", "2025-04-05 11:00");
afficherMeteo("Cergy", "2025-04-05 12:00");
afficherMeteo("Cergy", "2025-04-05 13:00");
?>