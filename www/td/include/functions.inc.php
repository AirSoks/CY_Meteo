<?php

/**
 * Génère une liste de 20 éléments avec le texte "Hello numero X"
 * 
 * @return string Retourne une chaîne HTML avec les éléments de la liste
 */
function listeHello() {
	$liste = "";
    for ($i = 1; $i <= 20; $i++) {
        $liste .= "<li>Hello numero " . $i . "</li>";
    }
    return $liste;
}

/**
 * Effectue des conversions entre valeurs hexadécimales, décimales et caractères ASCII.
 * 
 * @return string Retourne une chaîne HTML avec les résultats des conversions
 */
function conversion() {
	$value = "";
	$value .= "<p>0x41 en décimal : " . hexdec("41") . "</p>";
	$value .= "<p>65 en hexadécimal : " . dechex(65) . "</p>";
	$value .= "<p>65 en caractère ASCII : " . chr(65) . "</p>";
	$value .= "<p>A en code ASCII : " . ord('A') . "</p>";
	$value .= "<p>0x2B en décimal : " . hexdec("2B") . "</p>";
	$value .= "<p>43 en hexadécimal : " . dechex(43) . "</p>";
	$value .= "<p>43 en caractère ASCII : " . chr(43) . "</p>";
	$value .= "<p>+ en code ASCII : " . ord('+') . "</p>";
	
	return $value;
}

/**
 * Génère une liste de 16 éléments représentant les valeurs hexadécimales de 0 à 15.
 * 
 * @return string Retourne une chaîne HTML avec les éléments de la liste en hexadécimal
 */
function listeHexa() {
	$liste = "";
    for ($i = 0; $i <= 15; $i++) {
        $liste .= "<li>" . dechex($i) . "</li>";
    }
    return $liste;
}

/**
 * Génère un tableau HTML avec les conversions des nombres de 0 à 17 en binaire, octal, décimal et hexadécimal.
 * 
 * @return string Retourne une chaîne HTML contenant le tableau des conversions
 */
function listeTableau() {
	$liste = "";
    $liste = "<table>
			  <caption>Conversions en bases 2, 8, 10 et 16</caption>
				  <thead>
					  <tr>
						  <th>Binaire</th>
						  <th>Octal</th>
						  <th>Décimal</th>
						  <th>Hexadécimal</th>
					  </tr>
				  </thead>
				  <tbody>";

    for ($i = 0; $i <= 17; $i++) {
        $liste .= "<tr>
					   <td>" . sprintf("%b", $i) . "</td>
					   <td>" . sprintf("%o", $i) . "</td>
					   <td>" . $i . "</td>
					   <td>" . sprintf("%X", $i) . "</td>
				   </tr>";
    }

    $liste .= "</tbody></table>";

    return $liste;
}

const TAILLE_PAR_DEFAUT = 10;

/**
 * Génère une table de multiplication sous forme d'un tableau HTML.
 *
 * @param int $taille La dimension de la table de multiplication (par défaut TAILLE_PAR_DEFAUT)
 * @return string Retourne une chaine contenant le tableau
 */
function genererTableMultiplication(int $taille = TAILLE_PAR_DEFAUT): string {
    $value = "\t\t\t<table>\n";
    $value .= "\t\t\t<caption>Table de multiplication {$taille}x{$taille}</caption>\n";
    $value .= "\t\t\t\t<thead>\n";
    $value .= "\t\t\t\t\t<tr>\n";
    $value .= "\t\t\t\t\t\t<th scope='col'>X</th>\n";

    for ($i = 1; $i <= $taille; $i++) {
        $value .= "\t\t\t\t\t\t<th scope='col'>{$i}</th>\n";
    }
    $value .= "\t\t\t\t\t</tr>\n";
    $value .= "\t\t\t\t</thead>\n";
    $value .= "\t\t\t\t<tbody>\n";

    for ($i = 1; $i <= $taille; $i++) {
        $value .= "\t\t\t\t\t<tr>\n";
        $value .= "\t\t\t\t\t\t<th scope='row'>{$i}</th>\n";
        for ($j = 1; $j <= $taille; $j++) {
            $value .= "\t\t\t\t\t\t\t<td>" . ($i * $j) . "</td>\n";
        }
        $value .= "\t\t\t\t\t</tr>\n";
    }

    $value .= "\t\t\t\t</tbody>\n";
    $value .= "\t\t\t</table>\n";
    return $value;
}


