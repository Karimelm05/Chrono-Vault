/**
 * ChronoVault - Main JavaScript
 * Comportements centralisés et réutilisables
 */

document.addEventListener("DOMContentLoaded", () => {
  // ═══════════════════════════════════════════════
  // Sidebar Toggle (utilisé sur mobile)
  // ═══════════════════════════════════════════════
  const sidebar = document.getElementById('sidebar');
  const toggleSidebar = document.getElementById('toggleSidebar');

  if (toggleSidebar && sidebar) {
    toggleSidebar.addEventListener('click', () => {
      sidebar.classList.toggle('is-open');
    });
  }

  // Fermer sidebar si clique ailleurs
  document.addEventListener('click', (e) => {
    if (sidebar?.classList.contains('is-open')) {
      if (!sidebar.contains(e.target) && !toggleSidebar?.contains(e.target)) {
        sidebar.classList.remove('is-open');
      }
    }
  });

  console.log("ChronoVault initialized");
});
