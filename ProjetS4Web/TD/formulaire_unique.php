<?php
 require './include/header.inc.php'; 
?>

<h1>Formulaire et traitement sur la même page</h1>

<form method="get">
  <label for="texte">Texte (minuscules) :</label>
  <input type="text" name="texte" id="texte" required><br><br>

  <label for="decimal">Nombre décimal :</label>
  <input type="number" name="decimal" id="decimal" required><br><br>

  <button type="submit">Envoyer</button>
</form>

<?php
if (isset($_GET['texte']) && isset($_GET['decimal'])) {
    $texte = strtoupper($_GET['texte']);
    $decimal = (int)$_GET['decimal'];
    $hex = strtoupper(dechex($decimal));

    echo "<h2>Résultats :</h2>";
    echo "<p>Texte en majuscules : <strong>$texte</strong></p>";
    echo "<p>Hexadécimal : <strong>$hex</strong></p>";
}
?>

<?php 
	require './include/footer.inc.php'; 
?>