<?php
$pageTitle = 'Mes Capsules | ChronoVault';
$activePage = 'capsules';
require_once __DIR__ . '/../includes/layout.php';
?>

<header class="page-header">
  <div class="d-flex justify-content-between align-items-end mb-4">
    <div>
      <div class="page-title-bar">
        <div class="title-accent"></div>
        <h2 class="page-title">Mes Capsules</h2>
      </div>
      <p class="page-subtitle mb-0">Gérez vos souvenirs et vos messages pour le futur.</p>
    </div>
    <a class="btn-primary-cv text-decoration-none" href="new-capsule.php">
      <span class="material-symbols-outlined">add_circle</span>
      Nouvelle Capsule
    </a>
  </div>

  <div class="filter-bar">
    <div class="search-wrapper">
      <span class="material-symbols-outlined">search</span>
      <input class="search-input" type="text" placeholder="Rechercher une capsule..."/>
    </div>
    <div class="d-flex gap-2">
      <button class="btn-filter">
        <span class="material-symbols-outlined" style="font-size:16px">filter_list</span>
        Filtres
      </button>
      <button class="btn-filter">
        <span class="material-symbols-outlined" style="font-size:16px">sort</span>
        Trier par
      </button>
    </div>
  </div>
</header>

<section class="cards-section">
  <div class="row g-4">
    <div class="col-12 col-md-6 col-lg-4">
      <div class="capsule-card">
        <div class="card-img-wrapper">
          <img src="https://lh3.googleusercontent.com/aida-public/AB6AXuDySS2zk9Jy97yquHGPbQ6m3HyxvUY69SN0dsxvYu7EkmYZM8X-OJSfIvo5XAKnMCXP_VfX18I1yL8V3nIBrZKyHxntreZPlbs1Me1dymTZKYtrH8WWVHMuBm_eO4OgCB1AObpb-EdJV_wJ5vFqrpOXV1vhI3Bc0-2InN7OD3OWdm3eU3qu5jK5-u2eSIA56i2W10hj3rxCeEVklpByH0QTQBwdPrsoPrNJRal67tiieWhqTx50zdXctMzEJNB5PTd1MQC8cCNPh1vm" alt="Journal"/>
          <div class="card-badges">
            <span class="badge-cv badge-sealed">Scellé</span>
          </div>
        </div>
        <div class="card-body-cv">
          <p class="card-category">Héritage Familial</p>
          <h3 class="card-title-cv">Lettre à mon fils (2045)</h3>
          <p class="card-desc">Un message d'espoir et de sagesse pour le jour de son 21ème anniversaire.</p>
          <div class="card-footer-cv">
            <div>
              <div class="open-label">Ouverture dans</div>
              <div class="open-value">18 ans, 4 mois</div>
            </div>
            <div class="avatar-solo">
              <span class="material-symbols-outlined" style="font-size:14px">person</span>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="col-12 col-md-6 col-lg-4">
      <div class="capsule-card">
        <div class="card-img-wrapper">
          <img src="https://lh3.googleusercontent.com/aida-public/AB6AXuBxbHimvHrCWw0_izb8hcaqwC_k8WD220u8zKBe4XHP86Zh-zDFNb7F5oRMVa1Hb7OwP4_wAoXYCE_FOq5gmPg32xZk5Ftp56NlkOCWgCDHEQDVusrxjhsyyFF2crXKe_sfbW-GpVKIDme4PtqCvSxx3vH-MtDnnKuFOWGUZgk5O1i3_51xufoOkYYpBv0ieltw6bEwxj3ekKYu_4MqZ9XiS1H_RTtwR_9E7OmKlfkQiEAytOR9XkPIPLLSbGemACqZ6FZaLo98i-" alt="Montre"/>
          <div class="card-badges">
            <span class="badge-cv badge-soon">Presque prêt</span>
          </div>
        </div>
        <div class="card-body-cv">
          <p class="card-category">Projet Personnel</p>
          <h3 class="card-title-cv">Objectifs 10 ans</h3>
          <p class="card-desc">Réflexions sur ma carrière et ma vision du futur capturées en 2016.</p>
          <div class="card-footer-cv">
            <div>
              <div class="open-label">Ouverture dans</div>
              <div class="open-value">12 jours</div>
            </div>
            <span class="material-symbols-outlined" style="color:var(--color-primary)">lock_open</span>
          </div>
        </div>
      </div>
    </div>

    <div class="col-12 col-md-6 col-lg-4">
      <div class="capsule-card draft">
        <div class="card-img-wrapper muted">
          <img src="https://lh3.googleusercontent.com/aida-public/AB6AXuDgE9-cBkqBV3gCycBfvpyr8SGUoFaX-gY7GfqCSVHrxzqHvK-_XS7uslbakg1PgcbGsZ6NXB52_5LOMkVBspzQrKb5cBQRl7sZit1OrWcppRIcPpT3GRYvnfkUndWiwkq5OrQc4-7jzfRzrsugOx6634p6QX7zs_3Rw7wHz4rLXCNBHrJIyVOLMB_3JulYxaEX-sp_K0Gy7HiwOUk31yZniHbiF5BCb8M4MfMOAns8PaXa3J8Xz5tND8SUyeICoUJeW6w-NEAiwlG6" alt="Workspace"/>
          <div class="card-badges">
            <span class="badge-cv badge-draft">Brouillon</span>
          </div>
        </div>
        <div class="card-body-cv">
          <p class="card-category muted">Non spécifié</p>
          <h3 class="card-title-cv muted-title">Souvenirs de voyage (Italie)</h3>
          <p class="card-desc">Ajouter les photos de Rome et la vidéo de la Toscane avant de sceller.</p>
          <div class="card-footer-cv no-border" style="gap:0.5rem">
            <button class="btn-continue">Continuer</button>
            <button class="btn-delete">
              <span class="material-symbols-outlined" style="font-size:16px">delete</span>
            </button>
          </div>
        </div>
      </div>
    </div>

    <div class="col-12 col-md-6 col-lg-4">
      <div class="capsule-card">
        <div class="card-img-wrapper">
          <img src="https://lh3.googleusercontent.com/aida-public/AB6AXuAxOMr5pdKrU4XvE3stCl6bmvwsP6qTOx16_7z2iZ8AlTBwL1bO0edTv-wK9ZBYH8tn0PgqLNd2XhDQUVHAn29ydfFRDwPZnxnRkdzjraiCDvl6_4m8o7rk-4c56q6DDjiJcKX0G3JyOOjtYOD43ApCZNbxLnQqkHWJ-_YOLKI585lwKvHwki993eXz0NsIwRcQ68lzT0GqKVb5RYrulNpziOH_Osy--WyLONqqjvLON7-uonm-y9nx-GPuNTwauFK0oQFjfLvzrnV9" alt="Couple plage"/>
          <div class="card-badges">
            <span class="badge-cv badge-shared">Partagé</span>
            <span class="badge-cv badge-sealed">Scellé</span>
          </div>
        </div>
        <div class="card-body-cv">
          <p class="card-category">Amis Proches</p>
          <h3 class="card-title-cv">Retrouvailles 2030</h3>
          <p class="card-desc">Capsule collective créée lors du mariage de Sophie. À ouvrir tous ensemble.</p>
          <div class="card-footer-cv">
            <div>
              <div class="open-label">Ouverture dans</div>
              <div class="open-value">4 ans, 2 mois</div>
            </div>
            <div class="avatar-stack">
              <div class="avatar-count">+3</div>
              <img src="https://lh3.googleusercontent.com/aida-public/AB6AXuD5yW82QF_gl0ce4LxtWjz-Bg9c7mUnCxliFsmHsMOO-wNe_mZcxG8GA9XOfIwlysgKqwQRtkzET3niMfplAHk83kjLG3FVDY9NL48hm5k98sB1-IBO_cxsL6vTMObJDRgLKp0CWKCkCGqvv9P6Qw0w9rgKqwO66maoVoJ-H9V1X1bZqBhTHZasBeym89sjuwqYASJBe6wWSmWpRqhoMw3-FyrTLFPDgpwPgQ1737e9LlqOfFdlrP2THkSo5WMlFjExH2lNQ5oQXVL-" alt="Avatar 2"/>
              <img src="https://lh3.googleusercontent.com/aida-public/AB6AXuCvUc-2wM-s5fK6reB1YhQsDCq0grL8mvO7WIVkwpovp9GJ3mX5Q5su4LkO5sOJLS6PdsRLIML8UqZtDg7DTEnLMYqYvc7KTs-LkII2dEO17Q8PqEnHLlNNkP2zOkAEBKayAHSONeQzEv5txOJIJItCij9nmHyy_-bvtv1avVOsRLB3FNU4GvyyWxIWC2r4sGx_RrN3K7PFtjfX-wyQO_bVfqVoQibwLLOGBj0EBTJbUpRnovhF_2japlVEo4Rn4J9OY2cyPtEv_xAY" alt="Avatar 1"/>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
