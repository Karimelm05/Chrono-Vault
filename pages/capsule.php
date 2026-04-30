<?php
$pageTitle = 'Capsule cfdfds | ChronoVault';
$activePage = 'capsules';

require_once __DIR__ . '/../includes/layout.php';
require_once __DIR__ . '/../includes/fonctions.php';

$capsuleName = 'cfdfds';
$capsuleDescription = 'Capsule privee: le contenu reste chiffre jusqu\'a la date d\'ouverture.';
$openDate = '2026-05-20 00:00:00';
$creatorName = 'fff';

$flashType = '';
$flashMessage = '';

/**
 * Avoids loading DB config when DB_NAME is empty in config.php.
 */
function isDbConfigured(string $configPath): bool
{
    if (!is_file($configPath)) {
        return false;
    }

    $content = file_get_contents($configPath);
    if ($content === false) {
        return false;
    }

    if (preg_match("/define\('DB_NAME',\s*'([^']*)'\);/", $content, $m) !== 1) {
        return false;
    }

    return trim($m[1]) !== '';
}

/**
 * Inserts values in matching columns only, based on table schema.
 */
function insertDynamic(PDO $pdo, string $table, array $data): bool
{
    $stmt = $pdo->query('SHOW COLUMNS FROM `' . $table . '`');
    $columns = $stmt ? $stmt->fetchAll(PDO::FETCH_ASSOC) : [];

    if (!$columns) {
        return false;
    }

    $columnMap = [];
    foreach ($columns as $column) {
        $field = (string)($column['Field'] ?? '');
        if ($field !== '') {
            $columnMap[strtolower($field)] = $field;
        }
    }

    $insertCols = [];
    $insertVals = [];

    foreach ($data as $key => $value) {
        $lookup = strtolower((string)$key);
        if (!isset($columnMap[$lookup])) {
            continue;
        }

        $insertCols[] = '`' . $columnMap[$lookup] . '`';
        $insertVals[] = $value;
    }

    if (!$insertCols) {
        return false;
    }

    $placeholders = implode(', ', array_fill(0, count($insertCols), '?'));
    $sql = 'INSERT INTO `' . $table . '` (' . implode(', ', $insertCols) . ') VALUES (' . $placeholders . ')';
    $insertStmt = $pdo->prepare($sql);

    return $insertStmt->execute($insertVals);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $configPath = __DIR__ . '/../config.php';

    if (!isDbConfigured($configPath)) {
        $flashType = 'warning';
        $flashMessage = 'Base de donnees non configuree. Renseignez DB_NAME dans config.php pour enregistrer MEDIA et INVITATION.';
    } else {
        require_once $configPath;

        try {
            $action = $_POST['action'] ?? '';
            $now = date('Y-m-d H:i:s');

            if ($action === 'add_content') {
                $contentType = ($_POST['content_type'] ?? 'message') === 'photo' ? 'photo' : 'message';
                $messageText = trim($_POST['future_message'] ?? '');
                $storedPath = null;

                if ($contentType === 'message' && $messageText === '') {
                    throw new RuntimeException('Le message est obligatoire.');
                }

                if ($contentType === 'photo') {
                    if (!isset($_FILES['future_photo']) || !is_array($_FILES['future_photo'])) {
                        throw new RuntimeException('Aucune photo envoyee.');
                    }

                    $photo = $_FILES['future_photo'];
                    if (($photo['error'] ?? UPLOAD_ERR_NO_FILE) !== UPLOAD_ERR_OK) {
                        throw new RuntimeException('Erreur lors de l\'upload photo.');
                    }

                    $size = (int)($photo['size'] ?? 0);
                    if ($size > 2 * 1024 * 1024) {
                        throw new RuntimeException('Photo trop volumineuse (max 2 MB).');
                    }

                    $tmpName = (string)($photo['tmp_name'] ?? '');
                    $mime = $tmpName !== '' ? (string)mime_content_type($tmpName) : '';
                    $allowed = ['image/jpeg', 'image/png', 'image/gif'];

                    if (!in_array($mime, $allowed, true)) {
                        throw new RuntimeException('Format non supporte. Utilisez JPG, PNG ou GIF.');
                    }

                    $uploadsDir = __DIR__ . '/../images/uploads';
                    if (!is_dir($uploadsDir) && !mkdir($uploadsDir, 0777, true) && !is_dir($uploadsDir)) {
                        throw new RuntimeException('Impossible de creer le dossier images/uploads.');
                    }

                    $extension = strtolower(pathinfo((string)($photo['name'] ?? ''), PATHINFO_EXTENSION));
                    if ($extension === '') {
                        $extension = $mime === 'image/png' ? 'png' : ($mime === 'image/gif' ? 'gif' : 'jpg');
                    }

                    $filename = 'capsule_' . date('Ymd_His') . '_' . bin2hex(random_bytes(4)) . '.' . $extension;
                    $destination = $uploadsDir . '/' . $filename;

                    if (!move_uploaded_file($tmpName, $destination)) {
                        throw new RuntimeException('Impossible de sauvegarder la photo.');
                    }

                    $storedPath = '../images/uploads/' . $filename;
                }

                $mediaData = [
                    'capsule_name' => $capsuleName,
                    'nom_capsule' => $capsuleName,
                    'capsule' => $capsuleName,
                    'creator_name' => $creatorName,
                    'auteur' => $creatorName,
                    'owner_name' => $creatorName,
                    'type' => $contentType,
                    'type_media' => $contentType,
                    'content_type' => $contentType,
                    'message' => $contentType === 'message' ? $messageText : null,
                    'contenu' => $contentType === 'message' ? $messageText : $storedPath,
                    'content' => $contentType === 'message' ? $messageText : $storedPath,
                    'photo_path' => $storedPath,
                    'media_path' => $storedPath,
                    'file_path' => $storedPath,
                    'created_at' => $now,
                    'date_ajout' => $now,
                    'added_at' => $now,
                ];

                $ok = insertDynamic($pdo, 'MEDIA', $mediaData);
                if (!$ok) {
                    throw new RuntimeException('Insertion MEDIA impossible: colonnes incompatibles.');
                }

                $flashType = 'success';
                $flashMessage = $contentType === 'message'
                    ? 'Message ajoute a la capsule.'
                    : 'Photo ajoutee a la capsule.';
            }

            if ($action === 'invite_member') {
                $email = trim($_POST['invite_email'] ?? '');
                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    throw new RuntimeException('Email invalide.');
                }

                $invitationData = [
                    'capsule_name' => $capsuleName,
                    'nom_capsule' => $capsuleName,
                    'capsule' => $capsuleName,
                    'sender_name' => $creatorName,
                    'creator_name' => $creatorName,
                    'email' => $email,
                    'invite_email' => $email,
                    'statut' => 'pending',
                    'status' => 'pending',
                    'created_at' => $now,
                    'date_invitation' => $now,
                    'sent_at' => $now,
                ];

                $ok = insertDynamic($pdo, 'INVITATION', $invitationData);
                if (!$ok) {
                    throw new RuntimeException('Insertion INVITATION impossible: colonnes incompatibles.');
                }

                $flashType = 'success';
                $flashMessage = 'Invitation envoyee a ' . h($email) . '.';
            }
        } catch (Throwable $e) {
            $flashType = 'danger';
            $flashMessage = $e->getMessage();
        }
    }
}
?>

