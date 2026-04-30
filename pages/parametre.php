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
  <div class="row g-4">
    <div class="col-12 col-lg-6">
      <div class="capsule-card" style="height:auto; min-height: 260px;">
        <div class="card-body-cv">
          <h3 class="card-title-cv">Profil</h3>
          <div class="mb-3">
            <label class="form-label-cv" for="displayName">Nom affiché</label>
            <input id="displayName" class="form-input-cv" type="text" value="Marc-Antoine"/>
          </div>
          <div class="mb-3">
            <label class="form-label-cv" for="emailAddress">Adresse email</label>
            <input id="emailAddress" class="form-input-cv" type="email" value="marc@example.com"/>
          </div>
        </div>
      </div>
    </div>

    <div class="col-12 col-lg-6">
      <div class="capsule-card" style="height:auto; min-height: 260px;">
        <div class="card-body-cv">
          <h3 class="card-title-cv">Préférences</h3>
          <div class="d-flex flex-column gap-3">
            <label class="d-flex align-items-center justify-content-between gap-3">
              <span>Recevoir les notifications par email</span>
              <input type="checkbox" checked/>
            </label>
            <label class="d-flex align-items-center justify-content-between gap-3">
              <span>Activer les rappels de capsules</span>
              <input type="checkbox" checked/>
            </label>
            <label class="d-flex align-items-center justify-content-between gap-3">
              <span>Mode de confidentialité renforcé</span>
              <input type="checkbox"/>
            </label>
          </div>
        </div>
      </div>
    </div>

    <div class="col-12 col-lg-6">
      <div class="capsule-card" style="height:auto; min-height: 220px;">
        <div class="card-body-cv">
          <h3 class="card-title-cv">Sécurité</h3>
          <p class="card-desc">Changez votre mot de passe ou déconnectez les autres sessions actives.</p>
          <div class="d-flex flex-wrap gap-2">
            <button class="btn-filter" type="button">Changer le mot de passe</button>
            <button class="btn-filter" type="button">Déconnecter les sessions</button>
          </div>
        </div>
      </div>
    </div>

    
  </div>
</section>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
