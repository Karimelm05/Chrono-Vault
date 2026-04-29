Utilisateur = (Id_Utilisateur COUNTER, nom VARCHAR(50), email VARCHAR(100), mot_de_passe VARCHAR(50), role VARCHAR(50));
Capsule = (Id_Capsule COUNTER, titre VARCHAR(100), description VARCHAR(500), date_creation DATETIME, date_ouverture DATETIME, statut_ouverture LOGICAL, #Id_Utilisateur);
Souvenir = (Id_Souvenir COUNTER, type VARCHAR(50), donnee VARCHAR(100), date_poste DATETIME, #Id_Utilisateur, #Id_Capsule);
Invitation = (Id_Invitation COUNTER, statut VARCHAR(50), date_envoi DATETIME, #Id_Capsule, #Id_Utilisateur);
