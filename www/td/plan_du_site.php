<?php 
$title = "Plan du Site";
$description = "Voici le plan de notre site avec les liens vers les différentes pages.";

require "include/header.inc.php";
?>
<main>
    <h1>Plan du Site</h1>
    <ul style="list-style-type: none; padding: 0;">
        <li><a href="index.php" style="text-decoration: none; color: #333; transition: color 0.3s;" onmouseover="this.style.color='#8f8f8f'" onmouseout="this.style.color='#333'">Page d'accueil</a></li>
        <li><a href="td5.php" style="text-decoration: none; color: #333; transition: color 0.3s;" onmouseover="this.style.color='#8f8f8f'" onmouseout="this.style.color='#333'">TD5</a></li>
        <li><a href="td6.php" style="text-decoration: none; color: #333; transition: color 0.3s;" onmouseover="this.style.color='#8f8f8f'" onmouseout="this.style.color='#333'">TD6</a></li>
        <li><a href="td7.php" style="text-decoration: none; color: #333; transition: color 0.3s;" onmouseover="this.style.color='#8f8f8f'" onmouseout="this.style.color='#333'">TD7</a></li>
        <li><a href="td8.php" style="text-decoration: none; color: #333; transition: color 0.3s;" onmouseover="this.style.color='#8f8f8f'" onmouseout="this.style.color='#333'">TD8</a></li>
    </ul>

<?php require "include/footer.inc.php"; ?>