<header class="page-header">
  <div class="d-flex align-items-start justify-content-between flex-wrap gap-3 mb-4">
    <div>
      <div class="page-title-bar">
        <div class="title-accent"></div>
        <h2 class="page-title">Capsule: <?php echo h($capsuleName); ?></h2>
      </div>
      <p class="page-subtitle mb-0">Interface detaillee d'une capsule temporelle privee.</p>
    </div>
    <a class="btn-filter text-decoration-none" href="capsules.php">Retour aux capsules</a>
  </div>

  <?php if ($flashMessage !== ''): ?>
    <div class="alert alert-<?php echo h($flashType ?: 'info'); ?>" role="alert">
      <?php echo h($flashMessage); ?>
    </div>
  <?php endif; ?>
</header>

<section class="cards-section">
  <div class="row g-4">
    <div class="col-12">
      <div class="capsule-card" style="height:auto; min-height: 200px;">
        <div class="card-body-cv">
          <div class="d-flex align-items-center gap-2 mb-2">
            <span class="material-symbols-outlined" style="color:var(--color-primary)">lock</span>
            <p class="card-category mb-0">Confidentiel jusqu'a l'ouverture</p>
          </div>
          <h3 class="card-title-cv mb-2"><?php echo h($capsuleName); ?></h3>
          <p class="card-desc" style="-webkit-line-clamp:unset; line-clamp:unset; margin-bottom:1rem;">
            <?php echo h($capsuleDescription); ?>
          </p>

          <div class="countdown-grid" id="countdown" data-target="2026-05-20T00:00:00">
            <div class="countdown-item"><strong id="cd-days">20</strong><span>Jours</span></div>
            <div class="countdown-item"><strong id="cd-hours">4</strong><span>Heures</span></div>
            <div class="countdown-item"><strong id="cd-minutes">3</strong><span>Minutes</span></div>
            <div class="countdown-item"><strong id="cd-seconds">36</strong><span>Secondes</span></div>
          </div>
        </div>
      </div>
    </div>

    <div class="col-12">
      <div class="row g-3">
        <div class="col-12 col-md-4">
          <div class="capsule-card" style="height:auto; min-height: 140px;">
            <div class="card-body-cv">
              <p class="card-category">Date d'ouverture</p>
              <h3 class="card-title-cv">20 mai 2026</h3>
            </div>
          </div>
        </div>
        <div class="col-12 col-md-4">
          <div class="capsule-card" style="height:auto; min-height: 140px;">
            <div class="card-body-cv">
              <p class="card-category">Membres</p>
              <h3 class="card-title-cv">1 participant</h3>
            </div>
          </div>
        </div>
        <div class="col-12 col-md-4">
          <div class="capsule-card" style="height:auto; min-height: 140px;">
            <div class="card-body-cv">
              <p class="card-category">Contenu</p>
              <h3 class="card-title-cv">0 message · 0 photo</h3>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="col-12 col-lg-7">
      <div class="capsule-card" style="height:auto; min-height: 360px;">
        <div class="card-body-cv">
          <h3 class="card-title-cv">Ajouter du contenu</h3>
          <p class="card-desc" style="-webkit-line-clamp:unset; line-clamp:unset;">Ajoutez un message texte ou une photo avant le scellement definitif.</p>

          <div class="d-flex gap-2 mb-3">
            <button type="button" class="btn-filter content-tab active" data-content-tab="message">Message</button>
            <button type="button" class="btn-filter content-tab" data-content-tab="photo">Photo</button>
          </div>

          <form method="post" enctype="multipart/form-data" id="mediaForm">
            <input type="hidden" name="action" value="add_content">
            <input type="hidden" name="content_type" id="contentType" value="message">

            <div id="messageBlock">
              <label for="future_message" class="form-label-cv">Message pour le futur</label>
              <textarea id="future_message" name="future_message" class="form-input-cv" placeholder="Ecrire un message pour le futur..."></textarea>
            </div>

            <div id="photoBlock" style="display:none;">
              <label for="future_photo" class="form-label-cv">Photo (JPG/PNG/GIF, max 2 MB)</label>
              <input id="future_photo" name="future_photo" type="file" class="form-input-cv" accept=".jpg,.jpeg,.png,.gif">
            </div>

            <div class="d-flex justify-content-end mt-3">
              <button type="submit" class="btn-primary-cv" id="submitMediaBtn">Ajouter le message</button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <div class="col-12 col-lg-5">
      <div class="capsule-card" style="height:auto; min-height: 360px;">
        <div class="card-body-cv d-flex justify-content-center text-center">
          <span class="material-symbols-outlined" style="font-size:50px; color:var(--color-primary);">lock</span>
          <h3 class="card-title-cv mt-2">Contenu verrouille</h3>
          <p class="card-desc" style="-webkit-line-clamp:unset; line-clamp:unset;">
            Tous les messages et photos restent caches jusqu'au 20 mai 2026. Cette capsule agit comme un coffre-fort numerique temporel.
          </p>
        </div>
      </div>
    </div>

    <div class="col-12">
      <div class="capsule-card" style="height:auto; min-height: 280px;">
        <div class="card-body-cv">
          <h3 class="card-title-cv">Gestion des membres</h3>
          <div class="d-flex flex-wrap align-items-center justify-content-between gap-2 mb-3">
            <div>
              <p class="card-category mb-1">Membre actuel</p>
              <strong><?php echo h($creatorName); ?></strong>
            </div>
          </div>

          <form method="post" class="d-flex flex-wrap gap-2 align-items-end">
            <input type="hidden" name="action" value="invite_member">
            <div style="flex:1; min-width:260px;">
              <label for="invite_email" class="form-label-cv">Ajouter un membre</label>
              <input id="invite_email" name="invite_email" type="email" class="form-input-cv" placeholder="ami@email.com" required>
            </div>
            <button type="submit" class="btn-primary-cv">Inviter</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</section>

