<?php
/**
 * Script d'installation de la base de données ChronoVault
 * Accédez à http://localhost/TP7/Chrono-Vault/install.php pour créer la base
 */

$host = 'localhost';
$user = 'root';
$password = '';
$dbname = 'chrono_vault';

try {
    // Connexion à MySQL sans spécifier la base
    $pdo = new PDO("mysql:host=$host;charset=utf8mb4", $user, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);

    // Créer la base de données
    $pdo->exec("CREATE DATABASE IF NOT EXISTS $dbname");
    $pdo->exec("USE $dbname");

    echo "<h2>Installation de ChronoVault</h2>";

    // Créer la table Utilisateur
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS Utilisateur (
            Id_Utilisateur INT AUTO_INCREMENT PRIMARY KEY,
            nom VARCHAR(50) NOT NULL,
            email VARCHAR(100) NOT NULL UNIQUE,
            mot_de_passe VARCHAR(255) NOT NULL,
            role VARCHAR(50) DEFAULT 'user',
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )
    ");
    echo "<p>✓ Table Utilisateur créée</p>";

    // Créer la table Capsule
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS Capsule (
            Id_Capsule INT AUTO_INCREMENT PRIMARY KEY,
            titre VARCHAR(100),
            description VARCHAR(500),
            date_creation DATETIME,
            date_ouverture DATETIME,
            statut_ouverture BOOLEAN NOT NULL DEFAULT FALSE,
            Id_Utilisateur INT NOT NULL,
            FOREIGN KEY(Id_Utilisateur) REFERENCES Utilisateur(Id_Utilisateur) ON DELETE CASCADE
        )
    ");
    echo "<p>✓ Table Capsule créée</p>";

    // Créer la table Souvenir
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS Souvenir (
            Id_Souvenir INT AUTO_INCREMENT PRIMARY KEY,
            type VARCHAR(50),
            donnee VARCHAR(500),
            date_poste DATETIME,
            Id_Utilisateur INT NOT NULL,
            Id_Capsule INT NOT NULL,
            FOREIGN KEY(Id_Utilisateur) REFERENCES Utilisateur(Id_Utilisateur) ON DELETE CASCADE,
            FOREIGN KEY(Id_Capsule) REFERENCES Capsule(Id_Capsule) ON DELETE CASCADE
        )
    ");
    echo "<p>✓ Table Souvenir créée</p>";

    // Créer la table Invitation
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS Invitation (
            Id_Invitation INT AUTO_INCREMENT PRIMARY KEY,
            statut VARCHAR(50) DEFAULT 'pending',
            date_envoi DATETIME,
            Id_Capsule INT NOT NULL,
            Id_Utilisateur INT NOT NULL,
            FOREIGN KEY(Id_Capsule) REFERENCES Capsule(Id_Capsule) ON DELETE CASCADE,
            FOREIGN KEY(Id_Utilisateur) REFERENCES Utilisateur(Id_Utilisateur) ON DELETE CASCADE
        )
    ");
    echo "<p>✓ Table Invitation créée</p>";

    // Insérer les utilisateurs de test
    $admin_password = password_hash('admin123', PASSWORD_DEFAULT);
    $test_password = password_hash('test123', PASSWORD_DEFAULT);
    $user_password = password_hash('user123', PASSWORD_DEFAULT);

    $pdo->exec("DELETE FROM Utilisateur");

    $stmt = $pdo->prepare("
        INSERT INTO Utilisateur (nom, email, mot_de_passe, role) 
        VALUES (?, ?, ?, ?)
    ");

    $stmt->execute(['Admin ChronoVault', 'admin@chrono-vault.com', $admin_password, 'admin']);
    echo "<p>✓ Utilisateur admin créé</p>";

    $stmt->execute(['Test User', 'test@example.com', $test_password, 'user']);
    echo "<p>✓ Utilisateur test créé</p>";

    $stmt->execute(['Karim Elmeski', 'karim@example.com', $user_password, 'user']);
    echo "<p>✓ Utilisateur Karim créé</p>";

    echo "<hr>";
    echo "<h3>Identifiants de connexion:</h3>";
    echo "<table border='1' cellpadding='10'>";
    echo "<tr><th>Email</th><th>Mot de passe</th><th>Rôle</th></tr>";
    echo "<tr><td>admin@chrono-vault.com</td><td>admin123</td><td>admin</td></tr>";
    echo "<tr><td>test@example.com</td><td>test123</td><td>user</td></tr>";
    echo "<tr><td>karim@example.com</td><td>user123</td><td>user</td></tr>";
    echo "</table>";

    echo "<hr>";
    echo "<p><strong>Installation réussie!</strong></p>";
    echo "<p><a href='index.php'>Retour à l'accueil</a></p>";

} catch (PDOException $e) {
    echo "<h2 style='color: red;'>Erreur lors de l'installation</h2>";
    echo "<p>" . htmlspecialchars($e->getMessage()) . "</p>";
    echo "<p>Vérifiez que:</p>";
    echo "<ul>";
    echo "<li>MySQL est en cours d'exécution</li>";
    echo "<li>L'utilisateur root est sans mot de passe</li>";
    echo "<li>Vous avez les droits de créer des bases de données</li>";
    echo "</ul>";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Installation ChronoVault</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        table { border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
</body>
</html>
