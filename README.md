## About Project

Store control is a api for products control

## Mental map
 
- **[ http://www.xmind.net/m/5SBsgD]( http://www.xmind.net/m/5SBsgD)** 

## Tools
 
- **[Tests with phpunit](https://phpunit.de/)** 
- **[php codesniffer](https://github.com/squizlabs/PHP_CodeSniffer)** 
- **[Laravel Framework](https://laravel.com/)** 

## Config Project

You need to configure the .env file steps

- 1 create config email dispatch when new product is created and updated, add MAIL_FROM_ADDRESS to your .env with an email valid
- 2 config MAIL_USERNAME and MAIL_PASSWORD to send email (I used **[https://mailtrap.io/inboxes](https://mailtrap.io/inboxes)**)
- 3 config your database in .env

## Run Project

- composer update 
- php artisan migrate
- php artisan key:generate
- php artisan config:clear
- php artisan serve

## Run Tests

- php artisan test

## Endpoints

#### Store

- GET    | api/v1/stores
- POST   | api/v1/stores
- GET    | api/v1/stores/{store}
- PUT    | api/v1/stores/{store}
- DELETE | api/v1/stores/{store}

#### Product

- GET    | api/v1/products
- POST   | api/v1/products
- GET    | api/v1/products/{store}
- PUT    | api/v1/products/{store}
- DELETE | api/v1/products/{store}

## Todos

- Helper reponse
- Product and Store with data resources
