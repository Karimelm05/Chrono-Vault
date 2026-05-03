<?php
require_once __DIR__ . '/../config.php';
?>
<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Invitations | ChronoVault</title>
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
          <p>Invitations</p>
        </div>
      </div>

      <nav class="cv-nav mb-4">
        <a href="dashboard.php">Dashboard <span>8</span></a>
        <a class="active" href="invitations.php">Invitations <span>3</span></a>
        <a href="capsules.html">Capsules <span>12</span></a>
        <a href="../index.php">Accueil <span>↗</span></a>
      </nav>

      <div class="cv-panel">
        <div class="cv-panel-inner">
          <p class="mb-1 fw-bold">Suivi rapide</p>
          <p class="mb-0 cv-muted">Répondre, relancer et archiver les demandes.</p>
        </div>
      </div>
    </aside>

    <main class="cv-main">
      <div class="cv-topbar">
        <div>
          <h2 class="cv-title">Invitations</h2>
          <p class="cv-subtitle">Répondre, relancer et suivre les invitations en attente.</p>
        </div>
        <div class="cv-actions">
          <button class="cv-btn cv-btn-secondary d-lg-none" id="toggleSidebar" type="button">Menu</button>
          <button class="cv-btn cv-btn-primary" id="markAllRead" type="button">Tout marquer comme lu</button>
        </div>
      </div>

      <section class="cv-card mb-3">
        <div class="cv-card-body">
          <div class="cv-toolbar">
            <input class="cv-input" id="inviteSearch" type="search" placeholder="Rechercher un invité ou une capsule">
            <button class="cv-btn cv-btn-secondary" type="button" data-filter="all">Toutes</button>
            <button class="cv-btn cv-btn-secondary" type="button" data-filter="pending">En attente</button>
            <button class="cv-btn cv-btn-secondary" type="button" data-filter="accepted">Acceptées</button>
            <button class="cv-btn cv-btn-secondary" type="button" data-filter="declined">Refusées</button>
          </div>

          <div class="cv-list" id="inviteList">
            <div class="cv-list-item" data-status="pending" data-search="marie dupont capsule anniversaire">
              <div>
                <strong>Marie Dupont</strong>
                <div class="cv-muted">Capsule anniversaire · reçue il y a 2 h</div>
              </div>
              <div class="cv-actions">
                <span class="cv-pill pending">En attente</span>
                <button class="cv-btn cv-btn-primary" type="button" data-action="accept">Accepter</button>
                <button class="cv-btn cv-btn-danger" type="button" data-action="decline">Refuser</button>
              </div>
            </div>

            <div class="cv-list-item" data-status="accepted" data-search="lucas bernard capsule projet">
              <div>
                <strong>Lucas Bernard</strong>
                <div class="cv-muted">Capsule projet · accepté hier</div>
              </div>
              <div class="cv-actions">
                <span class="cv-pill accepted">Acceptée</span>
                <button class="cv-btn cv-btn-secondary" type="button" data-action="view">Voir</button>
              </div>
            </div>

            <div class="cv-list-item" data-status="declined" data-search="sara martin capsule souvenir">
              <div>
                <strong>Sara Martin</strong>
                <div class="cv-muted">Capsule souvenir · refusée</div>
              </div>
              <div class="cv-actions">
                <span class="cv-pill declined">Refusée</span>
                <button class="cv-btn cv-btn-secondary" type="button" data-action="resend">Renvoyer</button>
              </div>
            </div>
          </div>
        </div>
      </section>

      <section class="cv-grid-2">
        <div class="cv-card">
          <div class="cv-card-header">
            <h3 class="cv-card-title">Résumé</h3>
          </div>
          <div class="cv-card-body">
            <div class="cv-list">
              <div class="cv-list-item">
                <span>En attente</span>
                <strong>3</strong>
              </div>
              <div class="cv-list-item">
                <span>Acceptées</span>
                <strong>5</strong>
              </div>
              <div class="cv-list-item">
                <span>Refusées</span>
                <strong>2</strong>
              </div>
            </div>
          </div>
        </div>

        <div class="cv-card">
          <div class="cv-card-header">
            <h3 class="cv-card-title">Actions rapides</h3>
          </div>
          <div class="cv-card-body">
            <div class="cv-actions">
              <a class="cv-btn cv-btn-primary text-decoration-none" href="dashboard.php">Retour dashboard</a>
              <a class="cv-btn cv-btn-secondary text-decoration-none" href="capsules.html">Aller aux capsules</a>
            </div>
          </div>
        </div>
      </section>
    </main>
  </div>

  <script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="../js/invitations.js"></script>
</body>
</html>

