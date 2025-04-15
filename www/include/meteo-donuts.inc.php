<?php

$temperatureMoy = (float)str_replace(' °C', '', $dataJournalier['temperatures']['moyenne']);
$humiditeMoy = (float)str_replace(' %', '', $dataJournalier['humidite']);
$ventMax = (float)str_replace(' km/h', '', $dataJournalier['vent']['vitesse_max']);

$tempClass = match (true) {
    $temperatureMoy < 0 => 'donut-cold',
    $temperatureMoy < 10 => 'donut-cool',
    $temperatureMoy < 20 => 'donut-mild',
    $temperatureMoy < 30 => 'donut-warm',
    default => 'donut-hot'
};
?>

<div class="donut-row">
    <!-- Donut Humidité -->
    <div class="svg-item">
        <?php 
        renderDonut(
            $humiditeMoy, 
            $dataJournalier['humidite'], 
            'Humidité', 
            'donut-humidity',
            10
        ); 
        ?>
    </div>

    <!-- Donut Température -->
    <div class="svg-item">
        <?php 
        renderDonut(
            $temperatureMoy, 
            $dataJournalier['temperatures']['moyenne'], 
            'Température', 
            $tempClass,
            8.5
        ); 
        ?>
    </div>

    <!-- Donut Vent -->
    <div class="svg-item">
        <?php 
        renderDonut(
            $ventMax, 
            $dataJournalier['vent']['vitesse_max'], 
            'Vitesse du vent', 
            'donut-wind',
            6.5
        ); 
        ?>
    </div>
</div>