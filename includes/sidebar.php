<?php
/**
 * Sidebar Component - Réutilisable pour toutes les pages
 * Variables attendues: $activePage, $user, $userId (ou les globales $_SESSION)
 */

// Initialiser les variables si non fournies
$activePage = $activePage ?? '';
$user = $user ?? cv_current_user();
$userId = $userId ?? (int)($user['id'] ?? 0);

// Récupérer les compteurs
$createdCapsulesCount = function_exists('cv_count_user_created_capsules') ? cv_count_user_created_capsules($userId) : 0;
$memberCapsulesCount = function_exists('cv_count_user_member_capsules') ? cv_count_user_member_capsules($userId) : 0;
$openCapsulesCount = function_exists('cv_count_user_open_capsules') ? cv_count_user_open_capsules($userId) : 0;
$pendingNotificationsCount = function_exists('cv_count_pending_notifications') ? cv_count_pending_notifications($userId) : 0;
$pendingNotifications = function_exists('cv_get_pending_notifications') ? cv_get_pending_notifications($userId, 5) : [];
$isAdmin = function_exists('cv_is_admin') ? cv_is_admin() : false;

// Fonctions locales pour le sidebar
function cv_is_sidebar_active($page, $activePage) {
  return strtolower($page) === strtolower($activePage);
}
?>

<aside class="cv-sidebar d-flex flex-column" id="sidebar">
  <div class="cv-brand">
    <div class="cv-brand-badge">🔒</div>
    <div>
      <h1>ChronoVault</h1>
      <p><?php echo htmlspecialchars($user['name'] ?? 'Utilisateur'); ?></p>
    </div>
  </div>

  <div class="d-flex flex-column flex-grow-1">
    <nav class="cv-nav mb-4">
      <a class="<?php echo cv_is_sidebar_active('dashboard', $activePage) ? 'active' : ''; ?>" href="dashboard.php">
        Dashboard <span><?php echo (int)$memberCapsulesCount; ?></span>
      </a>
      <a class="<?php echo cv_is_sidebar_active('invitations', $activePage) ? 'active' : ''; ?>" href="invitations.php">
        Invitations <span><?php echo (int)$pendingNotificationsCount; ?></span>
      </a>
      <a class="<?php echo cv_is_sidebar_active('capsules', $activePage) ? 'active' : ''; ?>" href="capsules.php">
        Capsules <span><?php echo (int)$createdCapsulesCount; ?></span>
      </a>
      <?php if ($isAdmin): ?>
        <a class="<?php echo cv_is_sidebar_active('admin', $activePage) ? 'active' : ''; ?>" href="admin.php">
          Administration <span>⚙</span>
        </a>
      <?php endif; ?>
      <a href="../index.php">Accueil <span>↗</span></a>
    </nav>

    <div class="cv-panel mt-auto">
      <div class="cv-panel-inner">
        <p class="mb-1 fw-bold">Session active</p>
        <p class="mb-2 cv-muted"><?php echo htmlspecialchars($user['name'] ?? 'Utilisateur'); ?>, connecté</p>
        <a href="parametre.php" class="btn btn-sm btn-outline-secondary w-100 mb-2">Paramètres</a>
        <a href="logout.php" class="btn btn-sm btn-outline-danger w-100">Déconnexion</a>
      </div>
    </div>
  </div>
</aside>
