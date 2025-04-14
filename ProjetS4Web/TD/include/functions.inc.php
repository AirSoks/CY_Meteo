<?php
// Exercice 1 : Affichage de l'heure du serveur
$date = date('H:i:s');
?>

<?php
// Exercice 2 : Fonction générant une liste HTML non ordonnée
function generateList() {
    $list = "<ul>";
    for ($i = 1; $i <= 20; $i++) {
        $list .= "<li style='color: black;'>Hello numéro $i</li>";
    }
    $list .= "</ul>";
    return $list;
}?>

<?php
// Exercice 3 : Conversions ASCII
$hex1 = "0x41";
$hex2 = "0x2B";
$dec1 = hexdec($hex1);
$dec2 = hexdec($hex2);
$char1 = chr($dec1);
$char2 = chr($dec2);
?>

<?php
// Exercice 4 : Liste HTML des chiffres hexadécimaux
function hexList() {
    $list = "<ul class='hex-list'>";
    for ($i = 0; $i <= 15; $i++) {
        $list .= "<li style='color: black;'>" . dechex($i) . "</li>";
    }
    $list .= "</ul>";
    return $list;
}
?>

<?php
// Exercice 5 : Tableau HTML des bases numériques
function generateTable() {
    $table = "<table>";
    $table .= "<caption>Conversions Numériques</caption>";
    $table .= "<thead><tr><th>Décimal</th><th>Binaire</th><th>Octal</th><th>Hexadécimal</th></tr></thead><tbody>";
    for ($i = 0; $i <= 17; $i++) {
        $table .= "<tr>";
        $table .= "<td>" . $i . "</td>";
        $table .= "<td>" . sprintf('%b', $i) . "</td>";
        $table .= "<td>" . sprintf('%o', $i) . "</td>";
        $table .= "<td>" . sprintf('%X', $i) . "</td>";
        $table .= "</tr>";
    }
    $table .= "</tbody></table>";
    return $table;
}
?>


<?php
const DEFAULT_SIZE = 10;

function generateMultiplicationTable(int $size = DEFAULT_SIZE): string {
    $html = "<table>\n";
    $html .= "<caption>Table de multiplication {$size}x{$size}</caption>\n";
    $html .= "<thead><tr><th scope='col'>×</th>";
    
    for ($i = 1; $i <= $size; $i++) {
        $html .= "<th scope='col'>{$i}</th>";
    }
    $html .= "</tr></thead><tbody>\n";
    
    for ($i = 1; $i <= $size; $i++) {
        $html .= "<tr><th scope='row'>{$i}</th>";
        for ($j = 1; $j <= $size; $j++) {
            $html .= "<td>" . ($i * $j) . "</td>";
        }
        $html .= "</tr>\n";
    }
    
    $html .= "</tbody></table>\n";
    return $html;
}
?>
<?php
function rgbToHex(int $r, int $g, int $b): string {
    return sprintf("#%02X%02X%02X", $r, $g, $b);
}

function hexToRgb(string $hex, int &$r, int &$g, int &$b): bool {
    $hex = ltrim($hex, '#');
    if (strlen($hex) === 3) {
        $hex = $hex[0] . $hex[0] . $hex[1] . $hex[1] . $hex[2] . $hex[2];
    }
    if (strlen($hex) !== 6 || !ctype_xdigit($hex)) {
        return false;
    }
    $r = hexdec(substr($hex, 0, 2));
    $g = hexdec(substr($hex, 2, 2));
    $b = hexdec(substr($hex, 4, 2));
    return true;
}
?>

<?php
function romanToDecimal(string $roman): int {
    $roman = strtoupper($roman);
    $values = [
        'I' => 1, 'V' => 5, 'X' => 10, 'L' => 50, 'C' => 100, 'D' => 500, 'M' => 1000
    ];
    $length = strlen($roman);
    $total = 0;
    $prevValue = 0;
    
    for ($i = $length - 1; $i >= 0; $i--) {
        $currentValue = $values[$roman[$i]] ?? 0;
        if ($currentValue < $prevValue) {
            $total -= $currentValue;
        } else {
            $total += $currentValue;
        }
        $prevValue = $currentValue;
    }
    return $total;
}
?>

<?php
function generateAsciiTable(): string {
    $html = "<table>\n";
    $html .= "<caption>Table ASCII</caption>\n";
    $html .= "<thead><tr><th>Décimal</th><th>Caractère</th></tr></thead><tbody>\n";
    
    for ($i = 32; $i < 128; $i++) {
        $char = chr($i);
        if ($char === '<') {
            $char = '&lt;';
        } elseif ($char === '>') {
            $char = '&gt;';
        } elseif ($char === '&') {
            $char = '&amp;';
        } elseif ($i === 127) {
            $char = "&#x00A0;";
        }
        
        $class = '';
        if ($i >= 48 && $i <= 57) {
            $class = 'class="digit"';
        } elseif ($i >= 65 && $i <= 90) {
            $class = 'class="uppercase"';
        } elseif ($i >= 97 && $i <= 122) {
            $class = 'class="lowercase"';
        }
        
        $html .= "<tr><td>{$i}</td><td {$class}>{$char}</td></tr>\n";
    }
    
    $html .= "</tbody></table>\n";
    return $html;
}
?>
<?php

