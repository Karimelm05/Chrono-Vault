<?php
$pageTitle = 'Dashboard | ChronoVault';
$activePage = 'dashboard';
require_once __DIR__ . '/../includes/layout.php';
?>
<script>    const sidebar = document.getElementById('sidebar');
    const toggleSidebar = document.getElementById('toggleSidebar');

    if (toggleSidebar && sidebar) {
      toggleSidebar.addEventListener('click', () => {
        sidebar.classList.toggle('is-open');
      });
    }
    </script>
<header class="page-header">
  <div class="d-flex justify-content-between align-items-end flex-wrap gap-3 mb-4">
    <div>
      <div class="page-title-bar">
        <div class="title-accent"></div>
        <h2 class="page-title">Dashboard</h2>
      </div>
      <p class="page-subtitle mb-0">Vue d’ensemble des capsules, groupes et invitations.</p>
    </div>
    <a class="btn-primary-cv text-decoration-none" href="invitations.php">Voir les invitations</a>
  </div>
</header>

<section class="cards-section">
  <div class="row g-4 mb-4">
    <div class="col-12 col-md-6 col-lg-3">
      <div class="capsule-card" style="height:auto; min-height: 170px;">
        <div class="card-body-cv">
          <p class="card-category">Capsules totales</p>
          <h3 class="card-title-cv stat-number">24</h3>
          <p class="card-desc">+4 ce mois-ci</p>
        </div>
      </div>
    </div>
    <div class="col-12 col-md-6 col-lg-3">
      <div class="capsule-card" style="height:auto; min-height: 170px;">
        <div class="card-body-cv">
          <p class="card-category">Ouvertes</p>
          <h3 class="card-title-cv stat-number">9</h3>
          <p class="card-desc">+2 aujourd’hui</p>
        </div>
      </div>
    </div>
    <div class="col-12 col-md-6 col-lg-3">
      <div class="capsule-card" style="height:auto; min-height: 170px;">
        <div class="card-body-cv">
          <p class="card-category">Invitations</p>
          <h3 class="card-title-cv stat-number">7</h3>
          <p class="card-desc">3 en attente</p>
        </div>
      </div>
    </div>
    <div class="col-12 col-md-6 col-lg-3">
      <div class="capsule-card" style="height:auto; min-height: 170px;">
        <div class="card-body-cv">
          <p class="card-category">Activité</p>
          <h3 class="card-title-cv stat-number">86%</h3>
          <p class="card-desc">Stable</p>
        </div>
      </div>
    </div>
  </div>

  <div class="row g-4">
    <div class="col-12 col-lg-6">
      <div class="capsule-card" style="height:auto; min-height: 320px;">
        <div class="card-body-cv">
          <div class="d-flex justify-content-between align-items-center gap-3 mb-3">
            <h3 class="card-title-cv mb-0">Capsules récentes</h3>
            <button class="btn-filter" type="button">Filtrer</button>
          </div>

          <div class="d-flex flex-column gap-3">
            <div class="d-flex justify-content-between align-items-center gap-3 pb-3 border-bottom">
              <div>
                <strong>Cadeau anniversaire</strong>
                <div class="card-desc mb-0" style="-webkit-line-clamp:1; line-clamp:1; margin-bottom:0;">Famille · ouverture dans 12 jours</div>
              </div>
              <span class="badge-cv badge-soon">Verrouillée</span>
            </div>
            <div class="d-flex justify-content-between align-items-center gap-3 pb-3 border-bottom">
              <div>
                <strong>Projet équipe</strong>
                <div class="card-desc mb-0" style="-webkit-line-clamp:1; line-clamp:1; margin-bottom:0;">Travail · 2 pièces jointes</div>
              </div>
              <span class="badge-cv badge-sealed">Ouverte</span>
            </div>
            <div class="d-flex justify-content-between align-items-center gap-3">
              <div>
                <strong>Capsule souvenir</strong>
                <div class="card-desc mb-0" style="-webkit-line-clamp:1; line-clamp:1; margin-bottom:0;">Amis · 5 invités</div>
              </div>
              <span class="badge-cv badge-draft">Programmée</span>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="col-12 col-lg-6">
      <div class="capsule-card" style="height:auto; min-height: 320px;">
        <div class="card-body-cv">
          <div class="d-flex justify-content-between align-items-center gap-3 mb-3">
            <h3 class="card-title-cv mb-0">Invitations actives</h3>
            <a class="btn btn-link p-0 text-decoration-none" href="invitations.php" style="color: var(--color-primary); font-weight: 700;">Gérer</a>
          </div>

          <div class="d-flex flex-column gap-3">
            <div class="d-flex justify-content-between align-items-center gap-3 pb-3 border-bottom">
              <div>
                <strong>Marie Dupont</strong>
                <div class="card-desc mb-0" style="-webkit-line-clamp:1; line-clamp:1; margin-bottom:0;">Invitée à 2 capsules</div>
              </div>
              <span class="badge-cv badge-soon">Nouveau</span>
            </div>
            <div class="d-flex justify-content-between align-items-center gap-3">
              <div>
                <strong>Lucas Bernard</strong>
                <div class="card-desc mb-0" style="-webkit-line-clamp:1; line-clamp:1; margin-bottom:0;">Réponse attendue</div>
              </div>
              <span class="badge-cv badge-sealed">Accepté</span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>

