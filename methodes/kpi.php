<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once 'dbConnect.php';
require_once 'registration.php';
require_once 'visitorCounter.php';

$ipstackApiKey = '73ab2f3c4ed1b624935493a819b03d95';

$pdoManager = new DBManager('nwsnight');
$pdo = $pdoManager->getPDO();

$userRegistration = new UserRegistration($pdo);

$unconfirmedUsersCount = $userRegistration->getUnconfirmedUsersCount();

function getGeoLocation($ip, $apiKey)
{
    $url = "http://api.ipstack.com/$ip?access_key=$apiKey";
    $data = json_decode(file_get_contents($url), true);

    return $data;
}

$userIP = $_SERVER['REMOTE_ADDR'];

$geoLocation = getGeoLocation($userIP, $ipstackApiKey);

function getScrollPositions()
{
    $pdoManager = new DBManager('nwsnight');
    $pdo = $pdoManager->getPDO();

    // Sélectionnez les informations de défilement
    $stmt = $pdo->prepare("SELECT user_ip, scroll_position FROM scroll_tracking");
    $stmt->execute();

    // Récupérez toutes les lignes résultantes
    $scrollPositions = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return $scrollPositions;
}

// Obtenez les positions de défilement de la base de données
$scrollPositions = getScrollPositions();

function generateKPICard($title, $value)
{            echo '<div class="mb-6">';
            echo '<p class="text-lg">' . $title . ' : <span class="font-bold">' . $value . '</span></p>';
            echo '</div>';
}




function generateVisitorsCard($pdo)
{
    // Récupère la date actuelle
    $dateActuelle = date("Y-m-d");

    // Vérifie si une entrée pour la date actuelle existe déjà dans la base de données
    $stmt = $pdo->prepare("SELECT * FROM visitorcount WHERE date = :date");
    $stmt->bindParam(':date', $dateActuelle);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        // Met à jour le compteur s'il y a déjà une entrée pour la date actuelle
        $pdo->query("UPDATE visitorcount SET visitor_num = visitor_num + 1 WHERE date = '$dateActuelle'");
    } else {
        // Insère une nouvelle entrée pour la date actuelle si elle n'existe pas encore
        $stmt = $pdo->prepare("INSERT INTO visitorcount (date, visitor_num) VALUES (:date, 1)");
        $stmt->bindParam(':date', $dateActuelle);
        $stmt->execute();
    }

    // Récupère le nombre de visiteurs pour la date actuelle
    $stmt = $pdo->prepare("SELECT visitor_num FROM visitorcount WHERE date = :date");
    $stmt->bindParam(':date', $dateActuelle);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $nombreVisiteurs = $row['visitor_num'];

    // Affiche le nombre de visiteurs
    echo '<div class="mb-6">';
    echo '<p class="text-lg">Nombre de visiteurs aujourd\'hui : <span class="font-bold">' . $nombreVisiteurs . '</span></p>';
    echo '</div>';
}
// Ajoutez d'autres KPI ici

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Vos KPI</title>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center">
    <h1 class="text-2xl font-bold mb-4">Vos KPI</h1>

    <div class="bg-white p-8 rounded shadow-md max-w-md w-full">
        <?php
        // Utilisation de la fonction pour afficher le KPI
        generateKPICard("Nombre de personnes non confirmées", $unconfirmedUsersCount);


        // Ajoutez d'autres KPI ici en utilisant la fonction
        ?>
    </div>

    <div class="bg-white p-8 rounded shadow-md max-w-md w-full">
        <?php

        // Affichez les informations de localisation géographique
        generateKPICard("Pays", $geoLocation['country_name']);
        generateKPICard("Ville", $geoLocation['city']);
        generateKPICard("Région", $geoLocation['region_name']);
        generateKPICard("Code postal", $geoLocation['zip']);

        // Ajoutez d'autres KPI ici en utilisant la fonction
        ?>
    </div>

    <div class="bg-white p-8 rounded shadow-md max-w-md w-full">
        <?php 
            // Affichez les positions de défilement
            echo '<h2 class="text-xl font-bold mb-4">Positions de défilement</h2>';

            foreach ($scrollPositions as $position) {
                // Utilisez la fonction pour afficher chaque position de défilement
                generateKPICard("IP: " . $position['user_ip'], "Position: " . $position['scroll_position']);
            }
        ?>
    </div>

    <div class="bg-white p-8 rounded shadow-md max-w-md w-full">
        <?php 
        generateVisitorsCard($pdo);
        ?>
    </div>


</body>
</html>







