<?php
require_once __DIR__ . '/../includes/app.php';
cv_require_login();

$user = cv_current_user();
$userId = (int)($user['id'] ?? 0);
$errors = [];

$capsuleId = (int)($_GET['id'] ?? 0);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    $capsuleId = (int)($_POST['capsule_id'] ?? $capsuleId);

    if ($action === 'add_souvenir') {
        $type = ($_POST['souvenir_type'] ?? 'message') === 'photo' ? 'photo' : 'message';
        $message = trim($_POST['souvenir_message'] ?? '');

        if ($type === 'message' && $message === '') {
          $errors[] = 'Le message est obligatoire.';
        } elseif ($type === 'photo' && empty($_FILES['souvenir_photo']['name'])) {
          $errors[] = 'Veuillez sélectionner une photo.';
        } else {
          // Permission check: only owner or invited users can post
          $permStmt = $pdo->prepare('SELECT Id_Utilisateur FROM capsule WHERE Id_Capsule = :capsule_id LIMIT 1');
          $permStmt->execute([':capsule_id' => $capsuleId]);
          $ownerId = (int)$permStmt->fetchColumn();
          $allowed = false;
          if ($ownerId === $userId) {
            $allowed = true;
          } else {
            $invStmt = $pdo->prepare('SELECT COUNT(*) FROM invitation WHERE Id_Capsule = :capsule_id AND Id_Utilisateur = :user_id');
            $invStmt->execute([':capsule_id' => $capsuleId, ':user_id' => $userId]);
            $allowed = (int)$invStmt->fetchColumn() > 0;
          }

          if (! $allowed) {
            $errors[] = 'Vous n\'avez pas la permission de poster dans cette capsule.';
          } else {
            try {
              $donnee = $message;

              if ($type === 'photo') {
                $donnee = cv_store_upload_file($_FILES['souvenir_photo'], 'images/uploads', 'souvenir');
              }

              $stmt = $pdo->prepare('INSERT INTO souvenir (type, donnee, date_poste, Id_Utilisateur, Id_Capsule) VALUES (:type, :donnee, :date_poste, :user_id, :capsule_id)');
              $stmt->execute([
                ':type' => $type,
                ':donnee' => $donnee,
                ':date_poste' => cv_now(),
                ':user_id' => $userId,
                ':capsule_id' => $capsuleId,
              ]);

              cv_flash_set('success', $type === 'photo' ? 'Photo ajoutée à la capsule.' : 'Message ajouté à la capsule.');
              header('Location: capsule.php?id=' . $capsuleId);
              exit();
            } catch (Throwable $e) {
              $errors[] = $e->getMessage();
            }
          }
        }
    }

    if ($action === 'invite_member') {
        $inviteEmail = trim($_POST['invite_email'] ?? '');

        if ($inviteEmail === '') {
            $errors[] = 'L’adresse email est obligatoire.';
        } else {
            // Only capsule owner can invite members
            $ownerCheck = $pdo->prepare('SELECT Id_Utilisateur FROM capsule WHERE Id_Capsule = :capsule_id LIMIT 1');
            $ownerCheck->execute([':capsule_id' => $capsuleId]);
            $ownerIdForInvite = (int)$ownerCheck->fetchColumn();

            if ($ownerIdForInvite !== $userId) {
                $errors[] = 'Seul le créateur de la capsule peut inviter des membres.';
            } else {
                $stmt = $pdo->prepare('SELECT Id_Utilisateur, nom FROM utilisateur WHERE email = :email LIMIT 1');
                $stmt->execute([':email' => $inviteEmail]);
                $invitee = $stmt->fetch();

                if (!$invitee) {
                    $errors[] = 'Aucun utilisateur ne correspond à cet email.';
                } else {
                    $stmt = $pdo->prepare('SELECT Id_Invitation FROM invitation WHERE Id_Capsule = :capsule_id AND Id_Utilisateur = :user_id LIMIT 1');
                    $stmt->execute([
                        ':capsule_id' => $capsuleId,
                        ':user_id' => (int)$invitee['Id_Utilisateur'],
                    ]);

                    if ($stmt->fetch()) {
                        $errors[] = 'Cette personne est déjà invitée.';
                    } else {
                        $stmt = $pdo->prepare('INSERT INTO invitation (statut, date_envoi, Id_Capsule, Id_Utilisateur) VALUES (:statut, :date_envoi, :capsule_id, :user_id)');
                        $stmt->execute([
                            ':statut' => 'pending',
                            ':date_envoi' => cv_now(),
                            ':capsule_id' => $capsuleId,
                            ':user_id' => (int)$invitee['Id_Utilisateur'],
                        ]);

                        cv_flash_set('success', 'Invitation envoyée à ' . $inviteEmail . '.');
                        header('Location: capsule.php?id=' . $capsuleId);
                        exit();
                    }
                }
            }
        }
    }
}

