<p align="center"><img src="https://laravel.com/assets/img/components/logo-laravel.svg"></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/d/total.svg" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/v/stable.svg" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/license.svg" alt="License"></a>
</p>

## LOAN API 
This LOAN-API is build in laravel 5.5.*
This API uses JWT-AUTH and LARATRUST 

Clone the git repository from this link https link:  https://github.com/Pa6/loan-api.git

Step 1: Install composer if you dont have then update laravel dependency by typing: composer update command
After create .env (copy .env.example then remove .example) put database credentials accordingly 
Step 2: Generate Application key: php artisan key:generate
Step 3: Migrate Database: php artisan migrate
Step 4: Make Seed : php artisan db:seed (Loan type seeder, Payment type seeder, Interest type seeder)


Run on computer: start mysql and apache/nginx (any other..) 
Open terminal and go in the directory of the project type: php artisan serve ( it will open on 8000 if you want on other port type php artisan serve —port=****)
Deploy on server: Follow documentation on https://laravel.com/docs/5.5



## Laravel
 [laravel](https://laravel.com) 

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