<style>
  .countdown-grid {
    display: grid;
    grid-template-columns: repeat(4, minmax(0, 1fr));
    gap: 0.75rem;
  }

  .countdown-item {
    background: var(--color-surface-container-low);
    border: 1px solid var(--color-outline-variant);
    border-radius: 0.65rem;
    padding: 0.8rem;
    text-align: center;
  }

  .countdown-item strong {
    display: block;
    font-size: 1.65rem;
    line-height: 1;
    color: var(--color-primary);
    margin-bottom: 0.25rem;
  }

  .countdown-item span {
    font-size: 0.75rem;
    color: var(--color-on-surface-variant);
    text-transform: uppercase;
    letter-spacing: 0.05em;
  }

  .content-tab.active {
    background: var(--color-secondary-container);
    color: var(--color-on-secondary-container);
  }

  @media (max-width: 767.98px) {
    .countdown-grid {
      grid-template-columns: repeat(2, minmax(0, 1fr));
    }
  }
</style>

<script>
  (function () {
    const countdown = document.getElementById('countdown');
    if (!countdown) return;

    const target = new Date(countdown.dataset.target).getTime();
    const daysEl = document.getElementById('cd-days');
    const hoursEl = document.getElementById('cd-hours');
    const minutesEl = document.getElementById('cd-minutes');
    const secondsEl = document.getElementById('cd-seconds');

    function updateCountdown() {
      const now = Date.now();
      let diff = Math.max(0, target - now);

      const days = Math.floor(diff / (1000 * 60 * 60 * 24));
      diff -= days * 1000 * 60 * 60 * 24;
      const hours = Math.floor(diff / (1000 * 60 * 60));
      diff -= hours * 1000 * 60 * 60;
      const minutes = Math.floor(diff / (1000 * 60));
      diff -= minutes * 1000 * 60;
      const seconds = Math.floor(diff / 1000);

      daysEl.textContent = String(days);
      hoursEl.textContent = String(hours);
      minutesEl.textContent = String(minutes);
      secondsEl.textContent = String(seconds);
    }

    updateCountdown();
    setInterval(updateCountdown, 1000);
  })();

  (function () {
    const tabs = document.querySelectorAll('.content-tab');
    const contentTypeInput = document.getElementById('contentType');
    const messageBlock = document.getElementById('messageBlock');
    const photoBlock = document.getElementById('photoBlock');
    const submitBtn = document.getElementById('submitMediaBtn');
    const messageInput = document.getElementById('future_message');

    tabs.forEach((tab) => {
      tab.addEventListener('click', function () {
        const type = this.getAttribute('data-content-tab');

        tabs.forEach((x) => x.classList.remove('active'));
        this.classList.add('active');

        contentTypeInput.value = type;

        if (type === 'photo') {
          messageBlock.style.display = 'none';
          photoBlock.style.display = '';
          submitBtn.textContent = 'Ajouter la photo';
          messageInput.removeAttribute('required');
        } else {
          messageBlock.style.display = '';
          photoBlock.style.display = 'none';
          submitBtn.textContent = 'Ajouter le message';
          messageInput.setAttribute('required', 'required');
        }
      });
    });

    document.getElementById('mediaForm')?.addEventListener('submit', function (event) {
      const type = contentTypeInput.value;

      if (type === 'message') {
        const val = (messageInput.value || '').trim();
        if (!val) {
          event.preventDefault();
          alert('Veuillez saisir un message pour le futur.');
          return;
        }
      }

      if (type === 'photo') {
        const photoInput = document.getElementById('future_photo');
        const file = photoInput.files[0];
        if (!file) {
          event.preventDefault();
          alert('Veuillez selectionner une photo.');
          return;
        }

        const allowed = ['image/jpeg', 'image/png', 'image/gif'];
        if (!allowed.includes(file.type)) {
          event.preventDefault();
          alert('Format non supporte. Utilisez JPG, PNG ou GIF.');
          return;
        }

        if (file.size > 2 * 1024 * 1024) {
          event.preventDefault();
          alert('Photo trop volumineuse (max 2 MB).');
        }
      }
    });
  })();
</script>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
