<?php
require_once __DIR__ . '/../includes/app.php';
cv_require_login();

$pageTitle = 'Nouvelle Capsule';
$activePage = 'new-capsule';
$user = cv_current_user();
$userId = (int)($user['id'] ?? 0);

include __DIR__ . '/../includes/app-layout.php';
?>

      <div class="cv-topbar">
        <div>
          <h2 class="cv-title">Nouvelle Capsule</h2>
          <p class="cv-subtitle">Créez une capsule temporelle pour préserver vos souvenirs</p>
        </div>
      </div>

      <!-- Formulaire de création de capsule -->
      <section class="cv-card">
        <div class="cv-card-body">
          <form method="post" action="new-capsule.php" id="capsuleForm">
            <div class="form-group mb-4">
              <label class="form-label">Titre de la capsule *</label>
              <input type="text" class="form-control" name="titre" placeholder="Ex: Souvenirs de vacances 2026" required>
            </div>

            <div class="form-group mb-4">
              <label class="form-label">Description</label>
              <textarea class="form-control" name="description" placeholder="Décrivez votre capsule..." rows="4"></textarea>
            </div>

            <div class="form-group mb-4">
              <label class="form-label">Date d'ouverture *</label>
              <input type="date" class="form-control" name="date_ouverture" required>
              <small class="form-text text-muted">La capsule sera verrouillée jusqu'à cette date</small>
            </div>

            <div class="form-group mb-4">
              <label class="form-label">Inviter des participants</label>
              <div class="input-group">
                <input type="email" class="form-control" id="inviteeEmail" placeholder="Adresse email">
                <button class="btn btn-primary" type="button" id="addInvitee">Ajouter</button>
              </div>
              <div id="inviteeList" class="mt-3"></div>
            </div>

            <div class="d-flex gap-2 justify-content-end">
              <a href="capsules.php" class="btn btn-secondary">Annuler</a>
              <button type="submit" class="btn btn-primary">Créer la capsule</button>
            </div>
          </form>
        </div>
      </section>

<?php include __DIR__ . '/../includes/app-layout-footer.php'; ?>
