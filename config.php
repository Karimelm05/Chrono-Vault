<?php
// Configuration globale de l'application.

define('APP_NAME', 'Mini Projet');
define('APP_ENV', 'local');

// Parametres de connexion a la base de donnees.
define('DB_HOST', 'localhost');
define('DB_NAME', 'chrono_vault');
define('DB_USER', 'root');
define('DB_PASS', '');

try {
    $pdo = new PDO(
        'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8mb4',
        DB_USER,
        DB_PASS,
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );
} catch (PDOException $e) {
    die('Erreur de connexion BDD : ' . $e->getMessage());
}
