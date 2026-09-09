# Gestion des réservations de salles

Application web universitaire de gestion des réservations de salles.

Projet réalisé en PHP orienté objet avec MySQL, Eloquent, Nginx, Docker et plusieurs composants Composer.


### Quelle est le rôle de Composer ?
Composer gère les dépendances et l’autoload du projet. Il permet d’installer et de gérer les bibliothèques que nous allons utiliser dans notre projet.
### Quelle différence existe entre require et require-dev ?
--require peut être vu comme les dépendances qu’on utilise pour le fonctionnement du projet, c’est-à-dire ce dont l’application a besoin pour fonctionner.
--require-dev correspond à ce dont le développeur a besoin pour tester si l’application ou le code fonctionne.
### Pourquoi faut-il versionner composer.lock ?
Il faut versionner composer.lock parce qu’il permet de garder les versions exactes des dépendances installées et de conserver les traces des bibliothèques utilisées dans le projet.
### Pourquoi ne versionne-t-on pas vendor/ ?
On ne versionne pas le dossier vendor/ parce qu’il contient les bibliothèques installées par Composer et qu’il peut être recréé avec la commande composer install.

