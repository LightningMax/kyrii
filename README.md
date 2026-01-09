# Kyrii

Une application Symfony pour un site de vente de mangas avec authentification, profil utilisateur, formulaire de contact, et gestion CRUD des mangas.

## 🛠️ Prérequis

-   PHP 8.3 ou supérieur

-   Composer

-   Symfony CLI (recommandé)

-   Base de données (MySQL, MariaDB ou SQLite pour dev)

-   Serveur SMTP ou outil comme MailHog pour tester les emails

## ⚡ Installation

Cloner le projet

```bash
git clone https://github.com/LightningMax/kyrii.git
cd my-webapp
```

## Installer les dépendances

```bash
composer install
```

## Configurer l’environnement

-   Copier le fichier .env :

```bash
cp .env .env.local
```

## Modifier les variables importantes :

```bash
DATABASE_URL="mysql://db_user:db_password@127.0.0.1:3306/db_name"
MAILER_DSN=smtp://localhost
```

Créer la base de données et appliquer les migrations

```bash
php bin/console doctrine:database:create
php bin/console doctrine:migrations:migrate

```

## Démarrer le serveur Symfony

```bash
symfony server:start
```

L’application sera disponible sur : http://127.0.0.1:8000
