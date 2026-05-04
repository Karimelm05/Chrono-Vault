<?php
/**
 * App Layout Wrapper - Fournit l'enveloppe HTML complète pour les pages app
 * Variables attendues: $pageTitle, $activePage
 */

$pageTitle = $pageTitle ?? 'ChronoVault';
$activePage = $activePage ?? '';
?><!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?php echo htmlspecialchars($pageTitle, ENT_QUOTES, 'UTF-8'); ?> | ChronoVault</title>
  
  <!-- Bootstrap 5 -->
  <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
  
  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet">
  
  <!-- Theme & Styles -->
  <link rel="stylesheet" href="../css/variables.css">
  <link rel="stylesheet" href="../css/style.css">
</head>
<body class="cv-shell">
  <div class="cv-layout">
    <?php include __DIR__ . '/sidebar.php'; ?>
    <main class="cv-main">
