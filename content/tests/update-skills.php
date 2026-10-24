<?php

// 🖐️ ATTENTION : modifie les person en base de données.
// À n’utiliser qu’en cas de changement de règles sur les compétences

// Active les exceptions PDO pour intercepter les erreurs
//global $bdd;
$bdd->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

try {
    $bdd->beginTransaction();

    // 1. Récupération des données (attention aux backticks pour l'accent)
    $stmtSelect = $bdd->query("SELECT id, `Compétences` FROM persos");
    
    // 2. Préparation de la requête de mise à jour
    $stmtUpdate = $bdd->prepare("UPDATE persos SET `Compétences` = :competences WHERE id = :id");

    while ($row = $stmtSelect->fetch(\PDO::FETCH_ASSOC)) {
        if (empty($row['Compétences'])) {
            continue;
        }

        $competences = json_decode($row['Compétences'], true);

        if (!is_array($competences)) {
            continue;
        }

        foreach ($competences as &$comp) {
            // Sécurité : vérifie que la clé 'niv' existe
            if (!array_key_exists('niv', $comp)) {
                continue;
            }

            // Règle spécifique pour l'id 26
            if ($comp['id'] == 26) {
                if ($comp['niv'] <= -5) {
                    unset($comp['niv']);
                    continue; // Clé supprimée, on passe à la compétence suivante
                } elseif ($comp['niv'] >= -4) {
                    $comp['niv'] += 3;
                }
            }

            // Règle générale : plafond à 7 (s'applique aussi au +3 de l'id 26)
            if (isset($comp['niv']) && $comp['niv'] > 7) {
                $comp['niv'] = 7;
            }
        }
        unset($comp); // Casse la référence du foreach

        // 3. Mise à jour en base
        // JSON_UNESCAPED_UNICODE préserve les accents (ex: "Épée") sans les échapper en \uXXXX
        $jsonUpdated = json_encode($competences, JSON_UNESCAPED_UNICODE);
        
        $stmtUpdate->execute([
            ':competences' => $jsonUpdated,
            ':id'          => $row['id']
        ]);
    }

    $bdd->commit();
    echo "Mise à jour terminée avec succès.";

} catch (\Exception $e) {
    if ($bdd->inTransaction()) {
        $bdd->rollBack();
    }
    die("Erreur lors de la mise à jour : " . $e->getMessage());
}