ChronoVault - README

1. Présentation du projet

ChronoVault est une application web en PHP et MySQL qui permet de créer des capsules temporelles.
L'utilisateur peut préparer des souvenirs aujourd'hui, les partager avec d'autres personnes via des invitations,
et consulter les contenus plus tard selon la date d'ouverture de la capsule.

Le projet a été pensé comme une plateforme simple, sécurisée et facile à déployer sur InfinityFree.

2. Objectif pédagogique

Ce projet illustre plusieurs notions vues en développement web :
- création d'un site dynamique avec PHP
- connexion à une base de données MySQL/MariaDB
- gestion des sessions utilisateur
- authentification et contrôle d'accès
- insertion, consultation et organisation de données
- upload de fichiers image

3. Fonctionnalités principales

- page d'accueil de présentation du projet
- inscription et connexion utilisateur
- tableau de bord personnel
- création de capsules temporelles
- ajout de souvenirs dans une capsule
- invitation d'autres utilisateurs à une capsule
- consultation des capsules accessibles
- gestion des paramètres du compte
- zone d'administration pour les comptes avec rôle administrateur

4. Technologies utilisées

- PHP
- MySQL / MariaDB
- Bootstrap 5 pour l'interface
- HTML5 / CSS3 / JavaScript

5. Structure du projet

- `index.php` : page d'accueil
- `connexion.php` : connexion à la base de données
- `pages/` : pages de l'application
- `includes/` : fonctions et éléments communs
- `css/` : styles personnalisés
- `bootstrap/` : fichiers Bootstrap locaux
- `images/` : images du projet
- `uploads/` : fichiers téléversés par les utilisateurs
- `projet.sql` : script de création et d'initialisation de la base de données

6. Base de données

La base de données s'appelle `chrono_vault`.

Tables principales :
- `utilisateur` : comptes utilisateurs
- `capsule` : capsules temporelles
- `invitation` : invitations envoyées aux membres
- `souvenir` : contenus ajoutés dans les capsules

Le fichier `projet.sql` contient aussi un compte administrateur de démonstration :
- email : `ENSIASD@edu.uiz.ac.ma`
- mot de passe : `ENSIASD2026`

7. Installation en local

1. Copier le dossier du projet dans le répertoire de votre serveur local, par exemple `htdocs` avec XAMPP.
2. Créer une base de données MySQL/MariaDB nommée `chrono_vault`.
3. Importer le fichier `projet.sql` dans cette base de données.
4. Vérifier les paramètres de connexion dans `connexion.php`.
5. Ouvrir `index.php` dans le navigateur.

Identifiants de test (compte administrateur) :
- Email : ENSIASD@edu.uiz.ac.ma
- Mot de passe : ENSIASD2026

8. Déploiement sur InfinityFree

InfinityFree est utilisé comme hébergement final du projet.

Étapes recommandées :
1. Créer un compte InfinityFree et un nouvel espace d'hébergement.
2. Créer une base de données MySQL depuis le panneau de contrôle InfinityFree.
3. Importer le fichier `projet.sql` dans cette base de données.
4. Modifier `connexion.php` avec les identifiants fournis par InfinityFree.
5. Uploader tous les fichiers du projet dans le dossier `htdocs` ou `public_html` selon la structure du compte.
6. Vérifier que les dossiers `uploads/` et `images/` sont bien présents et accessibles en écriture si nécessaire.
7. Tester la page d'accueil puis la connexion utilisateur.

Points importants pour InfinityFree :
- utiliser les identifiants MySQL fournis par l'hébergeur
- vérifier le nom exact de la base de données
- conserver l'encodage `utf8mb4`
- s'assurer que les chemins relatifs sont corrects après le transfert

9. Remarques pour la correction

Ce projet met l'accent sur la logique métier suivante :
- un utilisateur crée une capsule
- il peut ajouter des souvenirs
- il peut inviter d'autres utilisateurs
- les membres voient uniquement les capsules auxquelles ils ont accès
- l'ouverture d'une capsule dépend de sa date d'ouverture

10. Lancement rapide

Si la base est déjà importée et la connexion configurée, il suffit d'ouvrir la page d'accueil du site pour accéder à l'application.

Pour tester rapidement, connectez-vous en tant qu'administrateur :
- Email : ENSIASD@edu.uiz.ac.ma
- Mot de passe : ENSIASD2026
