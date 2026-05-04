<?php
require_once __DIR__ . '/../includes/app.php';
cv_require_login();

$user = cv_current_user();
$userId = (int)($user['id'] ?? 0);
$createdCapsulesCount = cv_count_user_created_capsules($userId);
$memberCapsulesCount = cv_count_user_member_capsules($userId);
$openCapsulesCount = cv_count_user_open_capsules($userId);
$pendingNotificationsCount = cv_count_pending_notifications($userId);
?>
<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Dashboard | ChronoVault</title>
  <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="../css/variables.css">
  <link rel="stylesheet" href="../css/style.css">
</head>
<body class="cv-shell">
  <div class="cv-layout">
    <aside class="cv-sidebar" id="sidebar">
      <div class="cv-brand">
        <div class="cv-brand-badge">CV</div>
        <div>
          <h1>ChronoVault</h1>
          <p><?php echo htmlspecialchars($user['name']); ?></p>
        </div>
      </div>

      <nav class="cv-nav mb-4">
        <a class="active" href="dashboard.php">Dashboard <span><?php echo (int)$memberCapsulesCount; ?></span></a>
        <a href="invitations.php">Invitations <span><?php echo (int)$pendingNotificationsCount; ?></span></a>
        <a href="capsules.php">Capsules <span><?php echo (int)$createdCapsulesCount; ?></span></a>
        <a href="../index.php">Accueil <span>↗</span></a>
      </nav>

      <div class="cv-panel">
        <div class="cv-panel-inner">
          <p class="mb-1 fw-bold">Session active</p>
          <p class="mb-2 cv-muted"><?php echo htmlspecialchars($user['name']); ?>, connecté</p>
          <a href="logout.php" class="btn btn-sm btn-outline-danger w-100">Déconnexion</a>
        </div>
      </div>
    </aside>

    <main class="cv-main">
      <div class="cv-topbar">
        <div>
          <h2 class="cv-title">Dashboard</h2>
          <p class="cv-subtitle">Vue d’ensemble des capsules, groupes et invitations.</p>
        </div>
        <div class="cv-actions">
          <button class="cv-btn cv-btn-secondary d-lg-none" id="toggleSidebar" type="button">Menu</button>
          <a class="cv-btn cv-btn-primary text-decoration-none" href="invitations.php">Voir les invitations</a>
        </div>
      </div>

      <section class="cv-metrics">
        <article class="cv-metric">
          <span class="label">Capsules totales</span>
          <span class="value"><?php echo (int)$createdCapsulesCount; ?></span>
          <span class="trend">Créées par vous</span>
        </article>
        <article class="cv-metric">
          <span class="label">Ouvertes</span>
          <span class="value"><?php echo (int)$openCapsulesCount; ?></span>
          <span class="trend">Accessibles maintenant</span>
        </article>
        <article class="cv-metric">
          <span class="label">Invitations</span>
          <span class="value"><?php echo (int)$pendingNotificationsCount; ?></span>
          <span class="trend">En attente de réponse</span>
        </article>
        <article class="cv-metric">
          <span class="label">Activité</span>
          <span class="value"><?php echo (int)$memberCapsulesCount; ?></span>
          <span class="trend">Capsules accessibles</span>
        </article>
      </section>

      <section class="cv-grid-2">
        <div class="cv-card">
          <div class="cv-card-header">
            <h3 class="cv-card-title">Capsules récentes</h3>
            <button class="cv-btn cv-btn-secondary" type="button">Filtrer</button>
          </div>
          <div class="cv-card-body">
            <div class="cv-list">
              <div class="cv-list-item">
                <div>
                  <strong>Cadeau anniversaire</strong>
                  <div class="cv-muted">Famille · ouverture dans 12 jours</div>
                </div>
                <span class="cv-pill pending">Verrouillée</span>
              </div>
              <div class="cv-list-item">
                <div>
                  <strong>Projet équipe</strong>
                  <div class="cv-muted">Travail · 2 pièces jointes</div>
                </div>
                <span class="cv-pill accepted">Ouverte</span>
              </div>
              <div class="cv-list-item">
                <div>
                  <strong>Capsule souvenir</strong>
                  <div class="cv-muted">Amis · 5 invités</div>
                </div>
                <span class="cv-pill pending">Programmée</span>
              </div>
            </div>
          </div>
        </div>

        <div class="cv-card">
          <div class="cv-card-header">
            <h3 class="cv-card-title">Invitations actives</h3>
            <a class="cv-link" href="invitations.php">Gérer</a>
          </div>
          <div class="cv-card-body">
            <div class="cv-list">
              <div class="cv-list-item">
                <div>
                  <strong>Marie Dupont</strong>
                  <div class="cv-muted">Invitée à 2 capsules</div>
                </div>
                <span class="cv-pill pending">Nouveau</span>
              </div>
              <div class="cv-list-item">
                <div>
                  <strong>Lucas Bernard</strong>
                  <div class="cv-muted">Réponse attendue</div>
                </div>
                <span class="cv-pill accepted">Accepté</span>
              </div>
            </div>
          </div>
        </div>
      </section>
    </main>
  </div>

  <script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="../js/dashboard.js"></script>
</body>
</html>

