# --- Développement d'une application Web de consultation et modification de serie TV ---

Axphyr


## Serveur Web local

Lancez votre serveur Web local (Linux) à la racine du projet  avec la commande :
```
composer run-server
```

Pour consulter le contenu : [serveur](http://localhost:8000/)



## Configuration de la base de données

fichier `.mypdo.ini` : permet la connexion à la base de donnée au lancement du server local.

```
[mypdo]
dsn = 'mysql:host=mysql;dbname=tvshow;charset=utf8'
username = ''
password = ''
```



## Style de codage

La correction de PHP CS Fixer peut être facilitée par des scripts Composer, de ce fait, il est possible de lancer, avec les commandes suivantes :

une vérification :
```
composer test:cs
```
une correction :
```
composer fix:cs
```