// Définition de la fonction pour générer une liste HTML des régions
function afficherRegions(array $regions, bool $ordonnee = false): string {
    // Détermination du type de liste
    $balise = $ordonnee ? 'ol' : 'ul';
    
    // Construction de la liste HTML
    $html = "<$balise>";
    foreach ($regions as $region) {
        $html .= "<li>$region</li>";
    }
    $html .= "</$balise>";
    
    return $html;
}
?>
<?php
// Fonction pour obtenir les origines étymologiques de la date courante
function origineDate($jours, $mois) {
    // Récupération de la date courante
    $jourActuel = strtolower(date("l")); // Nom du jour en anglais
    $moisActuel = (int) date("n"); // Numéro du mois

    // Conversion du jour anglais vers français
    $joursFrancais = [
        "monday" => "lundi", "tuesday" => "mardi", "wednesday" => "mercredi",
        "thursday" => "jeudi", "friday" => "vendredi", "saturday" => "samedi", "sunday" => "dimanche"
    ];
    
    $jourFrancais = $joursFrancais[$jourActuel] ?? "Inconnu";
    
    // Récupération des origines
    $origineJour = $jours[$jourFrancais] ?? "Origine inconnue";
    $origineMois = $mois[$moisActuel] ?? "Origine inconnue";
    
    return "Nous sommes aujourd'hui $jourFrancais, dont l'origine vient de $origineJour. ".
           "Le mois actuel est le mois numéro $moisActuel, dérivé de $origineMois.";
}
?>

<?php

// Fonction pour récupérer le navigateur de l'utilisateur
function get_navigateur(): string {
    // Vérification de l'existence de la variable $_SERVER['HTTP_USER_AGENT']
    if (isset($_SERVER['HTTP_USER_AGENT'])) {
        $userAgent = $_SERVER['HTTP_USER_AGENT'];
        
        // Identification du navigateur à partir du User-Agent
        if (strpos($userAgent, 'Firefox') !== false) {
            return "Mozilla Firefox";
        } elseif (strpos($userAgent, 'Edg') !== false) {
            return "Microsoft Edge";
        } elseif (strpos($userAgent, 'Chrome') !== false) {
            return "Google Chrome";
        } elseif (strpos($userAgent, 'Safari') !== false) {
            return "Apple Safari";
        } elseif (strpos($userAgent, 'Opera') !== false || strpos($userAgent, 'OPR') !== false) {
            return "Opera";
        } elseif (strpos($userAgent, 'MSIE') !== false || strpos($userAgent, 'Trident') !== false) {
            return "Internet Explorer";
        } else {
            return "Navigateur inconnu";
        }
    } else {
        return "Information non disponible";
    }
}

?>

<?php
function analyserURL($url) {
    // Tableau associatif des TLD supportés
    $tlds = [
        'com' => 'Commercial',
        'org' => 'Organisation',
        'net' => 'Network',
        'fr'  => 'France'
    ];

    // On commence par parser l'URL
    $parsed = parse_url($url);

    // Vérification de la validité de l'URL
    if (!isset($parsed['scheme']) || !isset($parsed['host'])) {
        return ['error' => 'URL invalide ou non supportée'];
    }

    $host = $parsed['host'];

    // On sépare le host par les points (ex : www.cyu.fr => [www, cyu, fr])
    $parts = explode('.', $host);

    // On ne traite que les URL avec au moins 3 parties : sous-domaine, domaine, TLD
    if (count($parts) < 3) {
        return ['error' => 'Format de domaine non supporté'];
    }

    $tld_key = end($parts); // Dernier élément
    $domain = prev($parts); // Avant-dernier élément
    $subdomain = reset($parts); // Premier élément

    // Vérifier si le TLD est dans le tableau
    if (!array_key_exists($tld_key, $tlds)) {
        return ['error' => 'TLD non supporté'];
    }

    // Construire le tableau résultat
    return [
        'protocol' => $parsed['scheme'],
        'host'     => $subdomain,
        'domain'   => $domain,
        'tld'      => $tlds[$tld_key]
    ];
}

?>

<?php

function convertirChmod($octal) {
    // Tableau des permissions binaires vers texte
    $permissions = [
        0 => '---',
        1 => '--x',
        2 => '-w-',
        3 => '-wx',
        4 => 'r--',
        5 => 'r-x',
        6 => 'rw-',
        7 => 'rwx',
    ];

    // Vérification que la valeur est bien une chaîne de 3 chiffres octaux
    if (!preg_match('/^[0-7]{3}$/', $octal)) {
        return "Erreur : la valeur doit être une chaîne octale sur 3 chiffres (000 à 777).";
    }

    // On découpe chaque chiffre et on construit la chaîne finale
    $resultat = '';
    for ($i = 0; $i < 3; $i++) {
        $chiffre = (int) $octal[$i];
        $resultat .= $permissions[$chiffre] . ' ';
    }

    // On enlève l'espace final et on retourne
    return trim($resultat);
}

?>

<?php
// Récupération du style depuis l'URL
$style = "oui"; // valeur par défaut

if (isset($_GET["style"]) && !empty($_GET["style"]) && $_GET["style"] == "jour") {
    $style = "jour";
}
?>
