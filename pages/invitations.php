<?php
$pageTitle = 'Invitations | ChronoVault';
$activePage = 'invitations';
require_once __DIR__ . '/../includes/layout.php';
?>
<script>const sidebar = document.getElementById('sidebar');
    const toggleSidebar = document.getElementById('toggleSidebar');
    const search = document.getElementById('inviteSearch');
    const rows = Array.from(document.querySelectorAll('#inviteList .cv-list-item'));
    const filterButtons = document.querySelectorAll('[data-filter]');

    if (toggleSidebar && sidebar) {
      toggleSidebar.addEventListener('click', () => {
        sidebar.classList.toggle('is-open');
      });
    }

    let activeFilter = 'all';

    function refreshList() {
      const query = (search?.value || '').toLowerCase().trim();

      rows.forEach((row) => {
        const matchesFilter = activeFilter === 'all' || row.dataset.status === activeFilter;
        const matchesSearch = !query || row.dataset.search.includes(query);
        row.style.display = matchesFilter && matchesSearch ? '' : 'none';
      });
    }

    filterButtons.forEach((button) => {
      button.addEventListener('click', () => {
        activeFilter = button.dataset.filter;
        refreshList();
      });
    });

    search?.addEventListener('input', refreshList);

    document.getElementById('inviteList')?.addEventListener('click', (event) => {
      const button = event.target.closest('[data-action]');
      if (!button) {
        return;
      }

      const row = event.target.closest('.cv-list-item');
      if (!row) {
        return;
      }

      const action = button.dataset.action;

      if (action === 'accept') {
        row.dataset.status = 'accepted';
        row.innerHTML = `
          <div>
            <strong>Marie Dupont</strong>
            <div class="cv-muted">Capsule anniversaire · acceptée</div>
          </div>
          <div class="cv-actions">
            <span class="cv-pill accepted">Acceptée</span>
            <button class="cv-btn cv-btn-secondary" type="button" data-action="view">Voir</button>
          </div>
        `;
      }

      if (action === 'decline') {
        row.dataset.status = 'declined';
        row.innerHTML = `
          <div>
            <strong>Marie Dupont</strong>
            <div class="cv-muted">Capsule anniversaire · refusée</div>
          </div>
          <div class="cv-actions">
            <span class="cv-pill declined">Refusée</span>
            <button class="cv-btn cv-btn-secondary" type="button" data-action="resend">Renvoyer</button>
          </div>
        `;
      }

      if (action === 'resend') {
        alert('Invitation renvoyée');
      }

      if (action === 'view') {
        alert('Ouverture de la capsule associée');
      }

      refreshList();
    });

    document.getElementById('markAllRead')?.addEventListener('click', () => {
      alert('Invitations marquées comme lues');
    });

    refreshList();</script>
<header class="page-header">
  <div class="d-flex justify-content-between align-items-end flex-wrap gap-3 mb-4">
    <div>
      <div class="page-title-bar">
    <div class="title-accent"></div>
    <h2 class="page-title">Invitations</h2>
      </div>
      <p class="page-subtitle mb-0">Suivez les capsules partagées et les demandes de participation.</p>
    </div>
    <button class="btn-primary-cv" id="markAllRead" type="button">Tout marquer comme lu</button>
  </div>
</header>

<section class="cards-section">
  <div class="capsule-card" style="height:auto; min-height: 220px; margin-bottom: 1.5rem;">
    <div class="card-body-cv">
      <div class="d-flex flex-wrap gap-2 align-items-center mb-3">
        <input class="search-input" id="inviteSearch" type="search" placeholder="Rechercher un invité ou une capsule" style="max-width: 360px;">
        <button class="btn-filter" type="button" data-filter="all">Toutes</button>
        <button class="btn-filter" type="button" data-filter="pending">En attente</button>
        <button class="btn-filter" type="button" data-filter="accepted">Acceptées</button>
        <button class="btn-filter" type="button" data-filter="declined">Refusées</button>
      </div>

      <div class="d-flex flex-column gap-3" id="inviteList">
        <div class="d-flex justify-content-between align-items-center gap-3 pb-3 border-bottom" data-status="pending" data-search="marie dupont capsule anniversaire">
          <div>
            <strong>Marie Dupont</strong>
            <div class="card-desc mb-0" style="-webkit-line-clamp:1; line-clamp:1; margin-bottom:0;">Capsule anniversaire · reçue il y a 2 h</div>
          </div>
          <div class="d-flex flex-wrap justify-content-end gap-2 align-items-center">
            <span class="badge-cv badge-soon">En attente</span>
            <button class="btn-primary-cv" type="button" data-action="accept">Accepter</button>
            <button class="btn-filter" type="button" data-action="decline">Refuser</button>
          </div>
        </div>

        <div class="d-flex justify-content-between align-items-center gap-3 pb-3 border-bottom" data-status="accepted" data-search="lucas bernard capsule projet">
          <div>
            <strong>Lucas Bernard</strong>
            <div class="card-desc mb-0" style="-webkit-line-clamp:1; line-clamp:1; margin-bottom:0;">Capsule projet · accepté hier</div>
          </div>
          <div class="d-flex flex-wrap justify-content-end gap-2 align-items-center">
            <span class="badge-cv badge-sealed">Acceptée</span>
            <button class="btn-filter" type="button" data-action="view">Voir</button>
          </div>
        </div>

        <div class="d-flex justify-content-between align-items-center gap-3" data-status="declined" data-search="sara martin capsule souvenir">
          <div>
            <strong>Sara Martin</strong>
            <div class="card-desc mb-0" style="-webkit-line-clamp:1; line-clamp:1; margin-bottom:0;">Capsule souvenir · refusée</div>
          </div>
          <div class="d-flex flex-wrap justify-content-end gap-2 align-items-center">
            <span class="badge-cv badge-draft">Refusée</span>
            <button class="btn-filter" type="button" data-action="resend">Renvoyer</button>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="row g-4">
    <div class="col-12 col-lg-6">
      <div class="capsule-card" style="height:auto; min-height: 220px;">
        <div class="card-body-cv">
          <h3 class="card-title-cv">Résumé</h3>
          <div class="d-flex flex-column gap-3">
            <div class="d-flex justify-content-between align-items-center">
              <span class="card-desc mb-0" style="-webkit-line-clamp:1; line-clamp:1; margin-bottom:0;">En attente</span>
              <strong>3</strong>
            </div>
            <div class="d-flex justify-content-between align-items-center">
              <span class="card-desc mb-0" style="-webkit-line-clamp:1; line-clamp:1; margin-bottom:0;">Acceptées</span>
              <strong>5</strong>
            </div>
            <div class="d-flex justify-content-between align-items-center">
              <span class="card-desc mb-0" style="-webkit-line-clamp:1; line-clamp:1; margin-bottom:0;">Refusées</span>
              <strong>2</strong>
            </div>
          </div>
        </div>
      </div>
    </div>

    
  </div>
</section>
<?php require_once __DIR__ . '/../includes/footer.php'; ?>

