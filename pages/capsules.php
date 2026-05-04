<?php
require_once __DIR__ . '/../includes/app.php';
cv_require_login();

$user = cv_current_user();
$userId = (int)($user['id'] ?? 0);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['action'] ?? '') === 'delete_capsule') {
    $capsuleId = (int)($_POST['capsule_id'] ?? 0);

    $stmt = $pdo->prepare('SELECT Id_Capsule FROM capsule WHERE Id_Capsule = :capsule_id AND Id_Utilisateur = :user_id LIMIT 1');
    $stmt->execute([':capsule_id' => $capsuleId, ':user_id' => $userId]);

    if ($stmt->fetch()) {
        $pdo->beginTransaction();
        try {
            $stmt = $pdo->prepare('DELETE FROM invitation WHERE Id_Capsule = :capsule_id');
            $stmt->execute([':capsule_id' => $capsuleId]);

            $stmt = $pdo->prepare('DELETE FROM souvenir WHERE Id_Capsule = :capsule_id');
            $stmt->execute([':capsule_id' => $capsuleId]);

            $stmt = $pdo->prepare('DELETE FROM capsule WHERE Id_Capsule = :capsule_id AND Id_Utilisateur = :user_id');
            $stmt->execute([':capsule_id' => $capsuleId, ':user_id' => $userId]);

            $pdo->commit();
            cv_flash_set('success', 'Capsule supprimée.');
        } catch (Throwable $e) {
            $pdo->rollBack();
            cv_flash_set('danger', 'Impossible de supprimer la capsule.');
        }
    }

    header('Location: capsules.php');
    exit();
}

$stmt = $pdo->prepare(
        'SELECT DISTINCT c.Id_Capsule, c.titre, c.description, c.date_creation, c.date_ouverture, c.Id_Utilisateur,
          (SELECT COUNT(*) FROM souvenir s WHERE s.Id_Capsule = c.Id_Capsule) AS souvenir_count,
          (SELECT COUNT(*) FROM invitation i WHERE i.Id_Capsule = c.Id_Capsule) AS invitation_count
         FROM capsule c
        LEFT JOIN invitation inv ON c.Id_Capsule = inv.Id_Capsule AND inv.Id_Utilisateur = ?
         WHERE c.Id_Utilisateur = ? OR inv.Id_Utilisateur = ?
         ORDER BY c.date_creation DESC, c.Id_Capsule DESC'
);
$stmt->execute([$userId, $userId, $userId]);
$capsules = $stmt->fetchAll();

require_once __DIR__ . '/../includes/layout.php';
$flash = cv_flash_get();
?>

