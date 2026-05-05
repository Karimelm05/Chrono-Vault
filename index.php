<!doctype html>
<html lang="fr">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>ChronoVault — Vos souvenirs, à l'abri du temps</title>

    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
      rel="stylesheet" />

    <link
      href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;700;800&family=Manrope:wght@400;500;600&display=swap"
      rel="stylesheet" />

    <link
      href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined"
      rel="stylesheet" />

    <link rel="stylesheet" href="css/style.css" />
  </head>

  <body>

    <nav class="navbar navbar-expand-lg navbar-custom fixed-top py-3">
      <div class="container">
        <a class="navbar-brand brand" href="#">ChronoVault</a>

        <button
          class="navbar-toggler"
          type="button"
          data-bs-toggle="collapse"
          data-bs-target="#navMenu">
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navMenu">
          <ul class="navbar-nav mx-auto gap-lg-4">
            <li class="nav-item">
              <a class="nav-link fw-bold text-dark" href="#">Accueil</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#features">Fonctionnalités</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#how">Comment ça marche</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#testimonials">Témoignages</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#contact">Contact</a>
            </li>
          </ul>

          <div>
            <a href="pages/login.php" class="btn btn-chrono">Commencer</a>
          </div>
        </div>
      </div>
    </nav>

    <section class="hero">
      <div class="container">
        <div class="row align-items-center g-5">
          <div class="col-lg-6">
            <span class="hero-badge">L'Archive Temporelle</span>

            <h1 class="hero-title mt-4">
              ChronoVault : Vos souvenirs, à l'abri du temps.
            </h1>

            <p class="hero-text mt-4">
              Sanctuaire numérique pour vos moments les plus précieux. Archivez
              aujourd'hui vos émotions et transmettez-les en toute sécurité à
              l'avenir.
            </p>

            <div class="d-flex flex-wrap gap-3 mt-5">
              <a href="pages/signup.php" class="btn btn-chrono">Créer une capsule</a>
              <a href="#features" class="btn btn-outline-chrono"
                >En savoir plus</a
              >
            </div>
          </div>

          <div class="col-lg-6">
            <div class="hero-card">
              <img
                src="https://images.unsplash.com/photo-1517841905240-472988babdf9?q=80&w=1200"
                alt="ChronoVault" />
            </div>
          </div>
        </div>
      </div>
    </section>

    <section class="py-5" id="features">
      <div class="container py-5">
        <div class="text-center mb-5">
          <h2 class="section-title">Pourquoi choisir ChronoVault ?</h2>
          <p class="text-muted mt-3">
            La technologie au service de vos souvenirs.
          </p>
        </div>

        <div class="row g-4">
          <div class="col-md-6 col-lg-4">
            <div class="feature-card">
              <div class="feature-icon">
                <span class="material-symbols-outlined">update</span>
              </div>
              <h4>Création différée</h4>
              <p class="text-muted mt-3">
                Préparez vos messages aujourd'hui pour les découvrir plus tard.
              </p>
            </div>
          </div>

          <div class="col-md-6 col-lg-4">
            <div class="feature-card">
              <div class="feature-icon">
                <span class="material-symbols-outlined">photo_library</span>
              </div>
              <h4>Photos & Messages</h4>
              <p class="text-muted mt-3">
                Associez émotions, images et souvenirs précieux.
              </p>
            </div>
          </div>

          <div class="col-md-6 col-lg-4">
            <div class="feature-card">
              <div class="feature-icon">
                <span class="material-symbols-outlined">verified_user</span>
              </div>
              <h4>Verrouillage sécurisé</h4>
              <p class="text-muted mt-3">
                Vos données sont protégées jusqu'à la date choisie.
              </p>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section class="py-5 bg-light" id="how">
      <div class="container py-5">
        <div class="text-center mb-5">
          <h2 class="section-title">Comment ça marche ?</h2>
        </div>

        <div class="row g-5 text-center">
          <div class="col-md-4">
            <div class="step-circle">1</div>
            <h4>Créer</h4>
            <p class="text-muted mt-3">
              Ouvrez une nouvelle capsule temporelle.
            </p>
          </div>

          <div class="col-md-4">
            <div class="step-circle">2</div>
            <h4>Ajouter du contenu</h4>
            <p class="text-muted mt-3">Ajoutez photos, vidéos et messages.</p>
          </div>

          <div class="col-md-4">
            <div class="step-circle">3</div>
            <h4>Découvrir</h4>
            <p class="text-muted mt-3">Redécouvrez vos souvenirs plus tard.</p>
          </div>
        </div>
      </div>
    </section>

    <section class="py-5" id="testimonials">
      <div class="container py-5">
        <div class="text-center mb-5">
          <h2 class="section-title">Ils nous font confiance</h2>
        </div>

        <div class="row g-4">
          <div class="col-lg-4">
            <div class="testimonial">
              <p class="fst-italic">
                "Une expérience magnifique pour préserver nos souvenirs."
              </p>
              <h6 class="mt-4 mb-0 fw-bold">Lucas M.</h6>
            </div>
          </div>

          <div class="col-lg-4">
            <div class="testimonial testimonial-primary">
              <p class="fst-italic">
                "Le plus beau cadeau émotionnel que nous ayons créé."
              </p>
              <h6 class="mt-4 mb-0 fw-bold">Sarah J.</h6>
            </div>
          </div>

          <div class="col-lg-4">
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
        <div class="d-flex justify-content-between align-items-center mb-5">
          <div>
            <h2 class="section-title">Galerie de souvenirs</h2>
            <p class="text-muted">Capsules en attente d'ouverture.</p>
          </div>
        </div>

        <div class="row g-4">
          <div class="col-sm-6 col-lg-3">
            <div class="gallery-card">
              <img
                src="https://images.unsplash.com/photo-1529156069898-49953e39b3ac?q=80&w=1200"
                alt="" />
            </div>
          </div>
          <div class="col-sm-6 col-lg-3">
            <div class="gallery-card">
              <img
                src="https://images.unsplash.com/photo-1500530855697-b586d89ba3ee?q=80&w=1200"
                alt="" />
            </div>
          </div>
          <div class="col-sm-6 col-lg-3">
            <div class="gallery-card">
              <img
                src="https://images.unsplash.com/photo-1511988617509-a57c8a288659?q=80&w=1200"
                alt="" />
            </div>
          </div>
          <div class="col-sm-6 col-lg-3">
            <div class="gallery-card">
              <img
                src="https://images.unsplash.com/photo-1516321318423-f06f85e504b3?q=80&w=1200"
                alt="" />
            </div>
          </div>
        </div>
      </div>
    </section>

    <section class="py-5 bg-light" id="contact">
      <div class="container py-5">
        <div class="contact-box">
          <div class="text-center mb-5">
            <h2 class="section-title">Contactez-nous</h2>
            <p class="text-muted mt-3">Une question ? Notre équipe est là.</p>
          </div>

          <form>
            <div class="row g-4">
              <div class="col-md-6">
                <input
                  type="text"
                  class="form-control"
                  placeholder="Nom complet" />
              </div>
              <div class="col-md-6">
                <input
                  type="email"
                  class="form-control"
                  placeholder="Adresse email" />
              </div>
              <div class="col-12">
                <select class="form-select">
                  <option>Information générale</option>
                  <option>Support technique</option>
                  <option>Partenariat</option>
                </select>
              </div>
              <div class="col-12">
                <textarea
                  class="form-control"
                  rows="6"
                  placeholder="Votre message"></textarea>
              </div>
              <div class="col-12">
                <button class="btn btn-chrono w-100 py-3">
                  Envoyer le message
                </button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </section>

    <footer class="py-5">
      <div class="container">
        <div
          class="d-flex flex-column flex-md-row justify-content-between align-items-center gap-4">
          <p class="small text-muted mb-0">
            © 2026 ChronoVault — Tous droits réservés.
          </p>
          <div class="d-flex gap-4">
            <a href="#">Mentions légales</a>
            <a href="#">Confidentialité</a>
            <a href="#">Contact</a>
          </div>
        </div>
      </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  </body>
</html>