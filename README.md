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

### Quel rôle joue Capsule\Manager ? 
Il configure et gère la connexion d'Eloquent à la base de données.
### Pourquoi Eloquent peut fonctionner sans Laravel ?
Parce qu'Eloquent est disponible comme composant PHP séparé (illuminate/database). Laravel l'utilise, mais il n'est pas nécessaire pour utiliser le composant.
### Où doit se trouver le démarrage de l’ORM ?
 Dans la partie configuration/bootstrap de l'application, pas dans les contrôleurs, services ou modèles.
### Quelle différence existe entre ORM et SQL écrit à la main ? 
Avec SQL écrit à la main, on écrit directement les requêtes SQL. Avec un ORM comme Eloquent, on manipule des objets/modèles PHP qui permettent d'interagir avec les tables.

### Quel type de relation Eloquent avez-vous utilisé ?
hasMany dans Salle : une salle peut avoir plusieurs réservations.
belongsTo dans Reservation : une réservation appartient à une seule salle.
### Quelle est la différence entre hasMany et belongsTo ?
Ils servent à protéger le modèle contre le remplissage massif.
$fillable indique les champs que l'on autorise à remplir automatiquement.
$guarded indique les champs que l'on interdit de remplir automatiquement.
### Pourquoi utiliser $fillable ou $guarded ?
La colonne active indique simplement si une salle est active ou non.
Avec le cast boolean, Eloquent transforme la valeur en PHP en :
true → salle active ;
false → salle inactive.
### Pourquoi convertir active en booléen et les dates en objets ?
Une date ne sert pas seulement à être affichée : dans notre projet, nous devons comparer et calculer les dates.