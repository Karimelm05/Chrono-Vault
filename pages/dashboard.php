<?php
$pageTitle = 'Dashboard | ChronoVault';
$activePage = 'dashboard';
require_once __DIR__ . '/../connexion.php';
require_once __DIR__ . '/../includes/layout.php';
require_once __DIR__ . '/../includes/fonctions.php';


// calcule des capsules de l'utilisateur :
function countCapsulesByUser(int $userId, PDO $pdo): int
{
    try {
        $stmt = $pdo->prepare("SELECT COUNT(*) as total FROM capsule WHERE Id_Utilisateur = ?");
        $stmt->execute([$userId]);
        $result = $stmt->fetch();
        return (int)($result['total'] ?? 0);
    } catch (PDOException $e) {
        return 0;
    }
}

// Capsules où l'utilisateur est membre (excluant ses capsules)
function countCapsulesMembership(int $userId, PDO $pdo): int
{
    try {
        $stmt = $pdo->prepare("
            SELECT COUNT(DISTINCT i.Id_Capsule) as total 
            FROM invitation i
            JOIN capsule c ON c.Id_Capsule = i.Id_Capsule
            WHERE i.Id_Utilisateur = ? AND c.Id_Utilisateur != ?
        ");
        $stmt->execute([$userId, $userId]);
        $result = $stmt->fetch();
        return (int)($result['total'] ?? 0);
    } catch (PDOException $e) {
        return 0;
    }
}

// Capsules ouvertes (créées par lui ou dont il est membre)
function countOpenCapsules(int $userId, PDO $pdo): int
{
    try {
        $stmt = $pdo->prepare("
            SELECT COUNT(DISTINCT c.Id_Capsule) as total
            FROM capsule c
            WHERE (c.Id_Utilisateur = ? OR c.Id_Capsule IN (
                SELECT DISTINCT i.Id_Capsule FROM invitation i WHERE i.Id_Utilisateur = ?
            ))
            AND c.date_ouverture IS NOT NULL 
            AND c.date_ouverture <= NOW()
        ");
        $stmt->execute([$userId, $userId]);
        $result = $stmt->fetch();
        return (int)($result['total'] ?? 0);
    } catch (PDOException $e) {
        return 0;
    }
}

// Nombre de souvenirs dans les capsules ouvertes
function countSouvenirsInOpenCapsules(int $userId, PDO $pdo): int
{
    try {
        $stmt = $pdo->prepare("
            SELECT COUNT(*) as total
            FROM souvenir s
            JOIN capsule c ON c.Id_Capsule = s.Id_Capsule
            WHERE (c.Id_Utilisateur = ? OR c.Id_Capsule IN (
                SELECT DISTINCT i.Id_Capsule FROM invitation i WHERE i.Id_Utilisateur = ?
            ))
            AND c.date_ouverture IS NOT NULL 
            AND c.date_ouverture <= NOW()
        ");
        $stmt->execute([$userId, $userId]);
        $result = $stmt->fetch();
        return (int)($result['total'] ?? 0);
    } catch (PDOException $e) {
        return 0;
    }
}

// Capsules non ouvertes (créées par lui ou dont il est membre)
function countClosedCapsules(int $userId, PDO $pdo): int
{
    try {
        $stmt = $pdo->prepare("
            SELECT COUNT(DISTINCT c.Id_Capsule) as total
            FROM capsule c
            WHERE (c.Id_Utilisateur = ? OR c.Id_Capsule IN (
                SELECT DISTINCT i.Id_Capsule FROM invitation i WHERE i.Id_Utilisateur = ?
            ))
            AND (c.date_ouverture IS NULL OR c.date_ouverture > NOW())
        ");
        $stmt->execute([$userId, $userId]);
        $result = $stmt->fetch();
        return (int)($result['total'] ?? 0);
    } catch (PDOException $e) {
        return 0;
    }
}


// Calculer les capsules par catégorie
$capsulesByUser = $userId ? countCapsulesByUser($userId, $pdo) : 0;
$capsulesMembership = $userId ? countCapsulesMembership($userId, $pdo) : 0;
$capsuleOpen = $userId ? countOpenCapsules($userId, $pdo) : 0;
$souvenirOpen = $userId ? countSouvenirsInOpenCapsules($userId, $pdo) : 0;
$capsuleClosed = $userId ? countClosedCapsules($userId, $pdo) : 0;

?>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>    
    const sidebar = document.getElementById('sidebar');
    const toggleSidebar = document.getElementById('toggleSidebar');

    if (toggleSidebar && sidebar) {
      toggleSidebar.addEventListener('click', () => {
        sidebar.classList.toggle('is-open');
      });
    }

    // Initialiser le diagramme
    const ctx = document.getElementById('statsChart');
    if (ctx) {
        new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['Capsules ouvertes', 'Souvenirs (ouvertes)', 'Capsules fermées'],
                datasets: [{
                    data: [<?php echo $capsuleOpen; ?>, <?php echo $souvenirOpen; ?>, <?php echo $capsuleClosed; ?>],
                    backgroundColor: [
                        'rgba(99, 102, 241, 0.8)',
                        'rgba(168, 85, 247, 0.8)',
                        'rgba(239, 68, 68, 0.8)'
                    ],
                    borderColor: [
                        'rgba(99, 102, 241, 1)',
                        'rgba(168, 85, 247, 1)',
                        'rgba(239, 68, 68, 1)'
                    ],
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            font: { size: 14, family: "'Plus Jakarta Sans', sans-serif" },
                            color: '#333'
                        }
                    },
                    title: {
                        display: true,
                        text: 'Statistiques des Capsules',
                        font: { size: 18, weight: 'bold', family: "'Plus Jakarta Sans', sans-serif" }
                    }
                }
            }
        });
    }