if ($capsuleId <= 0) {
    $stmt = $pdo->prepare(
      'SELECT DISTINCT c.Id_Capsule FROM capsule c
       LEFT JOIN invitation inv ON c.Id_Capsule = inv.Id_Capsule AND inv.Id_Utilisateur = :user_id
       WHERE c.Id_Utilisateur = :user_id OR inv.Id_Utilisateur = :user_id
       ORDER BY c.date_creation DESC, c.Id_Capsule DESC LIMIT 1'
    );
    $stmt->execute([':user_id' => $userId]);
    $capsuleId = (int)($stmt->fetchColumn() ?: 0);
}

if ($capsuleId <= 0) {
    cv_flash_set('warning', 'Aucune capsule disponible.');
    header('Location: capsules.php');
    exit();
}

$stmt = $pdo->prepare(
    'SELECT c.Id_Capsule, c.titre, c.description, c.date_creation, c.date_ouverture, c.Id_Utilisateur, u.nom AS owner_name
     FROM capsule c
     INNER JOIN utilisateur u ON u.Id_Utilisateur = c.Id_Utilisateur
     WHERE c.Id_Capsule = :capsule_id
     LIMIT 1'
);
$stmt->execute([':capsule_id' => $capsuleId]);
$capsule = $stmt->fetch();

if (!$capsule) {
    cv_flash_set('danger', 'Capsule introuvable.');
    header('Location: capsules.php');
    exit();
}

$isOwner = (int)$capsule['Id_Utilisateur'] === $userId;

$stmt = $pdo->prepare('SELECT COUNT(*) FROM invitation WHERE Id_Capsule = :capsule_id AND Id_Utilisateur = :user_id');
$stmt->execute([':capsule_id' => $capsuleId, ':user_id' => $userId]);
$hasInvitation = (int)$stmt->fetchColumn() > 0;

if (!$isOwner && !$hasInvitation) {
    cv_flash_set('danger', 'Vous n’avez pas accès à cette capsule.');
    header('Location: capsules.php');
    exit();
}

$stmt = $pdo->prepare('SELECT type, donnee, date_poste FROM souvenir WHERE Id_Capsule = :capsule_id ORDER BY date_poste DESC, Id_Souvenir DESC');
$stmt->execute([':capsule_id' => $capsuleId]);
$souvenirs = $stmt->fetchAll();

$stmt = $pdo->prepare('SELECT COUNT(*) FROM invitation WHERE Id_Capsule = :capsule_id');
$stmt->execute([':capsule_id' => $capsuleId]);
$memberCount = (int)$stmt->fetchColumn() + 1;

$messageCount = 0;
$photoCount = 0;
foreach ($souvenirs as $souvenir) {
    if (($souvenir['type'] ?? '') === 'photo') {
        $photoCount++;
    } else {
        $messageCount++;
    }
}

require_once __DIR__ . '/../includes/layout.php';
$flash = cv_flash_get();
?>

<header class="page-header">
  <div class="d-flex align-items-start justify-content-between flex-wrap gap-3 mb-4">
    <div>
      <div class="page-title-bar">
        <div class="title-accent"></div>
        <h2 class="page-title"><?php echo h((string)$capsule['titre']); ?></h2>
      </div>
      <p class="page-subtitle mb-0"><?php echo h((string)($capsule['description'] ?: 'Aucune description')); ?></p>
    </div>
    <a class="btn-filter text-decoration-none" href="capsules.php">Retour aux capsules</a>
  </div>

  <?php if ($flash): ?>
    <div class="alert alert-<?php echo h($flash['type'] ?? 'info'); ?>" role="alert"><?php echo h($flash['message'] ?? ''); ?></div>
  <?php endif; ?>

  <?php foreach ($errors as $error): ?>
    <div class="alert alert-danger" role="alert"><?php echo h($error); ?></div>
  <?php endforeach; ?>
</header>

