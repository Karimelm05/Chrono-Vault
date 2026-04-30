<?php
$pageTitle = 'Nouvelle Capsule | ChronoVault';
$activePage = 'new-capsule';
require_once __DIR__ . '/../includes/layout.php';
?>

<header class="page-header">
  <button class="back-btn mb-2" onclick="goBack()">
    <span class="material-symbols-outlined" style="font-size:18px">arrow_back</span>
    Retour
  </button>
  <h1 class="page-title">Nouvelle capsule</h1>
  <p class="page-subtitle mb-0">Créez une capsule temporelle avec vos amis</p>

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

<section class="cards-section">
  <div class="row g-4 justify-content-center">
    <div class="col-12 col-lg-8 mx-auto">
      <div class="step-content">
        <div class="step-panel active" id="step-1">
          <div class="capsule-card" style="height:auto;">
            <div class="card-body-cv">
              <h3 class="card-title-cv"><span class="material-symbols-outlined" style="font-size:20px;color:var(--color-primary)">check_box_outline_blank</span> Informations de la capsule</h3>
              <p class="card-desc">Donnez un nom et une description à votre capsule</p>

              <div class="mb-3">
                <label class="form-label-cv">Titre de la capsule *</label>
                <input type="text" id="capsule-title" class="form-input-cv" placeholder="Ex: Vacances d'été 2024"/>
              </div>

              <div class="mb-1">
                <label class="form-label-cv">Description</label>
                <textarea id="capsule-desc" class="form-input-cv" placeholder="Décrivez votre capsule et son objectif..."></textarea>
              </div>

              <div class="d-flex justify-content-end mt-3">
                <button class="btn-primary-cv" onclick="goTo(2)">Continuer</button>
              </div>
            </div>
          </div>
        </div>

        <div class="step-panel" id="step-2">
          <div class="capsule-card" style="height:auto;">
            <div class="card-body-cv">
              <h3 class="card-title-cv"><span class="material-symbols-outlined" style="font-size:20px;color:var(--color-primary)">calendar_month</span> Date d'ouverture</h3>
              <p class="card-desc">Choisissez quand la capsule pourra être ouverte</p>

              <div class="mb-1">
                <label class="form-label-cv">Date d'ouverture *</label>
                <div class="input-icon-wrap">
                  <span class="material-symbols-outlined">calendar_today</span>
                  <input type="date" id="capsule-date" class="form-input-cv" value="2026-04-08"/>
                </div>
                <p class="form-hint">La capsule restera verrouillée jusqu'à cette date</p>
              </div>

              <div class="lock-preview">
                <div class="lock-icon-wrap">
                  <span class="material-symbols-outlined" style="color:var(--color-primary)">lock</span>
                </div>
                <div>
                  <div class="lock-preview-title">Capsule verrouillée</div>
                  <div class="lock-preview-sub" id="lock-sub">S'ouvrira le 8 avril 2026</div>
                </div>
              </div>

              <div class="d-flex justify-content-between mt-3">
                <button class="btn-filter" onclick="goTo(1)">Retour</button>
                <button class="btn-primary-cv" onclick="goTo(3)">Continuer</button>
              </div>
            </div>
          </div>
        </div>

        <div class="step-panel" id="step-3">
          <div class="capsule-card" style="height:auto;">
            <div class="card-body-cv">
              <h3 class="card-title-cv"><span class="material-symbols-outlined" style="font-size:20px;color:var(--color-primary)">group_add</span> Inviter des participants</h3>
              <p class="card-desc">Invitez vos amis à contribuer à cette capsule</p>

              <div class="mb-3">
                <label class="form-label-cv">Adresse email</label>
                <div class="email-input-row">
                  <div class="input-icon-wrap" style="flex:1">
                    <span class="material-symbols-outlined">mail</span>
                    <input type="email" id="email-input" class="form-input-cv" placeholder="ami@email.com" onkeydown="if(event.key==='Enter') addEmail()"/>
                  </div>
                  <button class="btn-add-email" onclick="addEmail()">+</button>
                </div>
              </div>

              <div id="tag-section" style="display:none">
                <div class="form-label-cv" id="tag-label">Participants invités (0)</div>
                <div class="tag-list" id="tag-list"></div>
              </div>

              <div class="info-box">
                Les participants invités recevront un email avec un lien pour rejoindre la capsule. Ils pourront ajouter leurs propres photos et messages.
              </div>

              <div class="recap-table">
                <div class="recap-title">Récapitulatif</div>
                <div class="recap-row">
                  <span class="recap-key">Titre</span>
                  <span class="recap-value" id="recap-title">—</span>
                </div>
                <div class="recap-row">
                  <span class="recap-key">Date d'ouverture</span>
                  <span class="recap-value" id="recap-date">—</span>
                </div>
                <div class="recap-row">
                  <span class="recap-key">Participants</span>
                  <span class="recap-value" id="recap-participants">1 (vous inclus)</span>
                </div>
              </div>

              <div class="d-flex justify-content-between mt-3">
                <button class="btn-filter" onclick="goTo(2)">Retour</button>
                <button class="btn-primary-cv" onclick="createCapsule()">
                  <span class="material-symbols-outlined" style="font-size:18px">lock</span>
                  Créer la capsule
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<script>
  let currentStep = 1;
  const emails = [];

  function goTo(step) {
    document.getElementById('step-' + currentStep).classList.remove('active');

    for (let i = 1; i <= 3; i++) {
      const circle = document.getElementById('circle-' + i);
      const label = document.getElementById('label-' + i);
      circle.classList.remove('active', 'done');
      label.classList.remove('active');

      if (i < step) {
        circle.classList.add('done');
      } else if (i === step) {
        circle.classList.add('active');
        label.classList.add('active');
      }
    }

    for (let i = 1; i <= 2; i++) {
      const conn = document.getElementById('conn-' + i);
      conn.classList.toggle('done', i < step);
    }

    currentStep = step;
    document.getElementById('step-' + step).classList.add('active');

    if (step === 3) updateRecap();
  }

  function goBack() {
    if (currentStep > 1) {
      goTo(currentStep - 1);
    }
  }

  document.getElementById('capsule-date').addEventListener('change', function() {
    updateLockLabel(this.value);
  });

  function updateLockLabel(val) {
    if (!val) {
      return;
    }
    const d = new Date(val + 'T00:00:00');
    const opts = { day: 'numeric', month: 'long', year: 'numeric' };
    document.getElementById('lock-sub').textContent = "S'ouvrira le " + d.toLocaleDateString('fr-FR', opts);
  }

  updateLockLabel(document.getElementById('capsule-date').value);

  function addEmail() {
    const input = document.getElementById('email-input');
    const val = input.value.trim();
    if (!val || !val.includes('@')) {
      return;
    }
    if (emails.includes(val)) {
      input.value = '';
      return;
    }
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
    const list = document.getElementById('tag-list');
    const lbl = document.getElementById('tag-label');
    section.style.display = emails.length ? 'block' : 'none';
    lbl.textContent = 'Participants invités (' + emails.length + ')';
    list.innerHTML = emails.map((e, i) =>
      `<span class="email-tag">
         <span class="material-symbols-outlined" style="font-size:13px">mail</span>
         ${e}
         <span class="material-symbols-outlined" onclick="removeEmail(${i})">close</span>
       </span>`
    ).join('');
  }

  function updateRecap() {
    const title = document.getElementById('capsule-title').value || '—';
    const dateVal = document.getElementById('capsule-date').value;
    let dateStr = '—';

    if (dateVal) {
      const d = new Date(dateVal + 'T00:00:00');
      dateStr = d.toLocaleDateString('fr-FR', { day: 'numeric', month: 'long', year: 'numeric' });
    }

    document.getElementById('recap-title').textContent = title;
    document.getElementById('recap-date').textContent = dateStr;
    document.getElementById('recap-participants').textContent = (emails.length + 1) + ' (vous inclus)';
  }

  function createCapsule() {
    alert('Capsule créée avec succès !');
  }
</script>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