/**
 * Convertit une couleur RGB en code hexadécimal.
 * 
 * @param int $r Valeur rouge (0-255)
 * @param int $g Valeur verte (0-255)
 * @param int $b Valeur bleue (0-255)
 * @return string|null Code hexadécimal (ex: #FF0080) ou null si erreur
 */
function rgbEnHex(int $r, int $g, int $b): ?string {
	
    if ($r < 0 || $r > 255 || $g < 0 || $g > 255 || $b < 0 || $b > 255) {
        return null;
    }
	
    return sprintf("#%02X%02X%02X", $r, $g, $b);
}

/**
 * Convertit un code couleur hexadécimal en RGB (avec passage par adresse).
 * 
 * @param string $hex Code hexadécimal (ex: #FF0080 ou #F08)
 * @param int &$r Référence pour stocker la valeur rouge (0-255)
 * @param int &$g Référence pour stocker la valeur verte (0-255)
 * @param int &$b Référence pour stocker la valeur bleue (0-255)
 * @return int|bool Retourne 1 si conversion réussie, false sinon
 */
function hexEnRgb(string $hex, int &$r, int &$g, int &$b): int | bool {

    if (preg_match('/^[0-9A-Fa-f]{6}$/', $hex)) {
		
        $r = hexdec(substr($hex, 0, 2));
        $g = hexdec(substr($hex, 2, 2));
        $b = hexdec(substr($hex, 4, 2));
        return 1;
    } elseif (preg_match('/^[0-9A-Fa-f]{3}$/', $hex)) {
		
        $r = hexdec(str_repeat($hex[0], 2));
        $g = hexdec(str_repeat($hex[1], 2));
        $b = hexdec(str_repeat($hex[2], 2));
        return 1;
    }

    return false;
}

/**
 * Convertit un nombre en chiffres romains en son équivalent décimal.
 *
 * @param string $romain Le nombre en chiffres romains (ex: "XXI")
 * @return int|bool La valeur décimale du nombre ou false en cas d'erreur
 */
function romainEnDecimal(string $romain): int | bool {
	
    $valeurs = [
        'I' => 1, 'V' => 5, 'X' => 10, 'L' => 50,
        'C' => 100, 'D' => 500, 'M' => 1000
    ];

    $romain = strtoupper($romain);
    $longueur = strlen($romain);
    $total = 0;
    $precedent = 0;
	
    for ($i = $longueur - 1; $i >= 0; $i--) {
        $lettre = $romain[$i];
		
        if (!isset($valeurs[$lettre])) {
            return false;
        }
        $valeur = $valeurs[$lettre];

        if ($valeur < $precedent) {
            $total -= $valeur;
        } else {
            $total += $valeur;
        }
        $precedent = $valeur;
    }
    return $total;
}

/**
 * Génère la table ASCII de 32 à 127 et la retourne en HTML
 *
 * @return string Retourne le HTML de la table ASCII
 */
