<?php
require_once __DIR__ . '/../includes/app.php';
cv_require_login();

$user = cv_current_user();
$userId = (int)($user['id'] ?? 0);
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $openDate = trim($_POST['open_date'] ?? '');
    $inviteEmailsRaw = trim($_POST['invite_emails'] ?? '');

    if ($title === '') {
        $errors[] = 'Le titre est obligatoire.';
    }

    if ($openDate === '') {
        $errors[] = 'La date d’ouverture est obligatoire.';
    }

    if (!$errors) {
        $pdo->beginTransaction();

        try {
            $stmt = $pdo->prepare('INSERT INTO capsule (titre, description, date_creation, date_ouverture, Id_Utilisateur) VALUES (:titre, :description, :date_creation, :date_ouverture, :user_id)');
            $stmt->execute([
                ':titre' => $title,
                ':description' => $description !== '' ? $description : null,
                ':date_creation' => cv_now(),
                ':date_ouverture' => $openDate . ' 00:00:00',
                ':user_id' => $userId,
            ]);

            $capsuleId = (int)$pdo->lastInsertId();
            $now = cv_now();
            $inviteEmails = preg_split('/[\r\n,;]+/', $inviteEmailsRaw) ?: [];
            $inviteEmails = array_values(array_filter(array_map('trim', $inviteEmails)));

            $userLookup = $pdo->prepare('SELECT Id_Utilisateur FROM utilisateur WHERE email = :email LIMIT 1');
            $inviteInsert = $pdo->prepare('INSERT INTO invitation (statut, date_envoi, Id_Capsule, Id_Utilisateur) VALUES (:statut, :date_envoi, :capsule_id, :user_id)');

            $missingEmails = [];
            foreach ($inviteEmails as $email) {
                $userLookup->execute([':email' => $email]);
                $invitee = $userLookup->fetch();

                if (!$invitee) {
                    $missingEmails[] = $email;
                    continue;
                }

                $inviteInsert->execute([
                    ':statut' => 'pending',
                    ':date_envoi' => $now,
                    ':capsule_id' => $capsuleId,
                    ':user_id' => (int)$invitee['Id_Utilisateur'],
                ]);
            }

            $pdo->commit();

            if ($missingEmails) {
                cv_flash_set('warning', 'Capsule créée. Certains emails n’existent pas: ' . implode(', ', $missingEmails));
            } else {
                cv_flash_set('success', 'Capsule créée avec succès.');
            }

            header('Location: capsule.php?id=' . $capsuleId);
            exit();
        } catch (Throwable $e) {
            $pdo->rollBack();
            $errors[] = 'Impossible de créer la capsule.';
        }
    }
}

require_once __DIR__ . '/../includes/layout.php';
$flash = cv_flash_get();
?>

<header class="page-header">
  <div class="d-flex justify-content-between align-items-end flex-wrap gap-3 mb-4">
    <div>
      <div class="page-title-bar">
        <div class="title-accent"></div>
        <h2 class="page-title">Nouvelle capsule</h2>
      </div>
      <p class="page-subtitle mb-0">Créez une capsule temporelle et invitez vos proches.</p>
    </div>
  </div>

  <?php if ($flash): ?>
    <div class="alert alert-<?php echo h($flash['type'] ?? 'info'); ?>" role="alert"><?php echo h($flash['message'] ?? ''); ?></div>
  <?php endif; ?>

  <?php foreach ($errors as $error): ?>
    <div class="alert alert-danger" role="alert"><?php echo h($error); ?></div>
  <?php endforeach; ?>
</header>

<section class="cards-section">
  <div class="row justify-content-center">
    <div class="col-12 col-lg-8">
      <div class="capsule-card" style="height:auto;">
        <div class="card-body-cv">
          <form method="post">
            <div class="mb-3">
              <label class="form-label-cv" for="title">Titre de la capsule</label>
              <input id="title" name="title" type="text" class="form-input-cv" placeholder="Ex: Vacances d'été 2026" />
            </div>

            <div class="mb-3">
              <label class="form-label-cv" for="description">Description</label>
              <textarea id="description" name="description" class="form-input-cv" rows="5" placeholder="Décrivez l'objectif de cette capsule..."></textarea>
            </div>

            <div class="mb-3">
              <label class="form-label-cv" for="open_date">Date d'ouverture</label>
              <input id="open_date" name="open_date" type="date" class="form-input-cv" />
            </div>

            <div class="mb-3">
              <label class="form-label-cv" for="invite_emails">Inviter des participants</label>
              <textarea id="invite_emails" name="invite_emails" class="form-input-cv" rows="4" placeholder="une@email.com, deux@email.com"></textarea>
              <div class="form-hint">Séparez les adresses par une virgule, un point-virgule ou une nouvelle ligne.</div>
            </div>

            <div class="d-flex justify-content-end gap-2">
              <a class="btn-filter text-decoration-none" href="capsules.php">Annuler</a>
              <button type="submit" class="btn-primary-cv">Créer la capsule</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</section>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>