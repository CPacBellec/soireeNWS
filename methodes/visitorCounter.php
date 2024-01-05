<?php



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