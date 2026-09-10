# Changelog

Toutes les modifications importantes de ce projet sont documentées dans ce fichier.

## [1.0.0] - Version finale

### Ajouté

* Gestion des salles universitaires.
* Création et modification des salles.
* Activation et désactivation des salles.
* Consultation du détail d'une salle.
* Gestion des réservations.
* Création et annulation des réservations.
* Validation des données des formulaires.
* Vérification des règles métier de réservation.
* Vérification des conflits de réservation.
* Gestion des exceptions.
* Routage avec FastRoute.
* Injection de dépendances avec PHP-DI.
* API JSON pour les salles et les réservations.
* Tests unitaires et tests d'intégration.
* Interface web avec mise en forme CSS.
* Configuration Docker avec Nginx, PHP-FPM et MySQL.

### Architecture

* Séparation des responsabilités entre Controllers, DTO, Validation, Services, Repositories et Models.
* Utilisation d'Eloquent comme ORM.
* Utilisation du pattern Strategy pour les règles métier de réservation.
* Utilisation de l'injection de dépendances.
* Centralisation de la construction des objets avec PHP-DI.
* Utilisation de `SessionManager` pour les messages de session.

### Sécurité et bonnes pratiques

* Les données provenant des requêtes HTTP sont validées avant utilisation.
* Les dépendances sont injectées par constructeur.
* Les secrets de configuration ne sont pas versionnés.
* Le dossier `vendor/` n'est pas versionné.
* Le fichier `composer.lock` est versionné.
* Les erreurs inattendues sont traitées avec une réponse HTTP 500.

## [0.13.0]

### Ajouté

* Mise en place des tests unitaires.
* Mise en place des tests d'intégration.
* Tests des validateurs.
* Tests des DTO.
* Tests des repositories.
* Tests des services et des stratégies métier.

## [0.12.0]

### Ajouté

* API JSON pour les salles.
* API JSON pour les réservations.
* Consultation d'une salle au format JSON.
* Consultation d'une réservation au format JSON.

## [0.11.0]

### Ajouté

* Mise en place du conteneur PHP-DI.
* Configuration de l'autowiring.
* Association des interfaces à leurs implémentations.
* Centralisation de la construction des dépendances.

## [0.10.0]

### Ajouté

* Mise en place du routage avec FastRoute.
* Séparation des routes dans `routes/web.php`.
* Gestion des routes GET et POST.
* Gestion des paramètres numériques avec `\d+`.
* Gestion des réponses 404 et 405.

## [0.9.0]

### Ajouté

* Création de l'interface web.
* Vues des salles.
* Vues des réservations.
* Formulaire de création de réservation.
* Messages de succès et d'erreur.

## [0.8.0]

### Ajouté

* Création du `ReservationService`.
* Déplacement des règles métier dans le service.
* Mise en place du pattern Strategy.
* Gestion des exceptions métier.
* Vérification de l'existence et de l'activité d'une salle.
* Vérification des dates.
* Vérification de la durée maximale.
* Vérification que la réservation commence dans le futur.
* Vérification des conflits de réservation.

## [0.7.0]

### Ajouté

* Création des interfaces de repositories.
* Création des repositories Eloquent.
* Séparation de l'accès aux données du reste de l'application.

## [0.6.0]

### Ajouté

* Création des DTO.
* Création de `CreerReservationDTO`.
* Transformation des données validées en objets métier adaptés au service.

## [0.5.0]

### Ajouté

* Création de `ValidatorInterface`.
* Création de `SalleValidator`.
* Création de `ReservationValidator`.
* Création de `ValidationResult`.
* Validation des données provenant des formulaires avec Respect\Validation.

## [0.4.0]

### Ajouté

* Création du système de données initiales.
* Mise en place du seeder.
* Ajout des salles initiales.
* Utilisation de `firstOrCreate()` pour éviter les doublons.

## [0.3.0]

### Ajouté

* Création des modèles Eloquent `Salle` et `Reservation`.
* Définition des champs remplissables.
* Mise en place des casts.
* Mise en place des relations `hasMany` et `belongsTo`.

## [0.2.0]

### Ajouté

* Installation et configuration d'Eloquent.
* Configuration de `Capsule\Manager`.
* Connexion à MySQL.

## [0.1.0]

### Ajouté

* Initialisation de Composer.
* Configuration de l'autoload PSR-4.
* Installation des dépendances du projet.

## [0.0.0]

### Ajouté

* Initialisation du dépôt Git.
* Création de la structure initiale du projet.
* Création du fichier `.gitignore`.
* Création du README.
