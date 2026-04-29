# ChronoVault - Digital Time Capsule

**ChronoVault** est une application web innovante permettant aux utilisateurs de créer, gérer et partager des capsules temporelles numériques. L'objectif est de redonner de la valeur à l'attente en stockant des souvenirs (messages, photos) qui ne seront révélés qu'à une date future choisie.

---

## Fonctionnalités principales
* **Gestion des comptes** : Inscription et connexion sécurisées des utilisateurs.
* **Création de capsules** : Interface intuitive pour sceller des contenus multimédias.
* **Contrôle temporel** : Confidentialité totale des contenus jusqu'à la date d'ouverture définie.
* **Tableau de bord** : Suivi des capsules personnelles, invitations reçues et notifications.
* [cite_start]**Administration** : Panel de gestion pour le rôle administrateur[cite: 35].

## Stack Technique
* **Frontend** : HTML5, CSS3 (Bootstrap), JavaScript.
* **Backend** : PHP 8.x.
* **Base de données** : MySQL avec extension PDO pour la sécurité (requêtes préparées).
* [cite_start]**Architecture** : Modulaire avec séparation des vues et de la logique de configuration[cite: 11, 12, 13].

## Structure du Projet
[cite_start]Le projet suit une arborescence stricte imposée par les consignes[cite: 11, 12]:

* [cite_start]`index.php` : Point d'entrée et accueil[cite: 13].
* [cite_start]`config.php` : Connexion BDD et constantes globales[cite: 13].
* [cite_start]`pages/` : Contient les vues (dashboard, login, capsules, etc.)[cite: 13].
* [cite_start]`includes/` : Composants réutilisables (navbar, header, footer)[cite: 13].
* [cite_start]`css/`, `js/`, `images/` : Ressources statiques[cite: 13].
* [cite_start]`doc/` : Documentation, diagrammes (MCD/MLD) et captures d'écran[cite: 13].
* [cite_start]`projet.sql` : Export complet de la base de données avec données de test[cite: 13, 15].

## Installation et Lancement
1. **Clonage** : 
   ```bash
   git clone [https://github.com/Karimelm05/Chrono-Vault.git](https://github.com/Karimelm05/Chrono-Vault.git)
