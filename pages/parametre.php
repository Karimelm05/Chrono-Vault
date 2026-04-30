<?php
$pageTitle = 'Paramètres | ChronoVault';
$activePage = 'parametre';
require_once __DIR__ . '/../includes/layout.php';
?>

<header class="page-header">
  <div class="d-flex justify-content-between align-items-end flex-wrap gap-3 mb-4">
    <div>
      <div class="page-title-bar">
        <div class="title-accent"></div>
        <h2 class="page-title">Paramètres</h2>
      </div>
      <p class="page-subtitle mb-0">Gérez votre compte, vos préférences et vos notifications.</p>
    </div>
    <button class="btn-primary-cv" type="button">Enregistrer</button>
  </div>
</header>

<section class="cards-section">
  <div class="row g-4 justify-content-center">
    <!-- Profil -->
    <div class="col-12 col-lg-8 mx-auto">
      <div class="capsule-card" style="height:auto; min-height: 260px;">
        <div class="card-body-cv">
          <h3 class="card-title-cv">Profil</h3>
          <form id="profileForm">

            <div class="mb-3">
              <label class="form-label-cv" for="displayName">Nom complet</label>
              <input id="displayName" class="form-input-cv" type="text" value="ZeroVector" />
            </div>

            <div class="mb-3">
              <label class="form-label-cv" for="emailAddress">Adresse email</label>
              <input id="emailAddress" class="form-input-cv" type="email" value="zerovector@example.com" />
            </div>

            <div class="d-flex justify-content-end">
              <button type="button" id="saveProfile" class="btn-primary-cv">Enregistrer</button>
            </div>
          </form>
        </div>
      </div>
    </div>


    <!-- Sécurité -->
    <div class="col-12 col-lg-8 mx-auto">
      <div class="capsule-card" style="height:auto; min-height: 220px;">
        <div class="card-body-cv">
          <h3 class="card-title-cv">Sécurité</h3>
          <p class="card-desc">Changez votre mot de passe. Les champs ci-dessous permettent de modifier votre accès.</p>
          <div class="mb-2">
            <label class="form-label-cv">Mot de passe actuel</label>
            <div class="d-flex">
              <input id="currentPassword" type="password" class="form-input-cv" />
              <button type="button" class="btn-filter ms-2 toggle-password" data-target="currentPassword">Afficher</button>
            </div>
          </div>
          <div class="mb-2">
            <label class="form-label-cv">Nouveau mot de passe</label>
            <div class="d-flex">
              <input id="newPassword" type="password" class="form-input-cv" />
              <button type="button" class="btn-filter ms-2 toggle-password" data-target="newPassword">Afficher</button>
            </div>
          </div>
          <div class="mb-2">
            <label class="form-label-cv">Confirmer le nouveau mot de passe</label>
            <div class="d-flex">
              <input id="confirmPassword" type="password" class="form-input-cv" />
              <button type="button" class="btn-filter ms-2 toggle-password" data-target="confirmPassword">Afficher</button>
            </div>
          </div>
          <div class="d-flex gap-2 mt-2">
            <button id="changePassword" class="btn-filter">Changer le mot de passe</button>
            <button id="logoutSessions" class="btn-filter">Déconnecter les sessions</button>
          </div>
        </div>
      </div>
    </div>

    <!-- Zone de danger -->
    <div class="col-12 col-lg-8 mx-auto">
      <div class="capsule-card border-danger" style="height:auto; min-height: 220px;">
        <div class="card-body-cv">
          <h3 class="card-title-cv text-danger">Zone de danger</h3>
          <p class="card-desc">Suppression définitive du compte et de toutes les capsules associées. Cette action est irréversible.</p>
          <div class="d-flex justify-content-end">
            <button id="deleteAccount" class="btn btn-danger">Supprimer</button>
          </div>
        </div>
      </div>
    </div>

  </div>
</section>

<script>
// Avatar preview + validation (max 2 MB)
const avatarFile = document.getElementById('avatarFile');
if (avatarFile) {
  avatarFile.addEventListener('change', function(){
    const file = this.files[0];
    if (!file) return;
    const allowed = ['image/jpeg','image/png','image/gif'];
    if (!allowed.includes(file.type)) { alert('Format non autorisé. Utilisez JPG, PNG ou GIF.'); this.value = ''; return; }
    if (file.size > 2 * 1024 * 1024) { alert('Le fichier est trop volumineux (max 2 MB).'); this.value = ''; return; }
    const img = document.getElementById('avatarPreview'); img.src = URL.createObjectURL(file);
  });
}

// Toggle password visibility
document.querySelectorAll('.toggle-password').forEach(function(btn){ btn.addEventListener('click', function(){ const targetId = this.getAttribute('data-target'); const input = document.getElementById(targetId); if (!input) return; if (input.type === 'password') { input.type = 'text'; this.textContent = 'Masquer'; } else { input.type = 'password'; this.textContent = 'Afficher'; } }); });

// Delete account confirmation
document.getElementById('deleteAccount')?.addEventListener('click', function(){ if (confirm('Confirmez-vous la suppression définitive de votre compte et de toutes les capsules associées ?')) { alert('Suppression simulée. Implémentez la logique côté serveur.'); } });

</script>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
