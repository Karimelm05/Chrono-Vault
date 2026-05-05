<?php
require_once __DIR__ . '/includes/app.php';

cv_redirect_if_logged_in('pages/dashboard.php');

if (cv_try_remember_login($pdo)) {
    header('Location: pages/dashboard.php');
    exit();
}
?>
<!doctype html>
<html lang="fr">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>ChronoVault — Vos souvenirs, à l'abri du temps</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet" />

    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;700;800&family=Manrope:wght@400;500;600&family=Material+Symbols+Outlined" rel="stylesheet" />

    <link rel="stylesheet" href="css/style.css" />
    <style>
      @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(30px); }
        to   { opacity: 1; transform: translateY(0); }
      }
      @keyframes fadeInLeft {
        from { opacity: 0; transform: translateX(-30px); }
        to   { opacity: 1; transform: translateX(0); }
      }
      @keyframes fadeInRight {
        from { opacity: 0; transform: translateX(30px); }
        to   { opacity: 1; transform: translateX(0); }
      }
      @keyframes float {
        0%, 100% { transform: translateY(0); }
        50%       { transform: translateY(-20px); }
      }
      @keyframes pulse {
        0%, 100% { transform: scale(1); }
        50%       { transform: scale(1.05); }
      }

      .animate-fade-up,
      .animate-fade-left,
      .animate-fade-right {
        opacity: 0;
        transition: none;
      }
      .animate-fade-up.is-visible    { animation: fadeInUp    0.8s ease forwards; }
      .animate-fade-left.is-visible  { animation: fadeInLeft  0.8s ease forwards; }
      .animate-fade-right.is-visible { animation: fadeInRight 0.8s ease forwards; }

      .delay-1 { animation-delay: 0.1s; }
      .delay-2 { animation-delay: 0.2s; }
      .delay-3 { animation-delay: 0.3s; }
      .delay-4 { animation-delay: 0.4s; }
      .delay-5 { animation-delay: 0.5s; }

      .floating-shapes {
        position: absolute;
        width: 100%;
        height: 100%;
        top: 0;
        left: 0;
        overflow: hidden;
        pointer-events: none;
        z-index: 0;
      }
      .floating-shapes .shape {
        position: absolute;
        border-radius: 50%;
        opacity: 0.1;
      }
      .floating-shapes .shape-1 {
        width: 300px; height: 300px;
        background: var(--primary);
        top: -100px; right: -50px;
        animation: float 6s ease-in-out infinite;
      }
      .floating-shapes .shape-2 {
        width: 200px; height: 200px;
        background: var(--secondary);
        bottom: -50px; left: -50px;
        animation: float 8s ease-in-out infinite reverse;
      }
      .floating-shapes .shape-3 {
        width: 150px; height: 150px;
        background: var(--secondary);
        top: 50%; left: 50%;
        animation: float 7s ease-in-out infinite;
      }

      .capsule-3d {
        position: relative;
        width: 350px;
        height: 350px;
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 1;
      }

      .capsule-body {
        position: relative;
        width: 180px;
        height: 180px;
        background: var(--gradient);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
        animation: pulse 3s ease-in-out infinite;
        z-index: 2;
      }
      .capsule-icon {
        font-size: 4rem;
                color: var(--primary);

        z-index: 2;
      }
      .capsule-glow {
        position: absolute;
        width: 100%;
        height: 100%;
        border-radius: 50%;
        background: var(--gradient);
        filter: blur(40px);
        opacity: 0.3;
        z-index: 1;
      }

      .capsule-ring {
        position: absolute;
        border-radius: 50%;
        border: 2px solid rgba(0, 0, 0, 0.1);
        z-index: 1;
      }
      .ring-1 { width: 230px; height: 230px; animation: pulse 4s ease-in-out infinite; }
      .ring-2 { width: 280px; height: 280px; animation: pulse 5s ease-in-out infinite reverse; }
      .ring-3 { width: 330px; height: 330px; animation: pulse 6s ease-in-out infinite; }

      .floating-item {
        position: absolute;
        width: 55px; height: 55px;
        background: white;
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.3rem;
        color: var(--primary);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
        animation: float 4s ease-in-out infinite;
        z-index: 3;
      }
      .item-1 { top: 20px;    right: 40px; animation-delay: 0s; }
      .item-2 { bottom: 40px; right: 20px; animation-delay: 1s; }
      .item-3 { top: 40px;    left: 20px;  animation-delay: 2s; }
      .item-4 { bottom: 20px; left: 40px;  animation-delay: 3s; }

      .nav-link.nav-active {
        font-weight: 700;
        color: var(--primary) !important;
      }
      .translate-right {
  transform: none;
}

