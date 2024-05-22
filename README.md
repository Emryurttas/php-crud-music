# Développement d'une application Web de consultation et modification de morceaux de musique
## Auteur : YURTTAS Emre
## Installation / Configuration

##  comment lancer le serveur Web local dans une partie « Serveur Web local » ?
1. Installer php
2. Ouvrez un terminal et accédez au répertoire racine de votre projet
3. Lancez le serveur PHP intégré avec la commande : 
>     php -d display_errors -S localhost:8000 -t public/

4. Une fois le serveur lancé, ouvrez votre navigateur Web et accédez à l'URL http://localhost:8000 pour voir votre application en cours d'exécution.

## Style de codage

>php vendor/bin/php-cs-fixer fix --dry-run

Cette commande vérifie le code pour les problèmes de style et d'indentation, mais ne fait aucune modification. C'est utile pour voir quels fichiers ou quelles parties de votre code doivent être corrigés.

>php vendor/bin/php-cs-fixer fix --dry-run --diff

 Cette commande est similaire à la précédente, mais elle affiche également les modifications proposées avant de les appliquer.

>php vendor/bin/php-cs-fixer fix

Cette commande applique effectivement les corrections au code. Les corrections sont apportées directement aux fichiers.

## Script composer

Ajout des script composer pour faciliter les tests

>    "scripts": {\
        "start:linux": "php -S localhost:8000 -t public",\
        "test:cs": "vendor/bin/php-cs-fixer fix --dry-run",\
        "fix:cs": "vendor/bin/php-cs-fixer fix",\
        "config": {
            "process-timeout": 0
        }\
    }

##  Configuration de la base de données
>on creer le fichier .mypdo.ini afin de simplifier la configuration de la base de donnée

## Tests
composer test:codecept
>Permet de lancer les tests de codeception
composer test
