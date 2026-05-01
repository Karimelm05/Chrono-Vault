<?php
session_start();
$pageTitle = 'Invitations | ChronoVault';
$activePage = 'invitations';
require_once __DIR__ . '/../connexion.php';
require_once __DIR__ . '/../includes/layout.php'; 

function countInvitationsReceived(int $userId, PDO $pdo): int
{
    try {
        $stmt = $pdo->prepare("SELECT COUNT(*) AS total FROM invitation WHERE Id_Utilisateur = ?");
        $stmt->execute([$userId]);
        $r = $stmt->fetch();
        return (int)($r['total'] ?? 0);
    } catch (PDOException $e) {
        return 0;
    }
}

function countInvitationsAccepted(int $userId, PDO $pdo): int
{
    try {
        $stmt = $pdo->prepare("SELECT COUNT(*) AS total FROM invitation WHERE Id_Utilisateur = ? AND statut = 'accepted'");
        $stmt->execute([$userId]);
        $r = $stmt->fetch();
        return (int)($r['total'] ?? 0);
    } catch (PDOException $e) {
        return 0;
    }
}

function countInvitationsPending(int $userId, PDO $pdo): int
{
    try {
        $stmt = $pdo->prepare("SELECT COUNT(*) AS total FROM invitation WHERE Id_Utilisateur = ? AND statut = 'pending'");
        $stmt->execute([$userId]);
        $r = $stmt->fetch();
        return (int)($r['total'] ?? 0);
    } catch (PDOException $e) {
        return 0;
    }
}

function getUserInvitationsByStatus(int $userId, ?string $status, PDO $pdo): array
{
    try {
        if ($status === null) {
            $stmt = $pdo->prepare("
                SELECT i.*, c.titre AS capsule_titre
                FROM invitation i
                LEFT JOIN capsule c ON c.Id_Capsule = i.Id_Capsule
                WHERE i.Id_Utilisateur = ?
                ORDER BY i.date_envoi DESC
            ");
            $stmt->execute([$userId]);
        } else {
            $stmt = $pdo->prepare("
                SELECT i.*, c.titre AS capsule_titre
                FROM invitation i
                LEFT JOIN capsule c ON c.Id_Capsule = i.Id_Capsule
                WHERE i.Id_Utilisateur = ? AND i.statut = ?
                ORDER BY i.date_envoi DESC
            ");
            $stmt->execute([$userId, $status]);
        }
        return $stmt->fetchAll();
    } catch (PDOException $e) {
        return [];
    }
}

$userId = $_SESSION['user_id'] ?? null;
$totalInvitations = $userId ? countInvitationsReceived($userId, $pdo) : 0;
$totalAccepted = $userId ? countInvitationsAccepted($userId, $pdo) : 0;
$totalPending = $userId ? countInvitationsPending($userId, $pdo) : 0;

$invitationsAll     = $userId ? getUserInvitationsByStatus($userId, null, $pdo) : [];
$invitationsAccepted= $userId ? getUserInvitationsByStatus($userId, 'accepted', $pdo) : [];
$invitationsPending = $userId ? getUserInvitationsByStatus($userId, 'pending', $pdo) : [];

?>
<script>
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
  <div>
    <h5>En attente (<?= $totalPending ?>)</h5>
    <?php foreach ($invitationsPending as $inv): ?>
      <div class="d-flex justify-content-between align-items-center gap-3 pb-3 border-bottom cv-list-item"
           data-status="<?= h($inv['statut']) ?>" data-search="<?= strtolower(h($inv['capsule_titre'] ?? '')) ?>">
        <div>
          <strong><?= h($inv['capsule_titre'] ?? 'Capsule') ?></strong>
          <div class="card-desc mb-0"><?= h($inv['date_envoi'] ?? '') ?></div>
        </div>
        <div class="d-flex flex-wrap justify-content-end gap-2 align-items-center">
          <span class="badge-cv badge-soon">En attente</span>
          <button class="btn-primary-cv" type="button" data-action="accept">Accepter</button>
          <button class="btn-filter" type="button" data-action="decline">Refuser</button>
        </div>
      </div>
    <?php endforeach; ?>
  </div>

  <div>
    <h5>Acceptées (<?= $totalAccepted ?>)</h5>
    <?php foreach ($invitationsAccepted as $inv): ?>
      <div class="d-flex justify-content-between align-items-center gap-3 pb-3 border-bottom cv-list-item"
           data-status="<?= h($inv['statut']) ?>" data-search="<?= strtolower(h($inv['capsule_titre'] ?? '')) ?>">
        <div>
          <strong><?= h($inv['capsule_titre'] ?? 'Capsule') ?></strong>
          <div class="card-desc mb-0"><?= h($inv['date_envoi'] ?? '') ?></div>
        </div>
        <div class="d-flex flex-wrap justify-content-end gap-2 align-items-center">
          <span class="badge-cv badge-sealed">Acceptée</span>
          <button class="btn-filter" type="button" data-action="view">Voir</button>
        </div>
      </div>
    <?php endforeach; ?>
  </div>

  <div>
    <h5>Toutes les invitations (<?= $totalReceived ?>)</h5>
    <?php foreach ($invitationsAll as $inv): ?>
      <div class="d-flex justify-content-between align-items-center gap-3 pb-3 border-bottom cv-list-item"
           data-status="<?= h($inv['statut']) ?>" data-search="<?= strtolower(h($inv['capsule_titre'] ?? '')) ?>">
        <div>
          <strong><?= h($inv['capsule_titre'] ?? 'Capsule') ?></strong>
          <div class="card-desc mb-0"><?= h($inv['date_envoi'] ?? '') ?></div>
        </div>
        <div class="d-flex flex-wrap justify-content-end gap-2 align-items-center">
          <span class="badge-cv <?= $inv['statut'] === 'accepted' ? 'badge-sealed' : 'badge-soon' ?>">
            <?= h(ucfirst($inv['statut'] ?? '')) ?>
          </span>
          <?php if (($inv['statut'] ?? '') === 'pending'): ?>
            <button class="btn-primary-cv" type="button" data-action="accept">Accepter</button>
            <button class="btn-filter" type="button" data-action="decline">Refuser</button>
          <?php else: ?>
            <button class="btn-filter" type="button" data-action="view">Voir</button>
          <?php endif; ?>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
</div>
      
    </div>
  </div>

  
</section>
<?php require_once __DIR__ . '/../includes/footer.php'; ?>