</script>
<header class="page-header">
  <div class="d-flex justify-content-between align-items-end flex-wrap gap-3 mb-4">
    <div>
      <div class="page-title-bar">
        <div class="title-accent"></div>
        <h2 class="page-title">Dashboard</h2>
      </div>
      <p class="page-subtitle mb-0">Vue d’ensemble des capsules, groupes et invitations.</p>
    </div>
    <a class="btn-primary-cv text-decoration-none" href="invitations.php">Voir les invitations</a>
  </div>
</header>

<section class="cards-section">
  <div class="row g-4 mb-4">
    <div class="col-12 col-md-6 col-lg-3">
      <div class="capsule-card" style="height:auto; min-height: 170px;">
        <div class="card-body-cv">
          <p class="card-category">Capsules totales</p>
          <h3 class="card-title-cv stat-number"><?php echo $totalCapsules; ?></h3>
          <p class="card-desc">+4 ce mois-ci</p>
        </div>
      </div>
    </div>

    <!-- Résultats des calculs -->
  <div class="row g-4 mb-4">
    <div class="col-12 col-lg-6">
      <div class="capsule-card" style="height:auto; min-height: 250px;">
        <div class="card-body-cv">
          <h3 class="card-title-cv mb-4">Résumé des Capsules</h3>
          <ul style="list-style: none; padding: 0;">
            <li style="padding: 0.75rem 0; border-bottom: 1px solid rgba(218,194,182,0.15);">
              <strong>Capsules créées par vous :</strong> 
              <span class="badge badge-primary"><?php echo $capsulesByUser; ?></span>
            </li>
            <li style="padding: 0.75rem 0; border-bottom: 1px solid rgba(218,194,182,0.15);">
              <strong>Capsules où vous êtes membre :</strong> 
              <span class="badge badge-secondary"><?php echo $capsulesMembership; ?></span>
            </li>
            <li style="padding: 0.75rem 0; border-bottom: 1px solid rgba(218,194,182,0.15);">
              <strong>Capsules ouvertes (total) :</strong> 
              <span class="badge badge-success"><?php echo $capsuleOpen; ?></span>
            </li>
            <li style="padding: 0.75rem 0;">
              <strong>Capsules fermées (total) :</strong> 
              <span class="badge badge-warning"><?php echo $capsuleClosed; ?></span>
            </li>
          </ul>
        </div>
      </div>
    </div>

    <div class="col-12 col-lg-6">
      <div class="capsule-card" style="height:auto; min-height: 250px;">
        <div class="card-body-cv">
          <canvas id="statsChart"></canvas>
        </div>
      </div>
    </div>
  </div>    
  

    <div class="col-12 col-md-6 col-lg-3">
      <div class="capsule-card" style="height:auto; min-height: 170px;">
        <div class="card-body-cv">
          <p class="card-category">Ouvertes</p>
          <h3 class="card-title-cv stat-number"><?php echo $totalOuvertes; ?></h3>
          <p class="card-desc">+2 aujourd’hui</p>
        </div>
      </div>
    </div>
    <div class="col-12 col-md-6 col-lg-3">
      <div class="capsule-card" style="height:auto; min-height: 170px;">
        <div class="card-body-cv">
          <p class="card-category">Invitations</p>
          <h3 class="card-title-cv stat-number"><?php echo $totalInvitations; ?></h3>
          <p class="card-desc">3 en attente</p>
        </div>
      </div>
    </div>
    <div class="col-12 col-md-6 col-lg-3">
      <div class="capsule-card" style="height:auto; min-height: 170px;">
        <div class="card-body-cv">
          <p class="card-category">Activité</p>
          <h3 class="card-title-cv stat-number"><?php echo $activitepourcentasge; ?>%</h3>
          <p class="card-desc">Stable</p>
        </div>
      </div>
    </div>
  </div>

  <div class="row g-4">
    <div class="col-12 col-lg-6">
      <div class="capsule-card" style="height:auto; min-height: 320px;">
        <div class="card-body-cv">
          <div class="d-flex justify-content-between align-items-center gap-3 mb-3">
            <h3 class="card-title-cv mb-0">Capsules récentes</h3>
            <button class="btn-filter" type="button">Filtrer</button>
          </div>

          <div class="d-flex flex-column gap-3">
            <div class="d-flex justify-content-between align-items-center gap-3 pb-3 border-bottom">
              <div>
                <strong>Cadeau anniversaire</strong>
                <div class="card-desc mb-0" style="-webkit-line-clamp:1; line-clamp:1; margin-bottom:0;">Famille · ouverture dans 12 jours</div>
              </div>
              <span class="badge-cv badge-soon">Verrouillée</span>
            </div>
            <div class="d-flex justify-content-between align-items-center gap-3 pb-3 border-bottom">
              <div>
                <strong>Projet équipe</strong>
                <div class="card-desc mb-0" style="-webkit-line-clamp:1; line-clamp:1; margin-bottom:0;">Travail · 2 pièces jointes</div>
              </div>
              <span class="badge-cv badge-sealed">Ouverte</span>
            </div>
            <div class="d-flex justify-content-between align-items-center gap-3">
              <div>
                <strong>Capsule souvenir</strong>
                <div class="card-desc mb-0" style="-webkit-line-clamp:1; line-clamp:1; margin-bottom:0;">Amis · 5 invités</div>
              </div>
              <span class="badge-cv badge-draft">Programmée</span>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="col-12 col-lg-6">
      <div class="capsule-card" style="height:auto; min-height: 320px;">
        <div class="card-body-cv">
          <div class="d-flex justify-content-between align-items-center gap-3 mb-3">
            <h3 class="card-title-cv mb-0">Invitations actives</h3>
            <a class="btn btn-link p-0 text-decoration-none" href="invitations.php" style="color: var(--color-primary); font-weight: 700;">Gérer</a>
          </div>

          <div class="d-flex flex-column gap-3">
            <div class="d-flex justify-content-between align-items-center gap-3 pb-3 border-bottom">
              <div>
                <strong>Marie Dupont</strong>
                <div class="card-desc mb-0" style="-webkit-line-clamp:1; line-clamp:1; margin-bottom:0;">Invitée à 2 capsules</div>
              </div>
              <span class="badge-cv badge-soon">Nouveau</span>
            </div>
            <div class="d-flex justify-content-between align-items-center gap-3">
              <div>
                <strong>Lucas Bernard</strong>
                <div class="card-desc mb-0" style="-webkit-line-clamp:1; line-clamp:1; margin-bottom:0;">Réponse attendue</div>
              </div>
              <span class="badge-cv badge-sealed">Accepté</span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>

