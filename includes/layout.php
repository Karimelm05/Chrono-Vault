<?php
$pageTitle = $pageTitle ?? 'ChronoVault';
$activePage = $activePage ?? '';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="utf-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title><?php echo htmlspecialchars($pageTitle, ENT_QUOTES, 'UTF-8'); ?></title>

  <!-- Bootstrap 5 -->
  <link href="../bootstrap/css/bootstrap.min.css" rel="stylesheet"/>

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet"/>
  <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>

  <style>
    :root {
      --color-primary:          #6c2f00;
      --color-primary-container:#8b4513;
      --color-secondary:        #7c572d;
      --color-secondary-container: #fecb97;
      --color-on-secondary-container: #79542a;
      --color-surface:          #fdf9f1;
      --color-surface-bright:   #fdf9f1;
      --color-surface-container:#f1ede5;
      --color-surface-container-low: #f7f3eb;
      --color-surface-container-high: #ece8e0;
      --color-surface-container-highest: #e6e2da;
      --color-on-surface:       #1c1c17;
      --color-on-surface-variant: #54433a;
      --color-outline:          #877369;
      --color-outline-variant:  #dac2b6;
      --color-tertiary-fixed-dim: #e7c446;
      --color-on-tertiary-fixed: #231b00;
      --color-error:            #ba1a1a;
      --color-error-container:  #ffdad6;
      --sidebar-width:          260px;
    }

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
    #sidebar .brand-name {
      font-size: 1.15rem;
      font-weight: 900;
      color: #3b1a08;
      letter-spacing: -0.04em;
    }
    #sidebar .brand-sub {
      font-size: 0.65rem;
      font-weight: 600;
      text-transform: uppercase;
      letter-spacing: 0.14em;
      color: var(--color-outline);
      margin-top: 2px;
    }
    .nav-link-item {
      display: flex;
      align-items: center;
      gap: 0.75rem;
      padding: 0.65rem 1rem;
      border-radius: 0.5rem;
      font-size: 0.9rem;
      font-weight: 500;
      color: #78716c;
      text-decoration: none;
      transition: background 0.15s, color 0.15s;
    }
    .nav-link-item:hover {
      background: #e7e3dc;
      color: var(--color-on-surface);
    }
    .nav-link-item.active {
      background: rgba(231,227,220,0.5);
      color: #78350f;
      font-weight: 600;
    }
    .nav-link-item.active .material-symbols-outlined {
      font-variation-settings: 'FILL' 1, 'wght' 500, 'GRAD' 0, 'opsz' 24;
    }
    .sidebar-divider {
      border-top: 1px solid var(--color-outline-variant);
      margin: 0.75rem 0;
    }
    .user-profile {
      display: flex;
      align-items: center;
      gap: 0.75rem;
      padding: 0.5rem 1rem;
      margin-top: 0.5rem;
    }
    .user-avatar {
      width: 34px;
      height: 34px;
      border-radius: 50%;
      object-fit: cover;
    }
    .user-name {
      font-size: 0.875rem;
      font-weight: 700;
      white-space: nowrap;
      overflow: hidden;
      text-overflow: ellipsis;
    }

    #main {
      flex: 1;
      min-width: 0;
      background: #fff;
      display: flex;
      flex-direction: column;
    }

    .page-header {
      padding: 3rem 3rem 2rem;
    }
    .page-title-bar {
      display: flex;
      align-items: center;
      gap: 0.75rem;
      margin-bottom: 0.4rem;
    }
    .title-accent {
      width: 4px;
      height: 2rem;
      background: var(--color-tertiary-fixed-dim);
      border-radius: 2px;
    }
    .page-title {
      font-size: 2.25rem;
      font-weight: 800;
      letter-spacing: -0.03em;
      color: var(--color-on-surface);
      margin: 0;
    }
    .page-subtitle {
      color: var(--color-on-surface-variant);
      font-weight: 500;
      font-size: 0.95rem;
    }
    .btn-primary-cv {
      background: var(--color-primary);
      color: #fff;
      border: none;
      padding: 0.7rem 1.4rem;
      border-radius: 0.5rem;
      font-weight: 700;
      font-size: 0.9rem;
      font-family: 'Plus Jakarta Sans', sans-serif;
      display: inline-flex;
      align-items: center;
      gap: 0.4rem;
      box-shadow: 0 4px 15px rgba(108,47,0,0.15);
      transition: background 0.15s, transform 0.1s;
      cursor: pointer;
      white-space: nowrap;
    }
    .btn-primary-cv:hover { background: var(--color-primary-container); }
    .btn-primary-cv:active { transform: scale(0.97); }

    .filter-bar {
      background: var(--color-surface-container-low);
      border-radius: 0.75rem;
      padding: 1rem;
      display: flex;
      flex-wrap: wrap;
      gap: 0.75rem;
      align-items: center;
    }
    .search-wrapper {
      flex: 1;
      position: relative;
      min-width: 180px;
    }
    .search-wrapper .material-symbols-outlined {
      position: absolute;
      left: 1rem;
      top: 50%;
      transform: translateY(-50%);
      color: var(--color-on-surface-variant);
    }
    .search-input {
      width: 100%;
      background: var(--color-surface-container-highest);
      border: none;
      border-radius: 0.75rem;
      padding: 0.7rem 1rem 0.7rem 2.8rem;
      font-family: 'Plus Jakarta Sans', sans-serif;
      font-size: 0.875rem;
      color: var(--color-on-surface);
      outline: none;
      transition: box-shadow 0.2s;
    }
    .search-input::placeholder { color: var(--color-outline); }
    .search-input:focus { box-shadow: 0 0 0 2px rgba(108,47,0,0.18); }
    .btn-filter {
      background: var(--color-surface-container-highest);
      border: none;
      border-radius: 0.5rem;
      padding: 0.7rem 1rem;
      font-family: 'Plus Jakarta Sans', sans-serif;
      font-size: 0.8rem;
      font-weight: 700;
      color: var(--color-on-surface);
      display: inline-flex;
      align-items: center;
      gap: 0.4rem;
      cursor: pointer;
      transition: background 0.15s;
    }
    .btn-filter:hover { background: rgba(218,194,182,0.45); }

    .cards-section {
      padding: 0 3rem 5rem;
    }
    .capsule-card {
      background: var(--color-surface-container-low);
      border-radius: 0.75rem;
      overflow: hidden;
      height: 420px;
      display: flex;
      flex-direction: column;
      transition: box-shadow 0.3s, transform 0.3s;
    }
    .capsule-card:hover {
      box-shadow: 0 20px 40px rgba(28,28,23,0.12);
    }
    .capsule-card.draft {
      border: 2px dashed rgba(218,194,182,0.5);
    }
    .card-img-wrapper {
      height: 192px;
      overflow: hidden;
      position: relative;
      flex-shrink: 0;
    }
    .card-img-wrapper.muted { opacity: 0.6; }
    .card-img-wrapper img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      transition: transform 0.5s;
    }
    .capsule-card:hover .card-img-wrapper img {
      transform: scale(1.05);
    }
    .card-badges {
      position: absolute;
      top: 1rem;
      right: 1rem;
      display: flex;
      gap: 0.4rem;
    }
    .badge-cv {
      padding: 0.25rem 0.7rem;
      border-radius: 9999px;
      font-size: 0.6rem;
      font-weight: 700;
      text-transform: uppercase;
      letter-spacing: 0.1em;
      box-shadow: 0 1px 4px rgba(0,0,0,0.1);
    }
    .badge-sealed   { background: var(--color-tertiary-fixed-dim); color: var(--color-on-tertiary-fixed); }
    .badge-soon     { background: var(--color-tertiary-fixed-dim); color: var(--color-on-tertiary-fixed); }
    .badge-draft    { background: var(--color-surface-container-highest); color: var(--color-on-surface-variant); }
    .badge-shared   { background: var(--color-secondary-container); color: var(--color-on-secondary-container); }

    .card-body-cv {
      padding: 1.4rem;
      flex: 1;
      display: flex;
      flex-direction: column;
    }
    .card-category {
      font-size: 0.6rem;
      font-weight: 700;
      text-transform: uppercase;
      letter-spacing: 0.12em;
      color: var(--color-secondary);
      margin-bottom: 0.25rem;
    }
    .card-category.muted { color: var(--color-outline); }
    .card-title-cv {
      font-size: 1.1rem;
      font-weight: 700;
      margin-bottom: 0.4rem;
      color: var(--color-on-surface);
      line-height: 1.3;
    }
    .card-title-cv.muted-title { color: var(--color-on-surface-variant); }
    .stat-number {
      font-size: 4rem;
      font-weight: 900;
      line-height: 1;
      margin-top: 0.6rem;
      margin-bottom: 0.25rem;
    }
    .card-desc {
      font-size: 0.82rem;
      color: var(--color-on-surface-variant);
      line-clamp: 2;
      display: -webkit-box;
      -webkit-line-clamp: 2;
      -webkit-box-orient: vertical;
      overflow: hidden;
      margin-bottom: 1.25rem;
    }
    .card-footer-cv {
      margin-top: auto;
      padding-top: 1rem;
      border-top: 1px solid rgba(218,194,182,0.15);
      display: flex;
      align-items: center;
      justify-content: space-between;
    }
    .card-footer-cv.no-border { border: none; }
    .open-label {
      font-size: 0.58rem;
      font-weight: 700;
      text-transform: uppercase;
      letter-spacing: 0.1em;
      color: var(--color-outline);
    }
    .open-value {
      font-size: 1.05rem;
      font-weight: 900;
      color: var(--color-tertiary-fixed-dim);
      line-height: 1.2;
    }
    .avatar-stack {
      display: flex;
      flex-direction: row-reverse;
    }
    .avatar-stack img,
    .avatar-stack .avatar-count {
      width: 32px;
      height: 32px;
      border-radius: 50%;
      border: 2px solid var(--color-surface-container-low);
      margin-left: -10px;
      object-fit: cover;
    }
    .avatar-count {
      background: var(--color-surface-container-highest);
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 0.6rem;
      font-weight: 700;
      color: var(--color-on-surface-variant);
    }
    .avatar-solo {
      width: 32px;
      height: 32px;
      border-radius: 50%;
      border: 2px solid var(--color-surface-container-low);
      background: var(--color-surface-container-highest);
      display: flex;
      align-items: center;
      justify-content: center;
    }
    .btn-continue {
      flex: 1;
      padding: 0.5rem;
      background: rgba(218,194,182,0.2);
      border: none;
      border-radius: 0.5rem;
      font-family: 'Plus Jakarta Sans', sans-serif;
      font-size: 0.8rem;
      font-weight: 700;
      color: var(--color-on-surface);
      cursor: pointer;
      transition: background 0.15s;
    }
    .btn-continue:hover { background: rgba(218,194,182,0.45); }
    .btn-delete {
      width: 38px;
      height: 38px;
      display: flex;
      align-items: center;
      justify-content: center;
      border: none;
      background: transparent;
      border-radius: 0.5rem;
      cursor: pointer;
      color: var(--color-on-surface-variant);
      transition: background 0.15s, color 0.15s;
    }
    .btn-delete:hover {
      background: var(--color-error-container);
      color: var(--color-error);
    }

    .back-btn {
      background: none;
      border: none;
      cursor: pointer;
      color: var(--color-on-surface-variant);
      padding: 0;
      display: inline-flex;
      align-items: center;
      gap: 0.3rem;
      font-family: 'Plus Jakarta Sans', sans-serif;
      font-size: 0.85rem;
      font-weight: 600;
      transition: color 0.15s;
    }
    .back-btn:hover { color: var(--color-primary); }

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
      width: 32px;
      height: 32px;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 0.8rem;
      font-weight: 700;
      background: var(--color-surface-container-highest);
      color: var(--color-on-surface-variant);
      border: 2px solid var(--color-outline-variant);
      flex-shrink: 0;
      transition: all 0.3s;
    }
    .step-circle.active,
    .step-circle.done {
      background: var(--color-tertiary-fixed-dim);
      color: var(--color-on-tertiary-fixed);
      border-color: var(--color-tertiary-fixed-dim);
    }
    .step-label {
      font-size: 0.82rem;
      font-weight: 600;
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
      width: 100%;
    }
    .card-cv-title {
      font-size: 1.05rem;
      font-weight: 700;
      color: var(--color-on-surface);
      display: flex;
      align-items: center;
      gap: 0.5rem;
      margin-bottom: 0.2rem;
    }
    .card-cv-subtitle {
      font-size: 0.82rem;
      color: var(--color-on-surface-variant);
      margin-bottom: 1.5rem;
    }

    .form-label-cv {
      font-size: 0.82rem;
      font-weight: 700;
      color: var(--color-on-surface);
      margin-bottom: 0.4rem;
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

    .input-icon-wrap { position: relative; }
    .input-icon-wrap .material-symbols-outlined {
      position: absolute;
      left: 0.9rem;
      top: 50%;
      transform: translateY(-50%);
      color: var(--color-on-surface-variant);
      font-size: 18px;
    }
    .input-icon-wrap .form-input-cv { padding-left: 2.5rem; }

    .form-hint {
      font-size: 0.75rem;
      color: var(--color-on-surface-variant);
      margin-top: 0.4rem;
    }

    .lock-preview {
      background: var(--color-surface-container-low);
      border: 1.5px solid var(--color-outline-variant);
      border-radius: 0.75rem;
      padding: 1rem 1.25rem;
      display: flex;
      align-items: center;
      gap: 0.9rem;
      margin-top: 1.25rem;
    }
    .lock-icon-wrap {
      width: 40px;
      height: 40px;
      border-radius: 50%;
      background: rgba(108,47,0,0.08);
      display: flex;
      align-items: center;
      justify-content: center;
      flex-shrink: 0;
    }
    .lock-preview-title { font-size: 0.9rem; font-weight: 700; }
    .lock-preview-sub { font-size: 0.78rem; color: var(--color-on-surface-variant); }

    .email-input-row {
      display: flex;
      gap: 0.5rem;
      align-items: stretch;
    }
    .email-input-row .form-input-cv { flex: 1; }
    .btn-add-email {
      width: 40px;
      height: 40px;
      border-radius: 0.5rem;
      background: var(--color-primary);
      color: #fff;
      border: none;
      display: flex;
      align-items: center;
      justify-content: center;
      cursor: pointer;
      flex-shrink: 0;
      font-size: 20px;
      font-weight: 700;
      transition: background 0.15s;
    }
    .btn-add-email:hover { background: var(--color-primary-container); }

    .tag-list {
      display: flex;
      flex-wrap: wrap;
      gap: 0.4rem;
      margin-top: 0.75rem;
    }
    .email-tag {
      display: inline-flex;
      align-items: center;
      gap: 0.35rem;
      background: var(--color-tertiary-fixed-dim);
      color: var(--color-on-tertiary-fixed);
      padding: 0.3rem 0.65rem;
      border-radius: 9999px;
      font-size: 0.75rem;
      font-weight: 600;
    }
    .email-tag .material-symbols-outlined {
      font-size: 14px;
      cursor: pointer;
      opacity: 0.7;
    }
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

    .recap-table { margin-top: 1.5rem; }
    .recap-title { font-size: 0.9rem; font-weight: 700; margin-bottom: 0.75rem; }
    .recap-row {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 0.55rem 0;
      border-bottom: 1px solid var(--color-outline-variant);
      font-size: 0.85rem;
    }
    .recap-row:last-child { border-bottom: none; }
    .recap-key { color: var(--color-on-surface-variant); font-weight: 500; }
    .recap-value { font-weight: 700; color: var(--color-on-surface); text-align: right; }

    .btn-secondary-cv {
      background: transparent;
      color: var(--color-on-surface);
      border: 1.5px solid var(--color-outline-variant);
      padding: 0.65rem 1.4rem;
      border-radius: 0.5rem;
      font-weight: 700;
      font-size: 0.875rem;
      font-family: 'Plus Jakarta Sans', sans-serif;
      cursor: pointer;
      transition: background 0.15s;
    }
    .btn-secondary-cv:hover { background: var(--color-surface-container-low); }
    .btn-row {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-top: 1.75rem;
      gap: 0.75rem;
    }
    .btn-row.end { justify-content: flex-end; }

    .step-panel { display: none; }
    .step-panel.active {
      display: block;
      width: 100%;
      max-width: 720px;
      background: var(--color-surface);
      animation: fadeSlideIn 0.3s ease both;
    }

    @keyframes fadeSlideIn {
      from { opacity: 0; transform: translateY(14px); }
      to { opacity: 1; transform: translateY(0); }
    }

    .page-footer {
      position: fixed;
      bottom: 0;
      left: var(--sidebar-width);
      right: 0;
      border-top: 1px solid rgba(218,194,182,0.25);
      background: #faf7f2;
      z-index: 40;
      padding: 1.2rem 3rem;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }
    .footer-copy, .footer-links a {
      font-size: 0.65rem;
      text-transform: uppercase;
      letter-spacing: 0.1em;
      color: #a8a29e;
      text-decoration: none;
    }
    .footer-links { display: flex; gap: 2rem; }
    .footer-links a:hover { color: #92400e; }
  </style>
</head>

<body>

  <aside id="sidebar">
    <div class="mb-4 px-2">
      <div class="brand-name">ChronoVault</div>
      <div class="brand-sub">The Timeless Curator</div>
    </div>

    <nav class="flex-grow-1 d-flex flex-column gap-1">
      <a href="dashboard.php" class="nav-link-item <?php echo $activePage === 'dashboard' ? 'active' : ''; ?>">
        <span class="material-symbols-outlined">dashboard</span>
        <span>Dashboard</span>
      </a>
      <a href="capsules.php" class="nav-link-item <?php echo $activePage === 'capsules' ? 'active' : ''; ?>">
        <span class="material-symbols-outlined">inventory_2</span>
        <span>Mes Capsules</span>
      </a>
      <a href="new-capsule.php" class="nav-link-item <?php echo $activePage === 'new-capsule' ? 'active' : ''; ?>">
        <span class="material-symbols-outlined">auto_awesome</span>
        <span>Nouvelle Capsule</span>
      </a>
      <a href="invitations.php" class="nav-link-item <?php echo $activePage === 'invitations' ? 'active' : ''; ?>">
        <span class="material-symbols-outlined">notifications</span>
        <span>Notifications</span>
      </a>
      <a href="parametre.php" class="nav-link-item <?php echo $activePage === 'parametre' ? 'active' : ''; ?>">
        <span class="material-symbols-outlined">settings</span>
        <span>Paramètres</span>
      </a>
    </nav>

    <div class="mt-auto">
      <div class="sidebar-divider"></div>
      <a href="#" class="nav-link-item">
        <span class="material-symbols-outlined">help</span>
        <span>Aide</span>
      </a>
      <a href="../index.php" class="nav-link-item">
        <span class="material-symbols-outlined">logout</span>
        <span>Déconnexion</span>
      </a>
      <div class="user-profile">
        <img
          src="https://lh3.googleusercontent.com/aida-public/AB6AXuCuDd-TmfhHzFEd72RVUQR1QLqv3rap1YuN2tD4wPGsuEuj2TRdZnhQp852Q-_MgU_-CJMOF83pjT582yPw5Bh4zSkjTqAa9jcguFJ6Yg4evelTl__N24VzM540KrOqNwxetmthLkbBlb3LoqzDBCtUKR8NbtfnN2kvcGhVchmAUEp4vhpgcsVSUiJzlw3FaD5bUmVjtFXD3nenzZEZ2yUArKpglz317i6iqEgJro57xU2B7iwls5vKnEy2_VUs4nf5kiHhmj_PgMyV"
          alt="Marc-Antoine" class="user-avatar"/>
        <div class="user-name">Marc-Antoine</div>
      </div>
    </div>
  </aside>

  <main id="main">