<section class="cards-section">
  <div class="row g-4">
    <div class="col-12">
      <div class="capsule-card" style="height:auto; min-height: 180px;">
        <div class="card-body-cv">
          <p class="card-category">Confidentiel jusqu'à l'ouverture</p>
          <h3 class="card-title-cv mb-2"><?php echo h((string)$capsule['titre']); ?></h3>
          <p class="card-desc" style="-webkit-line-clamp:unset; line-clamp:unset; margin-bottom:1rem;">
            Ouverture prévue le <?php echo h(!empty($capsule['date_ouverture']) ? date('d/m/Y', strtotime((string)$capsule['date_ouverture'])) : 'non définie'); ?>.
          </p>

          <div class="row g-3">
            <div class="col-12 col-md-4"><div class="capsule-card" style="height:auto; min-height: 120px;"><div class="card-body-cv"><p class="card-category">Date d'ouverture</p><h3 class="card-title-cv"> <?php echo h(!empty($capsule['date_ouverture']) ? date('d/m/Y', strtotime((string)$capsule['date_ouverture'])) : 'Non définie'); ?></h3></div></div></div>
            <div class="col-12 col-md-4"><div class="capsule-card" style="height:auto; min-height: 120px;"><div class="card-body-cv"><p class="card-category">Membres</p><h3 class="card-title-cv"><?php echo $memberCount; ?></h3></div></div></div>
            <div class="col-12 col-md-4"><div class="capsule-card" style="height:auto; min-height: 120px;"><div class="card-body-cv"><p class="card-category">Contenu</p><h3 class="card-title-cv"><?php echo $messageCount; ?> message(s) · <?php echo $photoCount; ?> photo(s)</h3></div></div></div>
          </div>
        </div>
      </div>
    </div>

    <div class="col-12 col-lg-7">
      <div class="capsule-card" style="height:auto;">
        <div class="card-body-cv">
          <h3 class="card-title-cv">Ajouter du contenu</h3>

          <form method="post" enctype="multipart/form-data">
            <input type="hidden" name="action" value="add_souvenir" />
            <input type="hidden" name="capsule_id" value="<?php echo (int)$capsuleId; ?>" />

            <div class="mb-3">
              <label class="form-label-cv" for="souvenir_type">Type de contenu</label>
              <select id="souvenir_type" name="souvenir_type" class="form-input-cv">
                <option value="message">Message</option>
                <option value="photo">Photo</option>
              </select>
            </div>

            <div class="mb-3" id="messageBlock">
              <label class="form-label-cv" for="souvenir_message">Message pour le futur</label>
              <textarea id="souvenir_message" name="souvenir_message" class="form-input-cv" rows="5" placeholder="Écrire un message pour le futur..."></textarea>
            </div>

            <div class="mb-3 d-none" id="photoBlock">
              <label class="form-label-cv" for="souvenir_photo">Photo</label>
              <input id="souvenir_photo" name="souvenir_photo" type="file" class="form-input-cv" accept=".jpg,.jpeg,.png,.gif" />
            </div>

            <div class="d-flex justify-content-end">
              <button type="submit" class="btn-primary-cv" id="souvenirSubmit">Ajouter le message</button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <div class="col-12 col-lg-5">
      <div class="capsule-card" style="height:auto;">
        <div class="card-body-cv">
          <h3 class="card-title-cv">Gestion des membres</h3>
          <p class="card-desc">Invitez un utilisateur déjà inscrit à rejoindre cette capsule.</p>

          <?php if ($isOwner): ?>
          <form method="post">
            <input type="hidden" name="action" value="invite_member" />
            <input type="hidden" name="capsule_id" value="<?php echo (int)$capsuleId; ?>" />

            <div class="mb-3">
              <label class="form-label-cv" for="invite_email">Adresse email</label>
              <input id="invite_email" name="invite_email" type="email" class="form-input-cv" placeholder="ami@email.com" />
            </div>

            <div class="d-flex justify-content-end">
              <button type="submit" class="btn-filter">Inviter</button>
            </div>
          </form>
          <?php else: ?>
            <p class="card-desc">Seul le créateur de la capsule peut inviter des membres.</p>
          <?php endif; ?>
        </div>
      </div>

      <div class="capsule-card mt-4" style="height:auto;">
        <div class="card-body-cv">
          <h3 class="card-title-cv">Contenu verrouillé</h3>
          <p class="card-desc">Tous les souvenirs restent accessibles uniquement aux membres autorisés.</p>
        </div>
      </div>
    </div>

  </div>
</section>

<script>
  const typeSelect = document.getElementById('souvenir_type');
  const messageBlock = document.getElementById('messageBlock');
  const photoBlock = document.getElementById('photoBlock');
  const submitButton = document.getElementById('souvenirSubmit');

  typeSelect?.addEventListener('change', function () {
    const isPhoto = this.value === 'photo';
    messageBlock.classList.toggle('d-none', isPhoto);
    photoBlock.classList.toggle('d-none', !isPhoto);
    submitButton.textContent = isPhoto ? 'Ajouter la photo' : 'Ajouter le message';
  });
</script>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>