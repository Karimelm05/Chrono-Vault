<?php
$host = 'localhost';
$dbname = 'chrono_vault';
$user = 'root';
$password = '';
$dsn = "mysql:host=$host;dbname=$dbname;charset=utf8mb4";
$options = [
// Afficher les erreurs sous forme d'exceptions
PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
// Retourner les résultats en tableau associatif par défaut
PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
// Désactiver l'émulation pour de vraies requêtes préparées
PDO::ATTR_EMULATE_PREPARES => false,
];
try {
$pdo = new PDO($dsn, $user, $password, $options);
//echo "Connexion réussie à la base de données";
} catch (PDOException $e) {
die('Connexion échouée : ' . $e->getMessage());
}
?>
