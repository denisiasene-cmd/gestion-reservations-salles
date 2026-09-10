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

### Quelle différence entre migration et seeder ?
Migration = crée ou modifie la structure de la base de données.
Seeder = insère les données initiales dans cette structure.
### Pourquoi les données initiales doivent-elles être reproductibles ?
Parce qu'on doit pouvoir relancer le seed plusieurs fois et obtenir le même état sans créer de doublons.
### Comment empêcher les doublons ?
firstOrCreate() il nous aide a rechercher si la existe et si oui il ne le recree pas et si non il le cree .

### Pourquoi séparer la validation syntaxique des règles métier ?
Parce que la validation syntaxique vérifie le format des données, tandis que les règles métier vérifient les règles de l’application.
### Pourquoi créer une interface de validation ?
 Pour que tous les validateurs suivent la même structure.
### Pourquoi le validateur ne doit-il pas enregistrer les données ?
Parce que son rôle est seulement de vérifier les données. L’enregistrement est fait par une autre partie du projet.
### Comment retourner plusieurs erreurs en une seule fois ?
On met toutes les erreurs dans un tableau, puis on les retourne dans ValidationResult.

### Quelle différence existe entre DTO et modèle Eloquent ? 
 Le DTO transporte les données. Le modèle Eloquent représente une table de la base de données.
### Pourquoi le DTO ne doit-il pas appeler save() ? 
 Parce que son rôle est seulement de transporter les données, pas de les enregistrer.
### À quel moment transforme-t-on les chaînes en dates ?
Avant de créer le DTO, après avoir validé les données.
### Le DTO doit-il contenir la règle de chevauchement ? 
Le chevauchement est une règle métier, donc il sera géré par le service.

### Eloquent constitue-t-il déjà un accès aux données ? 
Oui, Eloquent permet d'accéder à la base de données.
### Pourquoi ajouter un Repository au-dessus d’Eloquent ?
Pour séparer l'accès aux données du reste de l'application.
### Cette abstraction est-elle toujours nécessaire ?
Non, surtout pour une petite application.
### Quel avantage apporte-t-elle ?
Elle rend le code plus organisé et plus facile à modifier et tester.

### Pourquoi ces règles ne sont-elles pas dans le contrôleur ?
Parce que le contrôleur doit gérer HTTP, pas les règles métier.
### Pourquoi le service dépend-il d’une interface de Repository ?
Pour séparer le métier de l’accès aux données.
### Quelle exception doit être levée en cas de conflit ?
SalleIndisponibleException.
### Comment tester le service sans MySQL ?
 En utilisant des repositories simulés (mocks).


### Pourquoi FastRoute ne construit-il pas lui-même le contrôleur ?
Parce que FastRoute sert seulement à trouver quelle route correspond à l’URL.
C’est PHP-DI qui construit le contrôleur.
### Quelle différence existe entre 404 et 405 ?
404  la route n’existe pas.
405  la route existe, mais la méthode HTTP utilisée n’est pas autorisée.
### Pourquoi contraindre {id} avec \d+ ?
\d+ signifie un ou plusieurs chiffres.
Donc /salles/5 est accepté, mais /salles/abc ne l’est pas
### Quel composant doit interpréter le handler retourné ?
Qui interprète le handler retourné par FastRoute ?
C’est public/index.php.
Il récupère le contrôleur avec PHP-DI, puis appelle la bonne méthode.

### Quelle différence existe entre injection et conteneur ?
 Injection : on donne à une classe ce dont elle a besoin.
 Conteneur : il crée et fournit ces objets.
### Qu’est-ce que l’autowiring ?
PHP-DI trouve automatiquement les dépendances d'une classe.
### Pourquoi les interfaces nécessitent-elles une définition ?
Parce qu'une interface ne peut pas être créée directement. Il faut dire quelle classe utiliser.
### Pourquoi limiter $container->get() au point d’entrée ?
Pour éviter que toutes les classes dépendent du conteneur.
### Quel anti-pattern apparaît si toutes les classes interrogent le conteneur ?
Le Service Locator : les classes vont chercher elles-mêmes leurs dépendances dans le conteneur.

