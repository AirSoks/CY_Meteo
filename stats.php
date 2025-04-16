<?php

function getTop10VillesAvecComptage($csvFilePath) {
    $cityCounts = [];

    if (!file_exists($csvFilePath) || !is_readable($csvFilePath)) {
        return [];
    }

    if (($handle = fopen($csvFilePath, 'r')) !== false) {
        $header = fgetcsv($handle);
        $cityIndex = array_search('name', array_map('strtolower', $header));

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

function genererGraphiqueEtSauvegarder($data, $cheminImage) {
    $width = 800;
    $height = 400;
    $image = imagecreatetruecolor($width, $height);

    $white = imagecolorallocate($image, 255, 255, 255);
    $black = imagecolorallocate($image, 0, 0, 0);
    $blue = imagecolorallocate($image, 70, 130, 180);

    imagefilledrectangle($image, 0, 0, $width, $height, $white);

    $margin = 50;
    $barWidth = 40;
    $gap = 30;
    $maxValue = max($data);
    $scale = ($height - 2 * $margin) / $maxValue;

    $i = 0;
    foreach ($data as $city => $count) {
        $x1 = (int) ($margin + $i * ($barWidth + $gap));
		$y1 = (int) ($height - $margin);
		$x2 = (int) ($x1 + $barWidth);
		$y2 = (int) ($y1 - ($count * $scale));

        imagefilledrectangle($image, $x1, $y1, $x2, $y2, $blue);
        imagestringup($image, 2, $x1 + 10, $y1 + 15, mb_strimwidth($city, 0, 10, ''), $black);
        imagestring($image, 2, $x1, $y2 - 15, $count, $black);

        $i++;
    }

    imageline($image, (int)$margin, (int)($height - $margin), (int)($width - $margin), (int)($height - $margin), $black);
    imagepng($image, $cheminImage); // sauvegarde dans un fichier
    imagedestroy($image);
}

function afficherTop10VillesDepuisCSV($csvFilePath) {
    $cityCounts = getTop10VillesAvecComptage($csvFilePath);
    echo "<ul>";
    foreach ($cityCounts as $city => $count) {
        echo "<li>" . htmlspecialchars($city) . " (" . $count . " fois)</li>";
    }
    echo "</ul>";
}

// Génération du graphique en fichier PNG
$csvPath = './csv/cities.csv';
$imagePath = './images/graphique_villes.png';

$topVilles = getTop10VillesAvecComptage($csvPath);

// Si le dossier n'existe pas, le créer
if (!is_dir('./images')) {
    mkdir('./images', 0777, true);
}

// Générer l'image sur le serveur
if (!empty($topVilles)) {
    genererGraphiqueEtSauvegarder($topVilles, $imagePath);
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Top 10 des villes</title>
</head>
<body>
    <h2>Top 10 des villes les plus fréquentes</h2>
    <?php afficherTop10VillesDepuisCSV($csvPath); ?>

    <h3>Graphique enregistré côté serveur :</h3>
    <img src="images/graphique_villes.png" alt="Graphique des villes">
</body>
</html>