<style>
  .filter-bar {
    background: var(--color-surface-container-low);
    border-radius: 0.75rem;
    padding: 1rem;
    display: flex;
    flex-wrap: wrap;
    gap: 0.75rem;
    align-items: center;
  }
  .search-wrapper {
    flex: 1;
    position: relative;
    min-width: 180px;
  }
  .search-wrapper .material-symbols-outlined {
    position: absolute;
    left: 1rem;
    top: 50%;
    transform: translateY(-50%);
    color: var(--color-on-surface-variant);
  }
  .search-input {
    width: 100%;
    background: var(--color-surface-container-highest);
    border: none;
    border-radius: 0.75rem;
    padding: 0.7rem 1rem 0.7rem 2.8rem;
    font-family: 'Plus Jakarta Sans', sans-serif;
    font-size: 0.875rem;
    color: var(--color-on-surface);
    outline: none;
    transition: box-shadow 0.2s;
  }
  .search-input::placeholder { color: var(--color-outline); }
  .search-input:focus { box-shadow: 0 0 0 2px rgba(108, 47, 0, 0.18); }
  .btn-filter.is-active {
    background: rgba(218, 194, 182, 0.45);
    color: var(--color-primary);
  }
  .capsule-card {
    background: var(--color-surface-container-low);
    border-radius: 0.75rem;
    overflow: hidden;
    height: 420px;
    display: flex;
    flex-direction: column;
    transition: box-shadow 0.3s, transform 0.3s;
  }
  .capsule-card:hover {
    box-shadow: 0 20px 40px rgba(28, 28, 23, 0.12);
    transform: translateY(-2px);
  }
  .capsule-card.draft {
    border: 2px dashed rgba(218, 194, 182, 0.5);
  }
  .card-img-wrapper {
    height: 192px;
    overflow: hidden;
    position: relative;
    flex-shrink: 0;
    background: linear-gradient(135deg, rgba(231, 196, 70, 0.22), rgba(108, 47, 0, 0.08));
  }
  .card-img-wrapper.muted {
    opacity: 0.7;
    background: linear-gradient(135deg, rgba(180, 171, 160, 0.28), rgba(108, 47, 0, 0.08));
  }
  .card-image-placeholder {
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--color-primary);
  }
  .card-image-placeholder .material-symbols-outlined {
    font-size: 48px;
  }
  .card-badges {
    position: absolute;
    top: 1rem;
    right: 1rem;
    display: flex;
    gap: 0.4rem;
    flex-wrap: wrap;
    justify-content: flex-end;
  }
  .badge-cv {
    padding: 0.25rem 0.7rem;
    border-radius: 9999px;
    font-size: 0.6rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.1em;
    box-shadow: 0 1px 4px rgba(0, 0, 0, 0.1);
  }
  .badge-sealed { background: var(--color-tertiary-fixed-dim); color: var(--color-on-tertiary-fixed); }
  .badge-soon { background: var(--color-secondary-container); color: var(--color-on-secondary-container); }
  .badge-draft { background: var(--color-surface-container-highest); color: var(--color-on-surface-variant); }
  .badge-shared { background: var(--color-secondary-container); color: var(--color-on-secondary-container); }
  .card-category {
    font-size: 0.6rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.12em;
    color: var(--color-secondary);
    margin-bottom: 0.25rem;
  }
  .card-category.muted { color: var(--color-outline); }
  .card-title-cv.muted-title { color: var(--color-on-surface-variant); }
  .card-desc {
    font-size: 0.82rem;
    color: var(--color-on-surface-variant);
    line-clamp: 2;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
    margin-bottom: 1.25rem;
  }
  .card-footer-cv {
    margin-top: auto;
    padding-top: 1rem;
    border-top: 1px solid rgba(218, 194, 182, 0.15);
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 0.75rem;
  }
  .card-footer-cv.no-border { border: none; }
  .open-label {
    font-size: 0.58rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.1em;
    color: var(--color-outline);
  }
  .open-value {
    font-size: 1.05rem;
    font-weight: 900;
    color: var(--color-tertiary-fixed-dim);
    line-height: 1.2;
  }
  .avatar-stack {
    display: flex;
    flex-direction: row-reverse;
  }
  .avatar-stack .avatar-count,
  .avatar-stack img,
  .avatar-solo {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    border: 2px solid var(--color-surface-container-low);
    object-fit: cover;
  }
  .avatar-stack .avatar-count {
    margin-left: -10px;
    background: var(--color-surface-container-highest);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.6rem;
    font-weight: 700;
    color: var(--color-on-surface-variant);
  }
  .avatar-stack img { margin-left: -10px; }
  .avatar-solo {
    background: var(--color-surface-container-highest);
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
  }
  .btn-continue {
    flex: 1;
    padding: 0.5rem;
    background: rgba(218, 194, 182, 0.2);
    border: none;
    border-radius: 0.5rem;
    font-family: 'Plus Jakarta Sans', sans-serif;
    font-size: 0.8rem;
    font-weight: 700;
    color: var(--color-on-surface);
    cursor: pointer;
    transition: background 0.15s;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    justify-content: center;
  }
  .btn-continue:hover { background: rgba(218, 194, 182, 0.45); }
  .btn-delete {
    width: 38px;
    height: 38px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border: none;
    background: transparent;
    border-radius: 0.5rem;
    cursor: pointer;
    color: var(--color-on-surface-variant);
    transition: background 0.15s, color 0.15s;
    text-decoration: none;
  }
  .btn-delete:hover {
    background: var(--color-error-container);
    color: var(--color-error);
  }
  .page-footer {
    position: fixed;
    bottom: 0;
    left: 248px;
    right: 0;
    border-top: 1px solid rgba(218, 194, 182, 0.25);
    background: #faf7f2;
    z-index: 40;
    padding: 1rem 1.5rem;
    display: flex;
    justify-content: space-between;
    align-items: center;
  }
  .footer-copy, .footer-links a {
    font-size: 0.65rem;
    text-transform: uppercase;
    letter-spacing: 0.1em;
    color: #a8a29e;
    text-decoration: none;
  }
  .footer-links { display: flex; gap: 2rem; }
  .footer-links a:hover { color: #92400e; }
</style>

<header class="page-header">
  <div class="d-flex justify-content-between align-items-end flex-wrap gap-3 mb-4">
    <div>
      <div class="page-title-bar">
        <div class="title-accent"></div>
        <h2 class="page-title">Mes Capsules</h2>
      </div>
      <p class="page-subtitle mb-0">Gérez vos souvenirs et vos messages pour le futur.</p>
    </div>
    <a class="btn-primary-cv text-decoration-none" href="new-capsule.php">Nouvelle capsule</a>
  </div>

  <div class="filter-bar mb-4">
    <div class="search-wrapper">
      <span class="material-symbols-outlined">search</span>
      <input class="search-input" id="capsuleSearch" type="search" placeholder="Rechercher une capsule..." />
    </div>
    <div class="d-flex gap-2 flex-wrap">
      <button class="btn-filter is-active" type="button" data-filter="all">
        <span class="material-symbols-outlined" style="font-size:16px">filter_list</span>
        Filtres
      </button>
      <button class="btn-filter" type="button" data-filter="open">
        <span class="material-symbols-outlined" style="font-size:16px">lock_open</span>
        Ouvertes
      </button>
      <button class="btn-filter" type="button" data-filter="locked">
        <span class="material-symbols-outlined" style="font-size:16px">lock</span>
        Verrouillées
      </button>
      <button class="btn-filter" type="button" data-filter="shared">
        <span class="material-symbols-outlined" style="font-size:16px">sort</span>
        Trier par
      </button>
    </div>
  </div>

  <?php if ($flash): ?>
    <div class="alert alert-<?php echo h($flash['type'] ?? 'info'); ?>" role="alert"><?php echo h($flash['message'] ?? ''); ?></div>
  <?php endif; ?>
</header>

<section class="cards-section">
  <?php if (!$capsules): ?>
    <div class="capsule-card" style="height:auto; min-height: 180px;">
      <div class="card-body-cv d-flex align-items-center justify-content-center text-center">
        <div>
          <h3 class="card-title-cv">Aucune capsule pour le moment</h3>
          <p class="card-desc mb-4">Créez votre première capsule pour commencer à stocker vos souvenirs.</p>
          <a class="btn-primary-cv text-decoration-none" href="new-capsule.php">Créer une capsule</a>
        </div>
      </div>
    </div>
  <?php else: ?>
    <div class="row g-4">
      <?php foreach ($capsules as $capsule): ?>
        <?php
          $isOpen = !empty($capsule['date_ouverture']) && strtotime((string)$capsule['date_ouverture']) <= time();
          $isOwner = (int)$capsule['Id_Utilisateur'] === $userId;
          $isShared = !$isOwner && (int)$capsule['invitation_count'] > 0;
          $isDraft = empty($capsule['date_ouverture']);
          $openDate = !empty($capsule['date_ouverture']) ? date('d/m/Y', strtotime((string)$capsule['date_ouverture'])) : 'Non définie';
          $stateFilter = $isShared ? 'shared' : ($isOpen ? 'open' : 'locked');
        ?>
        <div class="col-12 col-md-6 col-lg-4 capsule-item" data-filter="<?php echo h($stateFilter); ?>" data-search="<?php echo h(strtolower((string)$capsule['titre'] . ' ' . (string)($capsule['description'] ?: '') . ' ' . (string)$capsule['invitation_count'])); ?>">
          <div class="capsule-card<?php echo $isDraft ? ' draft' : ''; ?>" style="height:auto; min-height: 280px;">
            <div class="card-body-cv d-flex flex-column">
              <div class="card-img-wrapper<?php echo $isDraft ? ' muted' : ''; ?> mb-3">
                <div class="card-image-placeholder" aria-hidden="true">
                  <span class="material-symbols-outlined"><?php echo $isOpen ? 'unlock' : ($isDraft ? 'draft' : 'lock'); ?></span>
                </div>
                <div class="card-badges">
                  <span class="badge-cv <?php echo $isOpen ? 'badge-sealed' : ($isDraft ? 'badge-draft' : 'badge-soon'); ?>">
                    <?php echo $isOpen ? 'Accessible' : ($isDraft ? 'Brouillon' : 'En attente'); ?>
                  </span>
                  <?php if ($isShared): ?>
                    <span class="badge-cv badge-shared">Partagée</span>
                  <?php endif; ?>
                </div>
              </div>

              <div class="d-flex justify-content-between align-items-center gap-2 mb-2">
                <p class="card-category mb-0<?php echo $isDraft ? ' muted' : ''; ?>"><?php echo $isShared ? 'Amis proches' : 'Capsule temporelle'; ?></p>
                <span class="card-category mb-0<?php echo $isDraft ? ' muted' : ''; ?>"><?php echo $isOpen ? 'Ouverte' : 'Verrouillée'; ?></span>
              </div>

              <h3 class="card-title-cv<?php echo $isDraft ? ' muted-title' : ''; ?>"><?php echo h((string)$capsule['titre']); ?></h3>
              <p class="card-desc"><?php echo h((string)($capsule['description'] ?: 'Aucune description')); ?></p>

              <div class="mb-3">
                <div class="open-label"><?php echo $isOpen ? 'Ouverte depuis' : 'Date d\'ouverture'; ?></div>
                <div class="open-value"><?php echo h($openDate); ?></div>
              </div>

              <div class="card-footer-cv<?php echo $isDraft ? ' no-border' : ''; ?>">
                <div>
                  <div class="open-label">Souvenirs</div>
                  <div class="open-value"><?php echo (int)$capsule['souvenir_count']; ?></div>
                </div>
                <?php if ($isShared): ?>
                  <div class="avatar-stack" aria-label="Capsule partagée">
                    <div class="avatar-count">+<?php echo max(1, (int)$capsule['invitation_count']); ?></div>
                    <div class="avatar-solo">
                      <span class="material-symbols-outlined" style="font-size:14px">group</span>
                    </div>
                  </div>
                <?php else: ?>
                  <div class="avatar-solo" aria-label="Capsule personnelle">
                    <span class="material-symbols-outlined" style="font-size:14px">person</span>
                  </div>
                <?php endif; ?>
              </div>

              <div class="d-flex justify-content-between align-items-center mt-3 gap-2">
                <a class="btn-continue text-decoration-none" href="capsule.php?id=<?php echo (int)$capsule['Id_Capsule']; ?>">Ouvrir</a>
                <?php if ($isOwner): ?>
                  <form method="post" onsubmit="return confirm('Supprimer cette capsule ?');">
                    <input type="hidden" name="action" value="delete_capsule" />
                    <input type="hidden" name="capsule_id" value="<?php echo (int)$capsule['Id_Capsule']; ?>" />
                    <button type="submit" class="btn-delete" aria-label="Supprimer la capsule">
                      <span class="material-symbols-outlined" style="font-size:16px">delete</span>
                    </button>
                  </form>
                <?php endif; ?>
              </div>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  <?php endif; ?>
</section>

<footer class="page-footer">
  <p class="footer-copy mb-0">© <?php echo date('Y'); ?> ChronoVault, tous droits réservés.</p>
  <div class="footer-links">
    <a href="#">Mentions Légales</a>
    <a href="#">Confidentialité</a>
    <a href="#">Contact</a>
  </div>
</footer>

<script>
  (function () {
    const searchInput = document.getElementById('capsuleSearch');
    const filterButtons = document.querySelectorAll('.btn-filter[data-filter]');
    const cards = Array.from(document.querySelectorAll('.capsule-item'));

    if (!searchInput || !cards.length) {
      return;
    }

    let activeFilter = 'all';

    const refreshCards = () => {
      const query = searchInput.value.toLowerCase().trim();

      cards.forEach((card) => {
        const matchesFilter = activeFilter === 'all' || card.dataset.filter === activeFilter;
        const matchesSearch = !query || (card.dataset.search || '').includes(query);
        card.style.display = matchesFilter && matchesSearch ? '' : 'none';
      });
    };

    filterButtons.forEach((button) => {
      button.addEventListener('click', () => {
        activeFilter = button.dataset.filter;

        filterButtons.forEach((candidate) => candidate.classList.remove('is-active'));
        button.classList.add('is-active');

        refreshCards();
      });
    });

    searchInput.addEventListener('input', refreshCards);
    refreshCards();
  }());
</script>