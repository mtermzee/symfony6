# Symfony 6

### for new install

```
composer upgrade
composer install
npm install -g npm@latest
npm install
php bin/console cache:clear
npm run build
```

### symfony server

```
symfony server:start -d
symfony server:stop
symfony server:start -d  --allow-http
php -S 127.0.0.1:8000 -t public
```

### run server

```
npm run watch
```

### after install to run and database

```
docker-compose up -d
docker-compose ps

symfony console make:migration

symfony console doctrine:database:drop --force
symfony console doctrine:database:create

symfony console doctrine:migrations:migrate
symfony console doctrine:fixtures:load

```
