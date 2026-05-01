<?php
require_once __DIR__ . '/../includes/app.php';
cv_require_login();

$user = cv_current_user();
$userId = (int)($user['id'] ?? 0);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    $invitationId = (int)($_POST['invitation_id'] ?? 0);

    if (in_array($action, ['accept', 'decline'], true)) {
        $status = $action === 'accept' ? 'accepted' : 'declined';
        $stmt = $pdo->prepare('UPDATE invitation SET statut = :status WHERE Id_Invitation = :invitation_id AND Id_Utilisateur = :user_id');
        $stmt->execute([
            ':status' => $status,
            ':invitation_id' => $invitationId,
            ':user_id' => $userId,
        ]);

        cv_flash_set('success', $status === 'accepted' ? 'Invitation acceptée.' : 'Invitation refusée.');
    }

    header('Location: invitations.php');
    exit();
}

$stmt = $pdo->prepare(
    'SELECT i.Id_Invitation, i.statut, i.date_envoi, i.Id_Capsule,
            c.titre, c.description, c.date_ouverture,
            u.nom AS owner_name
     FROM invitation i
     INNER JOIN capsule c ON c.Id_Capsule = i.Id_Capsule
     INNER JOIN utilisateur u ON u.Id_Utilisateur = c.Id_Utilisateur
     WHERE i.Id_Utilisateur = :user_id
     ORDER BY i.date_envoi DESC, i.Id_Invitation DESC'
);
$stmt->execute([':user_id' => $userId]);
$invitations = $stmt->fetchAll();

$counts = ['pending' => 0, 'accepted' => 0, 'declined' => 0];
foreach ($invitations as $invitation) {
    $status = (string)($invitation['statut'] ?? 'pending');
    if (!isset($counts[$status])) {
        $counts[$status] = 0;
    }
    $counts[$status]++;
}

require_once __DIR__ . '/../includes/layout.php';
$flash = cv_flash_get();
?>

<header class="page-header">
  <div class="d-flex justify-content-between align-items-end flex-wrap gap-3 mb-4">
    <div>
      <div class="page-title-bar">
        <div class="title-accent"></div>
        <h2 class="page-title">Invitations</h2>
      </div>
      <p class="page-subtitle mb-0">Suivez les capsules partagées et répondez aux invitations.</p>
    </div>
  </div>

  <?php if ($flash): ?>
    <div class="alert alert-<?php echo h($flash['type'] ?? 'info'); ?>" role="alert"><?php echo h($flash['message'] ?? ''); ?></div>
  <?php endif; ?>
</header>

<section class="cards-section">
  <div class="row g-4 mb-4">
    <div class="col-12 col-md-4">
      <div class="capsule-card" style="height:auto; min-height: 150px;">
        <div class="card-body-cv">
          <p class="card-category">En attente</p>
          <h3 class="card-title-cv stat-number"><?php echo (int)$counts['pending']; ?></h3>
        </div>
      </div>
    </div>
    <div class="col-12 col-md-4">
      <div class="capsule-card" style="height:auto; min-height: 150px;">
        <div class="card-body-cv">
          <p class="card-category">Acceptées</p>
          <h3 class="card-title-cv stat-number"><?php echo (int)$counts['accepted']; ?></h3>
        </div>
      </div>
    </div>
    <div class="col-12 col-md-4">
      <div class="capsule-card" style="height:auto; min-height: 150px;">
        <div class="card-body-cv">
          <p class="card-category">Refusées</p>
          <h3 class="card-title-cv stat-number"><?php echo (int)$counts['declined']; ?></h3>
        </div>
      </div>
    </div>
  </div>

  <div class="capsule-card" style="height:auto; min-height: 220px;">
    <div class="card-body-cv">
      <h3 class="card-title-cv mb-4">Boîte de réception</h3>

      <?php if (!$invitations): ?>
        <p class="card-desc mb-0">Aucune invitation pour le moment.</p>
      <?php else: ?>
        <div class="d-flex flex-column gap-3">
          <?php foreach ($invitations as $invitation): ?>
            <?php
              $status = (string)$invitation['statut'];
              $badgeClass = $status === 'accepted' ? 'badge-sealed' : ($status === 'declined' ? 'badge-draft' : 'badge-soon');
              $openDate = !empty($invitation['date_ouverture']) ? date('d/m/Y', strtotime((string)$invitation['date_ouverture'])) : 'Non définie';
            ?>
            <div class="d-flex justify-content-between align-items-center gap-3 pb-3 border-bottom flex-wrap">
              <div>
                <strong><?php echo h((string)$invitation['titre']); ?></strong>
                <div class="card-desc mb-0" style="-webkit-line-clamp:1; line-clamp:1; margin-bottom:0;">
                  Par <?php echo h((string)$invitation['owner_name']); ?> · ouverture <?php echo h($openDate); ?>
                </div>
              </div>

              <div class="d-flex flex-wrap justify-content-end gap-2 align-items-center">
                <span class="badge-cv <?php echo $badgeClass; ?>"><?php echo h(ucfirst($status)); ?></span>

                <?php if ($status === 'pending'): ?>
                  <form method="post" class="d-inline">
                    <input type="hidden" name="action" value="accept" />
                    <input type="hidden" name="invitation_id" value="<?php echo (int)$invitation['Id_Invitation']; ?>" />
                    <button class="btn-primary-cv" type="submit">Accepter</button>
                  </form>
                  <form method="post" class="d-inline">
                    <input type="hidden" name="action" value="decline" />
                    <input type="hidden" name="invitation_id" value="<?php echo (int)$invitation['Id_Invitation']; ?>" />
                    <button class="btn-filter" type="submit">Refuser</button>
                  </form>
                <?php endif; ?>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
      <?php endif; ?>
    </div>
  </div>
</section>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>