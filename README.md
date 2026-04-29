# ChronoVault - Digital Time Capsule

**ChronoVault** est une application web innovante permettant aux utilisateurs de créer, gérer et partager des capsules temporelles numériques. L'objectif est de redonner de la valeur à l'attente en stockant des souvenirs (messages, photos) qui ne seront révélés qu'à une date future choisie.

---

## Fonctionnalités principales
* **Gestion des comptes** : Inscription et connexion sécurisées des utilisateurs.
* **Création de capsules** : Interface intuitive pour sceller des contenus multimédias.
* **Contrôle temporel** : Confidentialité totale des contenus jusqu'à la date d'ouverture définie.
* **Tableau de bord** : Suivi des capsules personnelles, invitations reçues et notifications.
* **Administration** : Panel de gestion pour le rôle administrateur.

## Stack Technique
* **Frontend** : HTML5, CSS3 (Bootstrap), JavaScript.
* **Backend** : PHP 8.x.
* **Base de données** : MySQL avec extension PDO pour la sécurité (requêtes préparées).
* **Architecture** : Modulaire avec séparation des vues et de la logique de configuration.

## Structure du Projet
Le projet suit une arborescence stricte imposée par les consignes:

* `index.php` : Point d'entrée et accueil.
* `config.php` : Connexion BDD et constantes globales.
* `pages/` : Contient les vues (dashboard, login, capsules, etc.).
* `includes/` : Composants réutilisables (navbar, header, footer).
* `css/`, `js/`, `images/` : Ressources statiques.
* `doc/` : Documentation, diagrammes (MCD/MLD) et captures d'écran.
* `projet.sql` : Export complet de la base de données avec données de test.

## Installation et Lancement
1. **Clonage** : 
   ```bash
   git clone [https://github.com/Karimelm05/Chrono-Vault.git](https://github.com/Karimelm05/Chrono-Vault.git)