@media (min-width: 992px) {
  .translate-right {
    transform: translateX(150px);
  }
}

.hero {
  position: relative;
  overflow: hidden; 
}
    </style>
  </head>

  <body>

    <nav class="navbar navbar-expand-lg navbar-custom fixed-top py-3">
      <div class="container">
        <a class="navbar-brand brand" href="#">ChronoVault</a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navMenu">
          <ul class="navbar-nav mx-auto gap-lg-4">
            <li class="nav-item"><a class="nav-link" href="#hero"         data-section="hero">Accueil</a></li>
            <li class="nav-item"><a class="nav-link" href="#features"     data-section="features">Fonctionnalités</a></li>
            <li class="nav-item"><a class="nav-link" href="#how"          data-section="how">Comment ça marche</a></li>
            <li class="nav-item"><a class="nav-link" href="#testimonials" data-section="testimonials">Témoignages</a></li>
          </ul>
          <div class="d-flex gap-2">
            <a href="pages/login.php"  class="btn btn-outline-chrono">Se connecter</a>
            <a href="pages/signup.php" class="btn btn-chrono">Commencer</a>
          </div>
        </div>
      </div>
    </nav>

    <section class="hero" id="hero">
       <div class="floating-shapes">
                <div class="shape shape-1"></div>
                <div class="shape shape-2"></div>
                <div class="shape shape-3"></div>
              </div>
      <div class="container">
        
        <div class="row align-items-center g-5">
          
          <div class="col-lg-6">
            
            <span class="hero-badge animate-fade-up delay-1">L'Archive Temporelle</span>
            <h1 class="hero-title mt-4 animate-fade-up delay-2">ChronoVault : Vos souvenirs, à l'abri du temps.</h1>
            <p class="hero-text mt-4 animate-fade-up delay-3">
              Sanctuaire numérique pour vos moments les plus précieux. Archivez
              aujourd'hui vos émotions et transmettez-les en toute sécurité à l'avenir.
            </p>
            <div class="d-flex flex-wrap gap-3 mt-5 animate-fade-up delay-4">
              <a href="pages/signup.php" class="btn btn-chrono">Créer une capsule</a>
              <a href="#features" class="btn btn-outline-chrono">En savoir plus</a>
            </div>
          </div>

          <div class="col-lg-6 animate-fade-right delay-2">
