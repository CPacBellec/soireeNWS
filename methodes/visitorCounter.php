<?php

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
    $result = $pdo->query("SELECT visitor_num FROM visitorcount WHERE date = '$dateActuelle'");
    $row = $result->fetch(PDO::FETCH_ASSOC);
    $nombreVisiteurs = $row['visitor_num'];

    // Met à jour la variable de session avec le nombre de visiteurs
    $_SESSION['nombreVisiteursQuotidiens'] = $nombreVisiteurs;

    // Affiche le nombre de visiteurs dans la card KPI (si nécessaire)
    echo '<div class="mb-6">';
    echo '<p class="text-lg">Nombre de visiteurs aujourd\'hui : <span class="font-bold">' . $nombreVisiteurs . '</span></p>';
    echo '</div>';
}

function getVisitorsCount($pdo)
{
    // Récupère le nombre de visiteurs pour la date actuelle
    $dateActuelle = date("Y-m-d");
    $result = $pdo->query("SELECT visitor_num FROM visitorcount WHERE date = '$dateActuelle'");
    $row = $result->fetch(PDO::FETCH_ASSOC);

    return $row['visitor_num'];
}

/*function mettreAJourCompteurQuotidien($pdo) {
    // Récupérez la date d'aujourd'hui
    $aujourdHui = date('Y-m-d');

    // Vérifiez si l'utilisateur a déjà visité aujourd'hui
    if (!isset($_COOKIE['visited_today'])) {
        setcookie('visited_today', true, strtotime('tomorrow'));

        // Recherchez s'il y a déjà une entrée pour aujourd'hui dans la base de données
        $stmt = $pdo->prepare("SELECT * FROM visitorcount WHERE date = :aujourdHui");
        $stmt->bindParam(':aujourdHui', $aujourdHui);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            // Si une entrée existe, mettez à jour le compteur existant
            $updateStmt = $pdo->prepare("UPDATE visitorcount SET visitor_num = visitor_num + 1 WHERE date = :aujourdHui");
            $updateStmt->bindParam(':aujourdHui', $aujourdHui);
            $updateStmt->execute();
        } else {
            // Sinon, ajoutez une nouvelle entrée pour aujourd'hui
            $insertStmt = $pdo->prepare("INSERT INTO visitorcount (date, visitor_num) VALUES (:aujourdHui, 1)");
            $insertStmt->bindParam(':aujourdHui', $aujourdHui);
            $insertStmt->execute();
        }
    }

    // Retournez le nombre total de visiteurs aujourd'hui
    $stmt = $pdo->prepare("SELECT visitor_num FROM visitorcount WHERE date = :aujourdHui");
    $stmt->bindParam(':aujourdHui', $aujourdHui);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result['visitor_num'];
}*/

/*function mettreAJourCompteurQuotidien($pdo) {
    $aujourdHui = date('Y-m-d');

    if (!isset($_COOKIE['visited_today'])) {
        setcookie('visited_today', true, strtotime('tomorrow'));

        $stmt = $pdo->prepare("SELECT * FROM visitorcount WHERE date = :aujourdHui");
        $stmt->bindParam(':aujourdHui', $aujourdHui);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
        } else {
            $insertStmt = $pdo->prepare("INSERT INTO visitorcount (date, visitor_num) VALUES (:aujourdHui, 1)");
            $insertStmt->bindParam(':aujourdHui', $aujourdHui);
            $insertStmt->execute();
        }
    }
    
}*/

/*function getVisitorCountToday($pdo) {
    $aujourdHui = date('Y-m-d');
    $stmt = $pdo->prepare("SELECT visitor_num FROM visitorcount WHERE date = :aujourdHui");
    $stmt->bindParam(':aujourdHui', $aujourdHui);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['visitor_num'];
    } else {
        // Si aucune entrée pour aujourd'hui n'est trouvée, retournez 0 ou tout autre valeur par défaut
        return 0;
    }
}*/