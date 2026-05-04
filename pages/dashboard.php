<?php
require_once __DIR__ . '/../includes/app.php';
require_once __DIR__ . '/../connexion.php';
require_once __DIR__ . '/../includes/fonctions.php';
include __DIR__ . '/../includes/app-layout.php';
cv_require_login();

$pageTitle = 'Dashboard';
$activePage = 'dashboard';
$user = cv_current_user();
$userId = (int)($user['id'] ?? 0);


?>
      <div class="cv-topbar">
        <div>
          <h2 class="cv-title">Dashboard</h2>
          <p class="cv-subtitle">Vue d’ensemble des capsules, groupes et invitations.</p>
        </div>
        <div class="cv-actions">
          <button class="cv-btn cv-btn-secondary d-lg-none" id="toggleSidebar" type="button">Menu</button>
          <a class="cv-btn cv-btn-primary text-decoration-none" href="invitations.php">Voir les invitations</a>
        </div>
      </div>

      <section class="cv-metrics">
        <article class="cv-metric">
          <span class="label">Capsules totales</span>
          <span class="value"><?php echo (int)cv_count_user_created_capsules($userId); ?></span>
          <span class="trend">Créées par vous</span>
        </article>
        <article class="cv-metric">
          <span class="label">Ouvertes</span>
          <span class="value"><?php echo (int)cv_count_user_open_capsules($userId); ?></span>
          <span class="trend">Accessibles maintenant</span>
        </article>
        <article class="cv-metric">
          <span class="label">Invitations</span>
          <span class="value"><?php echo (int)cv_count_pending_notifications($userId); ?></span>
          <span class="trend">En attente de réponse</span>
        </article>
        <article class="cv-metric">
          <span class="label">Activité</span>
          <span class="value"><?php echo (int)cv_count_user_member_capsules($userId); ?></span>
          <span class="trend">Capsules accessibles</span>
        </article>
      </section>

      <section class="cv-grid-2">
        <div class="cv-card">
          <div class="cv-card-header">
            <h3 class="cv-card-title">Capsules récentes</h3>
            <button class="cv-btn cv-btn-secondary" type="button">Filtrer</button>
          </div>
          <div class="cv-card-body">
            <div class="cv-list">
              <div class="cv-list-item">
                <div>
                  <strong>Cadeau anniversaire</strong>
                  <div class="cv-muted">Famille · ouverture dans 12 jours</div>
                </div>
                <span class="cv-pill pending">Verrouillée</span>
              </div>
              <div class="cv-list-item">
                <div>
                  <strong>Projet équipe</strong>
                  <div class="cv-muted">Travail · 2 pièces jointes</div>
                </div>
                <span class="cv-pill accepted">Ouverte</span>
              </div>
              <div class="cv-list-item">
                <div>
                  <strong>Capsule souvenir</strong>
                  <div class="cv-muted">Amis · 5 invités</div>
                </div>
                <span class="cv-pill pending">Programmée</span>
              </div>
            </div>
          </div>
        </div>

        <div class="cv-card">
          <div class="cv-card-header">
            <h3 class="cv-card-title">Invitations actives</h3>
            <a class="cv-link" href="invitations.php">Gérer</a>
          </div>
          <div class="cv-card-body">
            <div class="cv-list">
              <div class="cv-list-item">
                <div>
                  <strong>Marie Dupont</strong>
                  <div class="cv-muted">Invitée à 2 capsules</div>
                </div>
                <span class="cv-pill pending">Nouveau</span>
              </div>
              <div class="cv-list-item">
                <div>
                  <strong>Lucas Bernard</strong>
                  <div class="cv-muted">Réponse attendue</div>
                </div>
                <span class="cv-pill accepted">Accepté</span>
              </div>
            </div>
          </div>
        </div>
      </section>

<?php include __DIR__ . '/../includes/app-layout-footer.php'; ?>

