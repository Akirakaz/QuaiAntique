# Restaurant QuaiAntique

### Cloner le projet

- Avec git `git clone https://github.com/Akirakaz/QuaiAntique.git`
- En téléchargeant le zip https://github.com/Akirakaz/QuaiAntique/archive/refs/heads/main.zip (puis en le dézippant dans un dossier)
- Naviguer dans le dossier du projet.

### Installation

Depuis votre terminal tapez les commandes suivantes:

- `composer install`
- `npm install`

Pour la génération des assets, tapez:

- `npm run build`

### Configuration

- Copier le fichier `.env` en `.env.local`
- Modifier le `.env.local` en y ajoutant vos identifiants de base de donnée.

### Création de base de donnée

Une fois la base de donnée configurée dans le `.env.local`;

Dans votre terminal tapez les commandes suivantes:

```
php bin/console doctrine:database:create
php bin/console doctrine:migrations:migrate
```

### Fixtures

Dans votre terminal tapez les commandes suivantes:

```
php bin/console doctrine:fixtures:load
```

Pour finir il vous reste a lancer le projet avec la commande suivante:

Si vous utilisez l'executable Symfony (disponible sur: [https://symfony.com/download](https://symfony.com/download))

```
symfony server:start
```

Sinon vous pouvez lancer le projet via php

```
php -S localhost:8000 -t public/
```

### Déploiement sur un serveur

Au moment de la modification du `.env.local`, n'oubliez pas de passer le paramètre `APP_ENV` à `prod` au lieu de `dev`

### Identifiants par défaut

Par défaut des comptes ont été crées avec les fixtures

Un utilisateur client

```
email: user@demo.com
mot de passe: user_password
```

Un utilisateur administrateur

```
email: admin@demo.com
mot de passe: admin_password
```

Il est toutefois possible d'ajouter un autre administrateur via une commande dans le terminal:

```
php bin/console app:createadmin 

Exemple: php bin/console app:createadmin user@domain.tld my_strong_password 
```