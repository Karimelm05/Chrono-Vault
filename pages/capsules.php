<?php
require_once __DIR__ . '/../includes/app.php';
cv_require_login();

$pageTitle = 'Capsules';
$activePage = 'capsules';
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
$flash = cv_flash_get();

include __DIR__ . '/../includes/app-layout.php';
?>

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

<?php include __DIR__ . '/../includes/app-layout-footer.php'; ?>