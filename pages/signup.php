<?php
require_once __DIR__ . '/../includes/app.php';

cv_redirect_if_logged_in();

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $full_name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if ($full_name !== '' && $email !== '' && $password !== '') {
        $checkStmt = $pdo->prepare('SELECT Id_Utilisateur FROM utilisateur WHERE email = :email LIMIT 1');
        $checkStmt->execute([':email' => $email]);

        if ($checkStmt->fetch()) {
            $error = 'Cet email existe déjà.';
        } else {
            $insertStmt = $pdo->prepare('INSERT INTO utilisateur (nom, email, mot_de_passe, role) VALUES (:nom, :email, :mot_de_passe, :role)');
            $insertStmt->execute([
                ':nom' => $full_name,
                ':email' => $email,
                ':mot_de_passe' => password_hash($password, PASSWORD_DEFAULT),
                ':role' => 'user',
            ]);

            cv_flash_set('success', 'Compte créé avec succès. Vous pouvez vous connecter.');
            header('Location: login.php');
            exit();
        }
    } else {
        $error = 'Tous les champs sont obligatoires.';
    }
}
?>

<!doctype html>
<html lang="fr">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Inscription — ChronoVault</title>

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
          <span class="text-muted small">Déjà un compte ?</span>
          <a
            href="login.php"
            class="btn btn-outline-chrono py-2 px-3"
            style="font-size: 0.875rem"
            >Se connecter</a
          >
        </div>
      </div>
    </nav>

    <main class="auth-main">
      <div class="auth-card text-center">

        <div class="auth-logo-box mb-3">✨</div>

        <h2 class="auth-brand-title">ChronoVault</h2>
        <p class="auth-subtitle mb-4">Créer votre compte</p>

        <form method="POST">
          <div class="mb-3 text-start">
            <label class="form-label small text-muted">Nom</label>
       <input type="text" name="name" class="form-control" placeholder="Votre nom complet" required />
          </div>

          <div class="mb-3 text-start">
            <label class="form-label small text-muted">E-mail</label>
      <input type="email" name="email" class="form-control" placeholder="votre@email.com" required />
          </div>

          <div class="mb-3 text-start">
            <label class="form-label small text-muted">Mot de passe</label>
         <input type="password" name="password" class="form-control" placeholder="••••••••" required />
          </div>

          <div class="d-grid mt-4">
            <button type="submit" class="btn btn-chrono-gold">
              S'inscrire →
            </button>
          </div>

        <?php if ($error !== '') : ?>
          <p class="text-danger mt-3 small">
            <?= h($error) ?>
          </p>
        <?php endif; ?>
        </form>

        <p class="mt-4 small">
          Déjà un compte ?
          <a href="login.php" class="fw-bold" style="color: var(--primary)"
            >Se connecter</a
          >
        </p>

        <div class="auth-footer-links mt-4">
          <p class="small text-muted mb-1">© 2026 ChronoVault</p>
          <a href="#">Confidentialité</a> &nbsp;|&nbsp;
          <a href="#">Aide</a>
        </div>
      </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../js/main.js"></script>

  </body>
</html>