function genererTableAscii(): string {
    $html = "<table>\n";
	
    $html .= "\t\t\t\t\t<tr>\n\t\t\t\t\t<th></th>\n";
    for ($col = 0; $col < 16; $col++) {
        $html .= "\t\t\t\t<th>" . strtoupper(dechex($col)) . "</th>\n";
    }
    $html .= "\t\t\t\t</tr>\n";
	
    for ($row = 2; $row <= 7; $row++) {
        $html .= "\t\t\t\t<tr>\n\t\t\t\t\t<th>$row</th>\n";

        for ($col = 0; $col < 16; $col++) {
            $ascii = $row * 16 + $col;

            if ($ascii > 127) {
                $html .= "\t\t\t\t\t<td></td>\n";
                continue;
            }

            $char = chr($ascii);
            if ($char == "<") {
                $char = "&lt;";
            } elseif ($char == ">") {
                $char = "&gt;";
            } elseif ($char == "&") {
                $char = "&amp;";
            } elseif ($ascii == 127) {
                $char = "&#x00A0;";
            }
			
            $class = "";
            if (ctype_digit($char)) {
                $class = "chiffre";
            } elseif (ctype_upper($char)) {
                $class = "majuscule";
            } elseif (ctype_lower($char)) {
                $class = "minuscule";
            }

            $html .= "\t\t\t\t\t<td class='{$class}'>{$char}</td>\n";
        }
        $html .= "\t\t\t\t</tr>\n";
    }

    $html .= "\t\t\t\t</table>\n";
    return $html;
}

/**
 * Génère une liste HTML des régions de France.
 * 
 * @param string $typeListe Type de liste à générer ('ul' ou 'ol'). Par défaut, 'ul'.
 * @return string Retourne le code HTML de la liste des régions
 */
function genererListeRegions(string $typeListe = 'ul'): string {
    $regions = [
        "Guadeloupe", "Martinique", "Guyane", "La Réunion", "Mayotte", "Île-de-France", "Centre-Val de Loire", 
        "Bourgogne-Franche-Comté", "Normandie", "Hauts-de-France", "Grand Est", "Pays de la Loire", "Bretagne", 
        "Nouvelle-Aquitaine", "Occitanie", "Auvergne-Rhône-Alpes", "Provence-Alpes-Côte d’Azur", "Corse"
    ];

    $typeListe = ($typeListe === 'ol') ? 'ol' : 'ul';

    $html = "<$typeListe style='list-style-position: inside; padding: 0; text-align: center;'>\n";
    foreach ($regions as $region) {
        $html .= "\t<li>$region</li>\n";
    }
    $html .= "</$typeListe>\n";

    return $html;
}

/**
 * Retourne l'origine étymologique du jour et du mois actuels.
 * 
 * @return string Une phrase contenant la date formatée et l'origine du jour et du mois.
 */
function origineDateCourante(): string {
	
    $jours = [
		"Monday" => "Lune",
        "Tuesday" => "Mars",
        "Wednesday" => "Mercure",
        "Thursday" => "Jupiter",
        "Friday" => "Vénus",
        "Saturday" => "Saturne",
        "Sunday" => "Soleil"
    ];
	
    $mois = [
        1 => "Janus",
        2 => "Febrarius",
        3 => "Mars",
        4 => "Aphrodite",
        5 => "Maia",
        6 => "Junon",
        7 => "Jules César",
        8 => "Auguste",
        9 => "Septem",
        10 => "October",
        11 => "Novem",
        12 => "Decem"
    ];
	
	$jourActuel = date("l");
    $moisActuel = (int)date("n");
	
    $origineJour = $jours[$jourActuel] ?? "Inconnu";
    $origineMois = $mois[$moisActuel] ?? "Inconnu";
	
    $dateFormattee = date("l d F Y");

    return "Aujourd'hui, nous sommes $dateFormattee. Le nom du jour vient de <strong>$origineJour</strong> et celui du mois de <strong>$origineMois</strong>.";
}

/**
 * Détecte le navigateur utilisé par l'utilisateur.
 * 
 * @return string Le nom du navigateur ou "Navigateur inconnu" si non détecté.
 */
