# TODO app

## Install
#### Pre requirements
Create local database ```todo-app```
```
composer install
php artisan migrate
```
### Test data
#### Pre requirements
Create local database ```test-todo-app```
```
php artisan db:seed
```
### Run tests
```
php artisan test
```

## API documentation
```
api/documentation
```
Generate document
```
php artisan l5-swagger:generate
```