<div class="position-relative overflow-visible ps-lg-5 translate-right">
              <div class="capsule-3d">
                <div class="capsule-ring ring-1"></div>
                <div class="capsule-ring ring-2"></div>
                <div class="capsule-ring ring-3"></div>

                <div class="capsule-body">
                  <div class="capsule-icon">
                    <i class="bi bi-hourglass-split"></i>
                  </div>
                  <div class="capsule-glow"></div>
                </div>

                <div class="floating-item item-1"><i class="bi bi-image"></i></div>
                <div class="floating-item item-2"><i class="bi bi-chat-heart"></i></div>
                <div class="floating-item item-3"><i class="bi bi-lock-fill"></i></div>
                <div class="floating-item item-4"><i class="bi bi-people-fill"></i></div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section class="py-5" id="features">
      <div class="container py-5">
        <div class="text-center mb-5 animate-fade-up">
          <h2 class="section-title">Pourquoi choisir ChronoVault ?</h2>
          <p class="text-muted mt-3">La technologie au service de vos souvenirs.</p>
        </div>
        <div class="row g-4">
          <div class="col-md-6 col-lg-4 animate-fade-up delay-1">
            <div class="feature-card">
              <div class="feature-icon"><span class="material-symbols-outlined">update</span></div>
              <h4>Création différée</h4>
              <p class="text-muted mt-3">Préparez vos messages aujourd'hui pour les découvrir plus tard.</p>
            </div>
          </div>
          <div class="col-md-6 col-lg-4 animate-fade-up delay-2">
            <div class="feature-card">
              <div class="feature-icon"><span class="material-symbols-outlined">photo_library</span></div>
              <h4>Photos & Messages</h4>
              <p class="text-muted mt-3">Associez émotions, images et souvenirs précieux.</p>
            </div>
          </div>
          <div class="col-md-6 col-lg-4 animate-fade-up delay-3">
            <div class="feature-card">
              <div class="feature-icon"><span class="material-symbols-outlined">verified_user</span></div>
              <h4>Verrouillage sécurisé</h4>
              <p class="text-muted mt-3">Vos données sont protégées jusqu'à la date choisie.</p>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section class="py-5 bg-light" id="how">
      <div class="container py-5">
        <div class="text-center mb-5 animate-fade-up">
          <h2 class="section-title">Comment ça marche ?</h2>
        </div>
        <div class="row g-5 text-center">
          <div class="col-md-4 animate-fade-up delay-1">
            <div class="step-circle">1</div>
            <h4>Créer</h4>
            <p class="text-muted mt-3">Ouvrez une nouvelle capsule temporelle.</p>
          </div>
          <div class="col-md-4 animate-fade-up delay-2">
            <div class="step-circle">2</div>
            <h4>Ajouter du contenu</h4>
            <p class="text-muted mt-3">Ajoutez photos, vidéos et messages.</p>
          </div>
          <div class="col-md-4 animate-fade-up delay-3">
            <div class="step-circle">3</div>
            <h4>Découvrir</h4>
            <p class="text-muted mt-3">Redécouvrez vos souvenirs plus tard.</p>
          </div>
        </div>
      </div>
    </section>

    <section class="py-5" id="testimonials">
      <div class="container py-5">
        <div class="text-center mb-5 animate-fade-up">
          <h2 class="section-title">Ils nous font confiance</h2>
        </div>
        <div class="row g-4">
          <div class="col-lg-4 animate-fade-up delay-1">
            <div class="testimonial">
              <p class="fst-italic">"Une expérience magnifique pour préserver nos souvenirs."</p>
              <h6 class="mt-4 mb-0 fw-bold">Lucas M.</h6>
            </div>
          </div>
          <div class="col-lg-4 animate-fade-up delay-2">
            <div class="testimonial testimonial-primary">
              <p class="fst-italic">"Le plus beau cadeau émotionnel que nous ayons créé."</p>
              <h6 class="mt-4 mb-0 fw-bold">Sarah J.</h6>
            </div>
          </div>
          <div class="col-lg-4 animate-fade-up delay-3">
            <div class="testimonial">
              <p class="fst-italic">"Simple, élégant et très sécurisé."</p>
              <h6 class="mt-4 mb-0 fw-bold">Collectif Horizon</h6>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section class="py-5">
      <div class="container py-5">
        <div class="d-flex justify-content-between align-items-center mb-5 animate-fade-up">
          <div>
            <h2 class="section-title">Galerie de souvenirs</h2>
            <p class="text-muted">Capsules en attente d'ouverture.</p>
          </div>
        </div>
        <div class="row g-4">
          <div class="col-sm-6 col-lg-3 animate-fade-up delay-1">
            <div class="gallery-card"><img src="images/chrono-vault-index-2.jpg" alt="Capsule souvenir 1" loading="lazy" /></div>
          </div>
          <div class="col-sm-6 col-lg-3 animate-fade-up delay-2">
            <div class="gallery-card"><img src="images/chrono-vault-index-3.jpg" alt="Capsule souvenir 2" loading="lazy" /></div>
          </div>
          <div class="col-sm-6 col-lg-3 animate-fade-up delay-3">
            <div class="gallery-card"><img src="images/chrono-vault-index-4.jpg" alt="Capsule souvenir 3" loading="lazy" /></div>
          </div>
          <div class="col-sm-6 col-lg-3 animate-fade-up delay-4">
            <div class="gallery-card"><img src="images/chrono-vault-index-5.jpg" alt="Capsule souvenir 4" loading="lazy" /></div>
          </div>
        </div>
      </div>
    </section>

    <footer class="py-5">
      <div class="container">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-center gap-4">
          <p class="small text-muted mb-0">© 2026 ChronoVault — Tous droits réservés.</p>
          <div class="d-flex gap-4">
            <a href="#">Mentions légales</a>
            <a href="#">Confidentialité</a>
            <a href="#">Contact</a>
          </div>
        </div>
      </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
      const animObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
          if (entry.isIntersecting) {
            entry.target.classList.add('is-visible');
            animObserver.unobserve(entry.target); // fire once only
          }
        });
      }, { threshold: 0.15 });

      document.querySelectorAll('.animate-fade-up, .animate-fade-left, .animate-fade-right')
        .forEach(el => animObserver.observe(el));

      document.querySelectorAll('#hero .animate-fade-up, #hero .animate-fade-right')
        .forEach(el => el.classList.add('is-visible'));

      const sections = document.querySelectorAll('section[id]');
      const navLinks = document.querySelectorAll('.navbar-nav .nav-link[data-section]');

      const navObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
          if (entry.isIntersecting) {
            navLinks.forEach(link => link.classList.remove('nav-active'));
            const active = document.querySelector(`.nav-link[data-section="${entry.target.id}"]`);
            if (active) active.classList.add('nav-active');
          }
        });
      }, { rootMargin: '-40% 0px -55% 0px' });

      sections.forEach(section => navObserver.observe(section));
    </script>
  </body>
</html>