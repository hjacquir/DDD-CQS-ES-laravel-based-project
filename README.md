# DDD-CQS-ES-laravel-based-project
Ce repos contient un exemple de projet initialiement pour gérer des offres et des produits sur du 
laravel que je migre sur du DDD et en architecture hexagonale.
## Commandes
* Démarrage : ``composer install && npm ci && php artisan key:generate && php artisan migrate --seed && php artisan storage:link && npm run build``
* Tests : ``php artisan db:wipe && php artisan migrate --seed && service apache2 reload && php artisan test``
* Xdebug enable : ``docker compose  exec webserver /usr/local/bin/xdebug.sh enable && docker compose  exec webserver service apache2 reload``
* Xdebug disable : ``docker compose  exec webserver /usr/local/bin/xdebug.sh disable && docker compose  exec webserver service apache2 reload``
* Cache clear : ``php artisan cache:clear && php artisan config:clear && php artisan view:clear``
## Done
* set up env. de dev. local avec Docker minimaliste et Xdebug.
* ajout tests d'intégration pour la non régression en vue du refactoring.
* introduction DDD et implémentation des uses case : affichage offres et création produits.

## To do
* Extensions DDD :
    * ajout des Specifications métiers dans les Handler
    * déplacement namespace : View -> Infrastructure
    * use case : ajout et extension à la nouvelle archi
    * exceptions custom DDD
* Divers :
    * gestion des erreurs dans le client (controllers) :
        * try catch,
        * user friendly output message
        * logs applicatifs avec contexte
    * controllers : cache list, pagination
    * api :
        * authentification
        * cache
        * rate limit
        * filter et pagination
    * traitement asynchrone upload image
    * tests unitaires : Handlers, Factory
    * tests intégration : optimisations
    * ajout MakeFile
    * documentations :
        * archi DDD :
            * comportement et responsabilités de l'existant,
            * diagramme séquence (plantUML)
            * ajouter de nouveaux comportements
        * commandes usuelles env. de dev.
    * intégration des outils de qualité de code et déclencher analyse au git hook commit : phpStan, phpCs
    * profiler : laravel profiler ou xdebug profiling
