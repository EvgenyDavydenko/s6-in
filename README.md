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
