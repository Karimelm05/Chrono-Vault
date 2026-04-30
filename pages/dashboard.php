<?php
require_once __DIR__ . '/../config.php';
?>
<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Dashboard | ChronoVault</title>
  <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="../css/variables.css">
</head>
<body class="cv-shell">
  <div class="cv-layout">
    <aside class="cv-sidebar" id="sidebar">
      <div class="cv-brand">
        <div class="cv-brand-badge">CV</div>
        <div>
          <h1>ChronoVault</h1>
          <p>Member C</p>
        </div>
      </div>

      <nav class="cv-nav mb-4">
        <a class="active" href="dashboard.php">Dashboard <span>8</span></a>
        <a href="invitations.php">Invitations <span>3</span></a>
        <a href="capsules.html">Capsules <span>12</span></a>
        <a href="../index.php">Accueil <span>↗</span></a>
      </nav>

      <div class="cv-panel">
        <div class="cv-panel-inner">
          <p class="mb-1 fw-bold">Session active</p>
          <p class="mb-0 cv-muted">Admin demo, connecté</p>
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
          <span class="value">24</span>
          <span class="trend">+4 ce mois-ci</span>
        </article>
        <article class="cv-metric">
          <span class="label">Ouvertes</span>
          <span class="value">9</span>
          <span class="trend">+2 aujourd’hui</span>
        </article>
        <article class="cv-metric">
          <span class="label">Invitations</span>
          <span class="value">7</span>
          <span class="trend">3 en attente</span>
        </article>
        <article class="cv-metric">
          <span class="label">Activité</span>
          <span class="value">86%</span>
          <span class="trend">Stable</span>
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

