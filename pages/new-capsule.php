<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="utf-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Nouvelle Capsule | ChronoVault</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"/>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet"/>
  <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>

  <style>
    /* â”€â”€ CSS Variables â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€ */
    :root {
      --color-primary:            #6c2f00;
      --color-primary-container:  #8b4513;
      --color-secondary:          #7c572d;
      --color-secondary-container:#fecb97;
      --color-on-secondary-container: #79542a;
      --color-surface:            #fdf9f1;
      --color-surface-container:  #f1ede5;
      --color-surface-container-low: #f7f3eb;
      --color-surface-container-high: #ece8e0;
      --color-surface-container-highest: #e6e2da;
      --color-on-surface:         #1c1c17;
      --color-on-surface-variant: #54433a;
      --color-outline:            #877369;
      --color-outline-variant:    #dac2b6;
      --color-tertiary-fixed-dim: #e7c446;
      --color-on-tertiary-fixed:  #231b00;
      --color-error:              #ba1a1a;
      --color-error-container:    #ffdad6;
      --sidebar-width:            260px;
    }

    /* â”€â”€ Base â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€ */
    *, *::before, *::after { box-sizing: border-box; }
    body {
      font-family: 'Plus Jakarta Sans', sans-serif;
      background: var(--color-surface);
      color: var(--color-on-surface);
      min-height: 100vh;
      display: flex;
    }
    .material-symbols-outlined {
      font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
      font-size: 20px;
      vertical-align: middle;
      line-height: 1;
    }

    /* â”€â”€ Sidebar â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€ */
    #sidebar {
      width: var(--sidebar-width);
      min-height: 100vh;
      background: #f5f2ec;
      border-right: 1px solid var(--color-outline-variant);
      display: flex;
      flex-direction: column;
      padding: 1.5rem 1rem;
      position: sticky;
      top: 0;
      flex-shrink: 0;
    }
    .brand-name { font-size: 1.15rem; font-weight: 900; color: #3b1a08; letter-spacing: -0.04em; }
    .brand-sub  { font-size: 0.65rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.14em; color: var(--color-outline); margin-top: 2px; }

    .nav-link-item {
      display: flex; align-items: center; gap: 0.75rem;
      padding: 0.65rem 1rem; border-radius: 0.5rem;
      font-size: 0.9rem; font-weight: 500; color: #78716c;
      text-decoration: none; transition: background 0.15s, color 0.15s;
    }
    .nav-link-item:hover { background: #e7e3dc; color: var(--color-on-surface); }
    .nav-link-item.active {
      background: rgba(231,227,220,0.5);
      color: #78350f; font-weight: 600;
    }
    .nav-link-item.active .material-symbols-outlined {
      font-variation-settings: 'FILL' 1, 'wght' 500, 'GRAD' 0, 'opsz' 24;
    }
    .sidebar-divider { border-top: 1px solid var(--color-outline-variant); margin: 0.75rem 0; }
    .user-avatar { width: 34px; height: 34px; border-radius: 50%; object-fit: cover; }
    .user-name   { font-size: 0.875rem; font-weight: 700; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }

    /* â”€â”€ Main â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€ */
    #main {
      flex: 1; min-width: 0; background: #fff;
      display: flex; flex-direction: column;
    }

    /* â”€â”€ Page Header â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€ */
    .page-header { padding: 3rem 3rem 0; }
    .back-btn {
      background: none; border: none; cursor: pointer;
      color: var(--color-on-surface-variant); padding: 0;
      display: inline-flex; align-items: center; gap: 0.3rem;
      font-family: 'Plus Jakarta Sans', sans-serif;
      font-size: 0.85rem; font-weight: 600;
      transition: color 0.15s;
    }
    .back-btn:hover { color: var(--color-primary); }
    .page-title   { font-size: 2.25rem; font-weight: 800; letter-spacing: -0.03em; margin: 0.2rem 0 0.15rem; }
    .page-subtitle { color: var(--color-on-surface-variant); font-weight: 500; font-size: 0.95rem; }

    /* â”€â”€ Stepper â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€ */
    .stepper {
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 0.75rem;
      margin: 2rem auto 0;
      width: 100%;
      max-width: 680px;
    }
    .step-item {
      display: flex;
      align-items: center;
      gap: 0.6rem;
      flex: 0 0 auto;
    }
    .step-circle {
      width: 32px; height: 32px; border-radius: 50%;
      display: flex; align-items: center; justify-content: center;
      font-size: 0.8rem; font-weight: 700;
      background: var(--color-surface-container-highest);
      color: var(--color-on-surface-variant);
      border: 2px solid var(--color-outline-variant);
      flex-shrink: 0; transition: all 0.3s;
    }
    .step-circle.active  { background: var(--color-tertiary-fixed-dim); color: var(--color-on-tertiary-fixed); border-color: var(--color-tertiary-fixed-dim); }
    .step-circle.done    { background: var(--color-tertiary-fixed-dim); color: var(--color-on-tertiary-fixed); border-color: var(--color-tertiary-fixed-dim); }
    .step-label {
      font-size: 0.82rem; font-weight: 600;
      color: var(--color-on-surface-variant);
      white-space: nowrap;
    }
    .step-label.active { color: var(--color-on-surface); }
    .step-connector {
      flex: 1 1 72px;
      min-width: 56px;
      height: 2px;
      background: var(--color-outline-variant);
      transition: background 0.3s;
    }
    .step-connector.done { background: var(--color-tertiary-fixed-dim); }

    /* â”€â”€ Step Content Area â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€ */
    .step-content {
      padding: 2rem 3rem 5rem;
      display: flex;
      justify-content: center;
    }

    .card-cv {
      background: var(--color-surface-container-low);
      border: 1px solid var(--color-outline-variant);
      border-radius: 0.875rem;
      padding: 1.75rem;
      max-width: 720px;
    }
    .card-cv-title {
      font-size: 1.05rem; font-weight: 700;
      color: var(--color-on-surface);
      display: flex; align-items: center; gap: 0.5rem;
      margin-bottom: 0.2rem;
    }
    .card-cv-subtitle {
      font-size: 0.82rem; color: var(--color-on-surface-variant);
      margin-bottom: 1.5rem;
    }

    /* â”€â”€ Form Elements â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€ */
    .form-label-cv {
      font-size: 0.82rem; font-weight: 700;
      color: var(--color-on-surface); margin-bottom: 0.4rem;
      display: block;
    }
    .form-input-cv {
      width: 100%;
      background: #fff;
      border: 1.5px solid var(--color-outline-variant);
      border-radius: 0.5rem;
      padding: 0.7rem 0.9rem;
      font-family: 'Plus Jakarta Sans', sans-serif;
      font-size: 0.875rem;
      color: var(--color-on-surface);
      outline: none;
      transition: border-color 0.2s, box-shadow 0.2s;
    }
    .form-input-cv::placeholder { color: var(--color-outline); }
    .form-input-cv:focus {
      border-color: var(--color-primary);
      box-shadow: 0 0 0 3px rgba(108,47,0,0.1);
    }
    textarea.form-input-cv { resize: vertical; min-height: 110px; }

    /* Date input with icon wrapper */
    .input-icon-wrap {
      position: relative;
    }
    .input-icon-wrap .material-symbols-outlined {
      position: absolute; left: 0.9rem; top: 50%;
      transform: translateY(-50%);
      color: var(--color-on-surface-variant); font-size: 18px;
    }
    .input-icon-wrap .form-input-cv { padding-left: 2.5rem; }

    .form-hint {
      font-size: 0.75rem; color: var(--color-on-surface-variant);
      margin-top: 0.4rem;
    }

    /* â”€â”€ Lock preview box â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€ */
    .lock-preview {
      background: var(--color-surface-container-low);
      border: 1.5px solid var(--color-outline-variant);
      border-radius: 0.75rem;
      padding: 1rem 1.25rem;
      display: flex; align-items: center; gap: 0.9rem;
      margin-top: 1.25rem;
    }
    .lock-icon-wrap {
      width: 40px; height: 40px; border-radius: 50%;
      background: rgba(108,47,0,0.08);
      display: flex; align-items: center; justify-content: center;
      flex-shrink: 0;
    }
    .lock-preview-title { font-size: 0.9rem; font-weight: 700; }
    .lock-preview-sub   { font-size: 0.78rem; color: var(--color-on-surface-variant); }

    /* â”€â”€ Email invite area â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€ */
    .email-input-row {
      display: flex; gap: 0.5rem; align-items: stretch;
    }
    .email-input-row .form-input-cv { flex: 1; }
    .btn-add-email {
      width: 40px; height: 40px; border-radius: 0.5rem;
      background: var(--color-primary); color: #fff;
      border: none; display: flex; align-items: center; justify-content: center;
      cursor: pointer; flex-shrink: 0;
      font-size: 20px; font-weight: 700;
      transition: background 0.15s;
    }
    .btn-add-email:hover { background: var(--color-primary-container); }

    .tag-list { display: flex; flex-wrap: wrap; gap: 0.4rem; margin-top: 0.75rem; }
    .email-tag {
      display: inline-flex; align-items: center; gap: 0.35rem;
      background: var(--color-tertiary-fixed-dim);
      color: var(--color-on-tertiary-fixed);
      padding: 0.3rem 0.65rem; border-radius: 9999px;
      font-size: 0.75rem; font-weight: 600;
    }
    .email-tag .material-symbols-outlined { font-size: 14px; cursor: pointer; opacity: 0.7; }
    .email-tag .material-symbols-outlined:hover { opacity: 1; }

    .info-box {
      background: var(--color-surface-container-low);
      border-radius: 0.65rem;
      padding: 0.9rem 1rem;
      font-size: 0.78rem;
      color: var(--color-on-surface-variant);
      line-height: 1.5;
      margin-top: 1rem;
    }

    /* Recap table */
    .recap-table { margin-top: 1.5rem; }
    .recap-title { font-size: 0.9rem; font-weight: 700; margin-bottom: 0.75rem; }
    .recap-row {
      display: flex; justify-content: space-between; align-items: center;
      padding: 0.55rem 0;
      border-bottom: 1px solid var(--color-outline-variant);
      font-size: 0.85rem;
    }
    .recap-row:last-child { border-bottom: none; }
    .recap-key   { color: var(--color-on-surface-variant); font-weight: 500; }
    .recap-value { font-weight: 700; color: var(--color-on-surface); text-align: right; }

    /* â”€â”€ Buttons â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€ */
    .btn-primary-cv {
      background: var(--color-primary); color: #fff;
      border: none; padding: 0.7rem 1.6rem;
      border-radius: 0.5rem; font-weight: 700; font-size: 0.875rem;
      font-family: 'Plus Jakarta Sans', sans-serif;
      display: inline-flex; align-items: center; gap: 0.4rem;
      box-shadow: 0 4px 15px rgba(108,47,0,0.15);
      cursor: pointer; transition: background 0.15s, transform 0.1s;
    }
    .btn-primary-cv:hover   { background: var(--color-primary-container); }
    .btn-primary-cv:active  { transform: scale(0.97); }

    .btn-secondary-cv {
      background: transparent; color: var(--color-on-surface);
      border: 1.5px solid var(--color-outline-variant);
      padding: 0.65rem 1.4rem;
      border-radius: 0.5rem; font-weight: 700; font-size: 0.875rem;
      font-family: 'Plus Jakarta Sans', sans-serif;
      cursor: pointer; transition: background 0.15s;
    }
    .btn-secondary-cv:hover { background: var(--color-surface-container-low); }

    .btn-row {
      display: flex; justify-content: space-between; align-items: center;
      margin-top: 1.75rem; gap: 0.75rem;
    }
    .btn-row.end { justify-content: flex-end; }

    /* â”€â”€ Footer â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€ */
    .page-footer {
      position: fixed; bottom: 0;
      left: var(--sidebar-width); right: 0;
      border-top: 1px solid rgba(218,194,182,0.25);
      background: #faf7f2; z-index: 40;
      padding: 1.2rem 3rem;
      display: flex; justify-content: space-between; align-items: center;
    }
    .footer-copy, .footer-links a {
      font-size: 0.65rem; text-transform: uppercase;
      letter-spacing: 0.1em; color: #a8a29e; text-decoration: none;
    }
    .footer-links { display: flex; gap: 2rem; }
    .footer-links a:hover { color: #92400e; }

    /* â”€â”€ Step visibility â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€ */
    .step-panel { display: none; }
    .step-panel.active {
      display: block;
      width: 100%;
      max-width: 720px;
      background: var(--color-surface);
    }

    /* â”€â”€ Fade-in animation â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€ */
    @keyframes fadeSlideIn {
      from { opacity: 0; transform: translateY(14px); }
      to   { opacity: 1; transform: translateY(0); }
    }
    .step-panel.active { animation: fadeSlideIn 0.3s ease both; }
  </style>
</head>
<body>

  <!-- â•â• SIDEBAR â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â• -->
  <aside id="sidebar">
    <div class="mb-4 px-2">
      <div class="brand-name">ChronoVault</div>
      <div class="brand-sub">The Timeless Curator</div>
    </div>
    <nav class="flex-grow-1 d-flex flex-column gap-1">
      <a href="#" class="nav-link-item">
        <span class="material-symbols-outlined">dashboard</span>
        <span>Dashboard</span>
      </a>
      <a href="#" class="nav-link-item">
        <span class="material-symbols-outlined">inventory_2</span>
        <span>Mes Capsules</span>
      </a>
      <a href="#" class="nav-link-item active">
        <span class="material-symbols-outlined">auto_awesome</span>
        <span>Nouvelle Capsule</span>
      </a>
      <a href="#" class="nav-link-item">
        <span class="material-symbols-outlined">notifications</span>
        <span>Notifications</span>
      </a>
      <a href="#" class="nav-link-item">
        <span class="material-symbols-outlined">settings</span>
        <span>ParamÃ¨tres</span>
      </a>
    </nav>
    <div class="mt-auto">
      <div class="sidebar-divider"></div>
      <a href="#" class="nav-link-item">
        <span class="material-symbols-outlined">help</span>
        <span>Aide</span>
      </a>
      <a href="#" class="nav-link-item">
        <span class="material-symbols-outlined">logout</span>
        <span>DÃ©connexion</span>
      </a>
      <div class="d-flex align-items-center gap-2 px-3 py-2 mt-2">
        <img src="https://lh3.googleusercontent.com/aida-public/AB6AXuCuDd-TmfhHzFEd72RVUQR1QLqv3rap1YuN2tD4wPGsuEuj2TRdZnhQp852Q-_MgU_-CJMOF83pjT582yPw5Bh4zSkjTqAa9jcguFJ6Yg4evelTl__N24VzM540KrOqNwxetmthLkbBlb3LoqzDBCtUKR8NbtfnN2kvcGhVchmAUEp4vhpgcsVSUiJzlw3FaD5bUmVjtFXD3nenzZEZ2yUArKpglz317i6iqEgJro57xU2B7iwls5vKnEy2_VUs4nf5kiHhmj_PgMyV"
             alt="Marc-Antoine" class="user-avatar"/>
        <div class="user-name">Marc-Antoine</div>
      </div>
    </div>
  </aside>

  <!-- â•â• MAIN â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â• -->
  <main id="main">

    <!-- Page Header -->
    <header class="page-header">
      <button class="back-btn mb-2" onclick="goBack()">
        <span class="material-symbols-outlined" style="font-size:18px">arrow_back</span>
        Retour
      </button>
      <h1 class="page-title">Nouvelle capsule</h1>
      <p class="page-subtitle mb-0">CrÃ©ez une capsule temporelle avec vos amis</p>

      <!-- Stepper -->
      <div class="stepper" id="stepper">
        <div class="step-item">
          <div class="step-circle active" id="circle-1">1</div>
          <span class="step-label active" id="label-1">Informations</span>
        </div>
        <div class="step-connector" id="conn-1"></div>
        <div class="step-item">
          <div class="step-circle" id="circle-2">2</div>
          <span class="step-label" id="label-2">Date</span>
        </div>
        <div class="step-connector" id="conn-2"></div>
        <div class="step-item">
          <div class="step-circle" id="circle-3">3</div>
          <span class="step-label" id="label-3">Invitations</span>
        </div>
      </div>
    </header>

    <!-- Step Content -->
    <div class="step-content">

      <!-- â”€â”€ STEP 1: Informations â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€ -->
      <div class="step-panel active" id="step-1">
        <div class="card-cv">
          <div class="card-cv-title">
            <span class="material-symbols-outlined" style="font-size:20px;color:var(--color-primary)">check_box_outline_blank</span>
            Informations de la capsule
          </div>
          <div class="card-cv-subtitle">Donnez un nom et une description Ã  votre capsule</div>

          <div class="mb-3">
            <label class="form-label-cv">Titre de la capsule *</label>
            <input type="text" id="capsule-title" class="form-input-cv" placeholder="Ex: Vacances d'Ã©tÃ© 2024"/>
          </div>

          <div class="mb-1">
            <label class="form-label-cv">Description</label>
            <textarea id="capsule-desc" class="form-input-cv" placeholder="DÃ©crivez votre capsule et son objectif..."></textarea>
          </div>

          <div class="btn-row end">
            <button class="btn-primary-cv" onclick="goTo(2)">Continuer</button>
          </div>
        </div>
      </div>

      <!-- â”€â”€ STEP 2: Date â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€ -->
      <div class="step-panel" id="step-2">
        <div class="card-cv">
          <div class="card-cv-title">
            <span class="material-symbols-outlined" style="font-size:20px;color:var(--color-primary)">calendar_month</span>
            Date d'ouverture
          </div>
          <div class="card-cv-subtitle">Choisissez quand la capsule pourra Ãªtre ouverte</div>

          <div class="mb-1">
            <label class="form-label-cv">Date d'ouverture *</label>
            <div class="input-icon-wrap">
              <span class="material-symbols-outlined">calendar_today</span>
              <input type="date" id="capsule-date" class="form-input-cv" value="2026-04-08"/>
            </div>
            <p class="form-hint">La capsule restera verrouillÃ©e jusqu'Ã  cette date</p>
          </div>

          <div class="lock-preview">
            <div class="lock-icon-wrap">
              <span class="material-symbols-outlined" style="color:var(--color-primary)">lock</span>
            </div>
            <div>
              <div class="lock-preview-title">Capsule verrouillÃ©e</div>
              <div class="lock-preview-sub" id="lock-sub">S'ouvrira le 8 avril 2026</div>
            </div>
          </div>

          <div class="btn-row">
            <button class="btn-secondary-cv" onclick="goTo(1)">Retour</button>
            <button class="btn-primary-cv" onclick="goTo(3)">Continuer</button>
          </div>
        </div>
      </div>

      <!-- â”€â”€ STEP 3: Invitations â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€ -->
      <div class="step-panel" id="step-3">
        <div class="card-cv">
          <div class="card-cv-title">
            <span class="material-symbols-outlined" style="font-size:20px;color:var(--color-primary)">group_add</span>
            Inviter des participants
          </div>
          <div class="card-cv-subtitle">Invitez vos amis Ã  contribuer Ã  cette capsule</div>

          <div class="mb-3">
            <label class="form-label-cv">Adresse email</label>
            <div class="email-input-row">
              <div class="input-icon-wrap" style="flex:1">
                <span class="material-symbols-outlined">mail</span>
                <input type="email" id="email-input" class="form-input-cv" placeholder="ami@email.com"
                       onkeydown="if(event.key==='Enter') addEmail()"/>
              </div>
              <button class="btn-add-email" onclick="addEmail()">+</button>
            </div>
          </div>

          <div id="tag-section" style="display:none">
            <div class="form-label-cv" id="tag-label">Participants invitÃ©s (0)</div>
            <div class="tag-list" id="tag-list"></div>
          </div>

          <div class="info-box">
            Les participants invitÃ©s recevront un email avec un lien pour rejoindre la capsule. Ils pourront ajouter leurs propres photos et messages.
          </div>

          <!-- Recap -->
          <div class="recap-table">
            <div class="recap-title">RÃ©capitulatif</div>
            <div class="recap-row">
              <span class="recap-key">Titre</span>
              <span class="recap-value" id="recap-title">â€”</span>
            </div>
            <div class="recap-row">
              <span class="recap-key">Date d'ouverture</span>
              <span class="recap-value" id="recap-date">â€”</span>
            </div>
            <div class="recap-row">
              <span class="recap-key">Participants</span>
              <span class="recap-value" id="recap-participants">1 (vous inclus)</span>
            </div>
          </div>

          <div class="btn-row">
            <button class="btn-secondary-cv" onclick="goTo(2)">Retour</button>
            <button class="btn-primary-cv" onclick="createCapsule()">
              <span class="material-symbols-outlined" style="font-size:18px">lock</span>
              CrÃ©er la capsule
            </button>
          </div>
        </div>
      </div>

    </div><!-- /step-content -->

    <!-- Footer -->
    <footer class="page-footer">
      <p class="footer-copy mb-0">Â© 2026 ChronoVault, tous droits rÃ©servÃ©s.</p>
      <div class="footer-links">
        <a href="#">Mentions LÃ©gales</a>
        <a href="#">ConfidentialitÃ©</a>
        <a href="#">Contact</a>
      </div>
    </footer>

  </main>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    let currentStep = 1;
    const emails = [];

    /* â”€â”€ Navigation â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€ */
    function goTo(step) {
      // Hide current
      document.getElementById('step-' + currentStep).classList.remove('active');

      // Update stepper visuals
      for (let i = 1; i <= 3; i++) {
        const circle = document.getElementById('circle-' + i);
        const label  = document.getElementById('label-' + i);
        circle.classList.remove('active', 'done');
        label.classList.remove('active');

        if (i < step)       { circle.classList.add('done'); }
        else if (i === step) { circle.classList.add('active'); label.classList.add('active'); }
      }
      for (let i = 1; i <= 2; i++) {
        const conn = document.getElementById('conn-' + i);
        conn.classList.toggle('done', i < step);
      }

      currentStep = step;

      // Show new
      document.getElementById('step-' + step).classList.add('active');

      if (step === 3) updateRecap();
    }

    function goBack() { if (currentStep > 1) goTo(currentStep - 1); }

    /* â”€â”€ Date label update â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€ */
    document.getElementById('capsule-date').addEventListener('change', function() {
      updateLockLabel(this.value);
    });

    function updateLockLabel(val) {
      if (!val) return;
      const d = new Date(val + 'T00:00:00');
      const opts = { day: 'numeric', month: 'long', year: 'numeric' };
      document.getElementById('lock-sub').textContent =
        "S'ouvrira le " + d.toLocaleDateString('fr-FR', opts);
    }
    updateLockLabel(document.getElementById('capsule-date').value);

    /* â”€â”€ Email tags â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€ */
    function addEmail() {
      const input = document.getElementById('email-input');
      const val = input.value.trim();
      if (!val || !val.includes('@')) return;
      if (emails.includes(val)) { input.value = ''; return; }
      emails.push(val);
      input.value = '';
      renderTags();
    }

    function removeEmail(idx) {
      emails.splice(idx, 1);
      renderTags();
    }

    function renderTags() {
      const section = document.getElementById('tag-section');
      const list    = document.getElementById('tag-list');
      const lbl     = document.getElementById('tag-label');
      section.style.display = emails.length ? 'block' : 'none';
      lbl.textContent = 'Participants invitÃ©s (' + emails.length + ')';
      list.innerHTML = emails.map((e, i) =>
        `<span class="email-tag">
           <span class="material-symbols-outlined" style="font-size:13px">mail</span>
           ${e}
           <span class="material-symbols-outlined" onclick="removeEmail(${i})">close</span>
         </span>`
      ).join('');
    }

    /* â”€â”€ Recap â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€ */
    function updateRecap() {
      const title = document.getElementById('capsule-title').value || 'â€”';
      const dateVal = document.getElementById('capsule-date').value;
      let dateStr = 'â€”';
      if (dateVal) {
        const d = new Date(dateVal + 'T00:00:00');
        dateStr = d.toLocaleDateString('fr-FR', { day: 'numeric', month: 'long', year: 'numeric' });
      }
      document.getElementById('recap-title').textContent = title;
      document.getElementById('recap-date').textContent  = dateStr;
      document.getElementById('recap-participants').textContent =
        (emails.length + 1) + ' (vous inclus)';
    }

    /* â”€â”€ Create â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€ */
    function createCapsule() {
      alert('ðŸŽ‰ Capsule crÃ©Ã©e avec succÃ¨s !');
    }
  </script>
</body>
</html>
