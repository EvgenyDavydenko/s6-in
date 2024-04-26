### кнонируем репозиторий
```
git clone https://github.com/EvgenyDavydenko/s6-in
```
### Запустить контейнер
```
cd s6-in
docker compose up -d
docker exec symfony-php82cli-bookworm symfony console doctrine:migrations:migrate
docker exec symfony-php82cli-bookworm symfony console doctrine:fixtures:load --no-interaction
docker exec symfony-php82cli-bookworm symfony server:start
```
### имтортировать коллекцию постмэн
---

1.  Creating Symfony Applications
```
composer create-project symfony/skeleton:"6.4.*" ./
symfony server:start
```
2.  Installation Doctrine ORM packages and make entiities
```
composer require orm
composer require --dev maker-bundle
```
Modification of environment variables
Сгенерить сущности без связей, после создания сущностей добавить связи
```
symfony console make:entity Book\Author\Publisher
symfony console make:migration
symfony console doctrine:migrations:migrate
```
3.  Creation of a dataset
```
composer require --dev orm-fixtures zenstruck/foundry
symfony console make:factory
symfony console doctrine:fixtures:load
```
4.  Creation of the api controller
```
composer require serializer
symfony console make:controller --no-template BookController\AuthorController\PublisherController
```