function get_navigateur(): string {
    $userAgent = $_SERVER['HTTP_USER_AGENT'];

    if (strpos($userAgent, 'Chrome') !== false) {
        return "Google Chrome";
    } elseif (strpos($userAgent, 'Firefox') !== false) {
        return "Mozilla Firefox";
    } elseif (strpos($userAgent, 'Safari') !== false) {
        return "Apple Safari";
    } elseif (strpos($userAgent, 'Edge') !== false) {
        return "Microsoft Edge";
    } elseif (strpos($userAgent, 'Opera') !== false) {
        return "Opera";
    } else {
        return "Navigateur inconnu";
    }
}

function genererMenuExercices(array $exercices): string {
    $tousLesExercices = [];
    for ($i = 1; $i <= 10; $i++) {
        $tousLesExercices[$i] = "Exercice " . $i;
    }

    $menuHtml = '<nav style="position: fixed; left: 10px; top: 50%; transform: translateY(-50%); background: #383838; padding: 15px; border-radius: 10px; box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.3); z-index: 1000;">';
    $menuHtml .= '<ul style="list-style: none; padding: 0; margin: 0;">';

    foreach ($exercices as $exercice) {
        if (isset($tousLesExercices[$exercice])) {
            $menuHtml .= '<li style="margin-bottom: 10px;"><a href="#ex' . $exercice . '" style="color: white; font-weight: bold;">' . $tousLesExercices[$exercice] . '</a></li>';
        }
    }

    $menuHtml .= '</ul>';
    $menuHtml .= '</nav>';

    return $menuHtml;
}

/**
 * Extrait les informations d'une URL.
 *
 * Cette fonction analyse une URL fournie en paramètre et retourne un tableau associatif 
 * contenant des informations telles que le protocole, le domaine, le sous-domaine et le TLD.
 *
 * @param string $url L'URL à analyser.
 * 
 * @return array Un tableau contenant les informations extraites de l'URL, ou un message d'erreur.
 */
function extractUrlInfo(string $url): array {
    $parsedUrl = parse_url($url);
    if (!isset($parsedUrl['scheme']) || !isset($parsedUrl['host'])) {
        return ['error' => 'URL invalide'];
    }
    
    $protocol = $parsedUrl['scheme'];
    $hostParts = explode('.', $parsedUrl['host']);
    
    $tldMapping = [
        'com' => 'Commercial',
        'org' => 'Organisation',
        'net' => 'Network',
        'fr'  => 'France'
    ];
    
    $tld = end($hostParts);
    if (!isset($tldMapping[$tld])) {
        return ['error' => 'TLD non autorisé'];
    }
    
    if (count($hostParts) < 2) {
        return ['error' => 'Format de domaine invalide'];
    }
    
    $domain = $hostParts[count($hostParts) - 2] ?? '';
    $subdomain = ($hostParts[0] !== $domain) ? $hostParts[0] : '';
    
    return [
        'protocol' => $protocol,
        'host' => $parsedUrl['host'],
        'domain' => $domain,
        'subdomain' => $subdomain,
        'tld' => $tldMapping[$tld]
    ];
}

/**
 * Convertit une valeur octale (sur 3 chiffres) en une chaîne de permissions.
 *
 * @param $octal La valeur octale (peut être passée en tant qu'entier ou chaîne)
 * @return string La représentation textuelle des permissions.
 */
function chmodToText(int $octal): string {
    
    $octalStr = str_pad((string)$octal, 3, '0', STR_PAD_LEFT);

    $permissionMap = [
        '0' => '---',
        '1' => '--x',
        '2' => '-w-',
        '3' => '-wx',
        '4' => 'r--',
        '5' => 'r-x',
        '6' => 'rw-',
        '7' => 'rwx'
    ];

    $result = [];
    
    for ($i = 0; $i < 3; $i++) {
        $digit = $octalStr[$i];
        if (!isset($permissionMap[$digit])) {
            return "Erreur : le chiffre octal '$digit' est invalide.";
        }
        $result[] = $permissionMap[$digit];
    }
    return implode(' ', $result);
}

?>

