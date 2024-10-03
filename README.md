## Set up

clone the project repo
composer install
cp .env.example .env

DB_DATABASE (your database name)
DB_USERNAME (your database username)
DB_PASSWORD (your database password)

php artisan key:generate

php artisan migrate --seed

php artisan serve

## Run Test cases

php artisan test

## About This project

Web Interface:
The application will be available at http://localhost:8000.

API Usage:
Access the API through http://localhost:8000/api.

POSTMAN TEST
Import Address_Book Environment.postman_environment.json and Address_Book.postman_collection.json

In postman select Address_Book Environment . after register and login put update token variable in Address_Book Environment

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

-   [Simple, fast routing engine](https://laravel.com/docs/routing).
-   [Powerful dependency injection container](https://laravel.com/docs/container).
-   Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
-   Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
-   Database agnostic [schema migrations](https://laravel.com/docs/migrations).
-   [Robust background job processing](https://laravel.com/docs/queues).
-   [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
