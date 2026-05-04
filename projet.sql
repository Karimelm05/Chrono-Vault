-- Export SQL de la base de donnees.
-- Remplacez ce contenu par votre export complet (schema + donnees de test).
CREATE TABLE Utilisateur(
   Id_Utilisateur COUNTER,
   nom VARCHAR(50) NOT NULL,
   email VARCHAR(100) NOT NULL,
   mot_de_passe VARCHAR(255) NOT NULL,
   role VARCHAR(50),
   PRIMARY KEY(Id_Utilisateur)
);

CREATE TABLE Capsule(
   Id_Capsule COUNTER,
   titre VARCHAR(100),
   description VARCHAR(500),
   date_creation DATETIME,
   date_ouverture DATETIME,
   statut_ouverture LOGICAL NOT NULL,
   Id_Utilisateur INT NOT NULL,
   PRIMARY KEY(Id_Capsule),
   FOREIGN KEY(Id_Utilisateur) REFERENCES Utilisateur(Id_Utilisateur)
);

CREATE TABLE Souvenir(
   Id_Souvenir COUNTER,
   type VARCHAR(50),
   donnee VARCHAR(100),
   date_poste DATETIME,
   Id_Utilisateur INT NOT NULL,
   Id_Capsule INT NOT NULL,
   PRIMARY KEY(Id_Souvenir),
   FOREIGN KEY(Id_Utilisateur) REFERENCES Utilisateur(Id_Utilisateur),
   FOREIGN KEY(Id_Capsule) REFERENCES Capsule(Id_Capsule)
);

CREATE TABLE Invitation(
   Id_Invitation COUNTER,
   statut VARCHAR(50),
   date_envoi DATETIME,
   Id_Capsule INT NOT NULL,
   Id_Utilisateur INT NOT NULL,
   PRIMARY KEY(Id_Invitation),
   FOREIGN KEY(Id_Capsule) REFERENCES Capsule(Id_Capsule),
   FOREIGN KEY(Id_Utilisateur) REFERENCES Utilisateur(Id_Utilisateur)
);