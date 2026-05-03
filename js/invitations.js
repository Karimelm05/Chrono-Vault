const sidebar = document.getElementById('sidebar');
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

    refreshList();