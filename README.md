<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

# Requirements 
The application is developed based on Laravel Framework. All the requirements of Laravel Framework needs to be fulfiled. N.B. composer needs to be installed on your machine to install the dependencies. 
[https://laravel.com/docs/8.x/deployment#server-requirements]



### Installation
1. Copy the downloaded file in your hostig. Then extract it 
2. copy the .env.example file to .env if .env file doesn't exist. 
   ```sh
   cp.env.example .env
   ```
3. Create database and database user credentials. The database user should have all the privileges.
4. Then in .env file setup the database credentials.
5. Now install the application dependencies using the following command:
   ```sh
   composer install --optimize-autoloader --no-dev
   ```
6. Generate Secret Key
   ```sh
   php artisan key:generate
   ```
 7. Link storage
    ```sh
    php artisan storage:link
    ```
 8. Run Database Migrations. By running the following command default admin user will be created.
   ```sh
   php artisan migrate --seed
   ```
 9. Default user credentials : admin@agroninomi.test / password
                                and client@agroninomi.test / password
  
  ALL DONE..............
