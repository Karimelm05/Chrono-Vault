<?php
function h(string $value): string
{
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}

function liste_capsules_totales($Id_Utilisateurs)
{
    // Implementation for listing total capsules
    $stmt = $GLOBALS['pdo']->prepare("SELECT * FROM capsules WHERE Id_Utilisateurs = :Id_Utilisateurs");
    $stmt->execute(['Id_Utilisateurs' => $Id_Utilisateurs]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
    
}

function cv_count_user_created_capsules(int $userId): int
{
    if ($userId <= 0) {
        return 0;
    }

    $stmt = $GLOBALS['pdo']->prepare('SELECT COUNT(*) FROM capsule WHERE Id_Utilisateur = :user_id');
    $stmt->execute(['user_id' => $userId]);

    return (int)$stmt->fetchColumn();
}

function cv_count_user_member_capsules(int $userId): int
{
    if ($userId <= 0) {
        return 0;
    }

    $stmt = $GLOBALS['pdo']->prepare(
        'SELECT COUNT(DISTINCT c.Id_Capsule)
           FROM capsule c
           LEFT JOIN invitation inv ON inv.Id_Capsule = c.Id_Capsule AND inv.Id_Utilisateur = :user_id
          WHERE c.Id_Utilisateur = :user_id OR inv.Id_Utilisateur = :user_id'
    );
    $stmt->execute(['user_id' => $userId]);

    return (int)$stmt->fetchColumn();
}

function cv_count_user_open_capsules(int $userId): int
{
    if ($userId <= 0) {
        return 0;
    }

    $stmt = $GLOBALS['pdo']->prepare(
        'SELECT COUNT(DISTINCT c.Id_Capsule)
           FROM capsule c
           LEFT JOIN invitation inv ON inv.Id_Capsule = c.Id_Capsule AND inv.Id_Utilisateur = :user_id
          WHERE (c.Id_Utilisateur = :user_id OR inv.Id_Utilisateur = :user_id)
            AND (
                  c.statut_ouverture = 1
                  OR (c.date_ouverture IS NOT NULL AND c.date_ouverture <= NOW())
                )'
    );
    $stmt->execute(['user_id' => $userId]);

    return (int)$stmt->fetchColumn();
}

function cv_count_pending_notifications(int $userId): int
{
    if ($userId <= 0) {
        return 0;
    }

    $stmt = $GLOBALS['pdo']->prepare(
        'SELECT COUNT(*)
           FROM invitation
          WHERE Id_Utilisateur = :user_id
            AND LOWER(statut) = :statut'
    );
    $stmt->execute([
        'user_id' => $userId,
        'statut' => 'pending',
    ]);

    return (int)$stmt->fetchColumn();
}

function cv_get_pending_notifications(int $userId, int $limit = 5): array
{
    if ($userId <= 0 || $limit <= 0) {
        return [];
    }

    $stmt = $GLOBALS['pdo']->prepare(
        'SELECT i.Id_Invitation,
                i.Id_Capsule,
                i.date_envoi,
                c.titre AS capsule_titre,
                c.date_ouverture,
                creator.nom AS creator_nom
           FROM invitation i
           INNER JOIN capsule c ON c.Id_Capsule = i.Id_Capsule
           LEFT JOIN utilisateur creator ON creator.Id_Utilisateur = c.Id_Utilisateur
          WHERE i.Id_Utilisateur = :user_id
            AND LOWER(i.statut) = :statut
          ORDER BY i.date_envoi DESC, i.Id_Invitation DESC
          LIMIT :limit'
    );
    $stmt->bindValue(':user_id', $userId, PDO::PARAM_INT);
    $stmt->bindValue(':statut', 'pending', PDO::PARAM_STR);
    $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}