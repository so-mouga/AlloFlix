# AlloFilx




## Prérequis
L'application est installée avec docker et docker compose, ces outils sont nécessaires pour utiliser l'application. 

Assurez-vous que vous n'avez aucun service qui est sur les ports 82 et 8081 avant de poursuivre l'installation.

## Installation
Clonez le repository

~~~
git clone https://github.com/so-mouga/AlloFlix.git
~~~

L'installation est très simple. 

1. Placez vous sur le projet 
~~~
- cd AlloFlix
~~~
2. Exécutez le ficher docker compose
~~~
- docker-compose up -d --build
~~~

3. Exécutez composer
~~~
- docker-compose exec php composer install
~~~

4. Installation des fixtures 
~~~
-  php bin/console doctrine:fixtures:load
~~~

5. Importation des films à partir du fichier csv
~~~
-  php bin/console ImportCSV
~~~

6. Créer un administrateur à partir de la console de commande 
~~~
-  php bin/console app:create:admin "login" "email" "password"
~~~

Une fois les conteneurs prêts et démarrés, ouvrez l'url http://localhost:8082 dans le navigateur. 


## Base de donnée
Pour accéder à la base donnée ouvrez l'url http://localhost:8081

~~~
Server = db
Username = admin
Password = admin
database = alloflix	
~~~

## Utilisation du site

Jeux de donnés utilisateurs 
~~~
Admin : 
- login :Paul@gmail.com
- mdp : test
User :
- login : Kevin@gmail.com	
- mdp : test

- login : Nasser@gmail.com
- mdp : test
~~~

Fonctionnaliter partie user (ROLE_USER)
~~~
- Inscription / Connexion 
- Faire une recherche d'un film
- Lister les films par catégories et par notes
- Voir les ajouts des films récents 
- Afficher le détail du film
- Regarder un film
- Passer au film suivant si il dispose d'une suite
- Suggérer des films 
- Modifier les paramètres / préférences utilisateur
- Ajouter un coeur sur un film 
- Ajouter / supprimer un film de la liste "à regarder plus tard"
~~~

Fonctionnaliter partie admin (ROLE_ADMIN)

~~~
url : http://localhost:8082/admin/films

toutes les Fonctionnaliters user + 
- CRUD catégorie de film
- CRUD acteur/producteur
- CRUD film, mettre des films en avant ...
- CRUD saga
- CRUD user, gestion des bans etc ....
~~~

