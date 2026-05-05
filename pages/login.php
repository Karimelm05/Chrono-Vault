<?php
require_once __DIR__ . '/../includes/app.php';

cv_redirect_if_logged_in();

$error = '';
$flash = cv_flash_get();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if ($email !== '' && $password !== '') {
        $stmt = $pdo->prepare('SELECT Id_Utilisateur, nom, email, mot_de_passe, role, statut FROM utilisateur WHERE email = :email LIMIT 1');
        $stmt->execute([':email' => $email]);

        $user = $stmt->fetch();

        if ($user && cv_password_matches($password, (string)$user['mot_de_passe'])) {
            if (strtolower((string)($user['statut'] ?? 'actif')) !== 'actif') {
                $error = 'Ce compte est désactivé.';
            } else {
                session_regenerate_id(true);
                cv_store_user_session($user);
                header('Location: dashboard.php');
                exit();
            }
        } else {
            $error = 'Email ou mot de passe invalide';
        }
    } else {
        $error = 'Tous les champs sont obligatoires';
    }
}
?>
<!doctype html>
<html lang="fr">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Connexion — ChronoVault</title>

    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
      rel="stylesheet" />

    <link
      href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;700;800&family=Manrope:wght@400;500;600&display=swap"
      rel="stylesheet" />

    <link rel="stylesheet" href="../css/style.css" />
  </head>

  <body class="auth-page">

    <nav class="auth-navbar">
      <div class="container d-flex justify-content-between align-items-center">
        <a href="../index.php" class="brand">ChronoVault</a>
        <div class="d-flex align-items-center gap-3">
          <span class="text-muted small">Pas encore de compte ?</span>
          <a
            href="signup.php"
            class="btn btn-outline-chrono py-2 px-3"
            style="font-size: 0.875rem"
            >S'inscrire</a
          >
        </div>
      </div>
    </nav>

    <main class="auth-main">
      <div class="auth-card text-center">

        <div class="auth-logo-box mb-3">🔒</div>

        <h2 class="auth-brand-title">ChronoVault</h2>
        <p class="auth-subtitle mb-4">Accédez à votre sanctuaire numérique</p>

        <?php if ($flash && ($flash['type'] ?? '') === 'success') : ?>
          <p class="text-success mt-3 text-center small">
            <?= h((string)$flash['message']) ?>
          </p>
        <?php endif; ?>

        <form method="POST">

          <div class="mb-4 text-start">
            <label class="form-label small text-muted">E-mail</label>

            <input
              type="email"
              name="email"
              class="form-control"
              placeholder="votre@email.com"
              required
            />
          </div>

          <div class="mb-3 text-start">
            <div class="d-flex justify-content-between">
              <label class="form-label small text-muted">
                Mot de passe
              </label>

              <a href="#" style="font-size: 10px; color: var(--muted)">
                Mot de passe oublié ?
              </a>
            </div>

            <input
              type="password"
              name="password"
              class="form-control"
              placeholder="••••••••"
              required
            />
          </div>

          <div class="d-grid mt-4">
            <button type="submit" class="btn btn-chrono-gold">
              Se connecter →
            </button>
          </div>

          <?php if ($error !== '') : ?>
            <p class="text-danger mt-3 text-center small">
              <?= h($error) ?>
            </p>
          <?php endif; ?>

        </form>

        <p class="mt-4 small">
          Pas encore de compte ?
          <a href="signup.php" class="fw-bold" style="color: var(--primary)"
            >S'inscrire</a
          >
        </p>

        <div class="auth-footer-links mt-4">
          <p class="small text-muted mb-1">© 2026 ChronoVault</p>
          <a href="#">Confidentialité</a> &nbsp;|&nbsp;
          <a href="#">Aide</a>
        </div>

    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

  </body>
</html>
       