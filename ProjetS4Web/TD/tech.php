<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Page tech</title>
    <meta name="description" content="Page tech avec l'utilisation des différents API"/>
    <link rel="stylesheet" href="css/style-bright.css"/>
  </head>
  <body>
    <main>

<?php
// Récupère l'IP du visiteur
function getIp(): string {
    return $_SERVER['REMOTE_ADDR'];
}

function fetchXml(string $url): ?SimpleXMLElement {
    $xml = simplexml_load_file($url);
	
    return $xml ? $xml : null;
}

function fetchJson(string $url): ?array {
    $contenu = file_get_contents($url);
	
    if ($contenu !== false) {
        $data = json_decode($contenu, true);
        return $data ? $data : null;
    }
    return null;
}

function afficherInfos(string $titre, array $infos): void {
    echo "<h3>$titre</h3><ul>";
    foreach ($infos as $cle => $val) {
        echo "<li>$cle : " . htmlspecialchars($val) . "</li>";
    }
    echo "</ul>";
}

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

function ExtractionIPInfo(): void {
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

function ExtractionWhatIsMyIP(): void {
    $apiKey = '309fed576688e0fb7761c82fe760236f';
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

// Appel des fonctions
afficherImageNASA();
geoLocaliser();
ExtractionIPInfo();
ExtractionWhatIsMyIP();
?>

    </main>
    <footer>
		<p>&#169; 2025 - BEMA. Tous droits réservés.</p>
		<p>Créé par COSTA Mathéo et ZIVIC Benjamin le 24 Mars 2025 à Cergy</p>
	</footer>
	</body>
</html
