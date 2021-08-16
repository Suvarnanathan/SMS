1. Run git clone https://github.com/Suvarnanathan/SMS.git
2. Create a MySQL database for the project
    create database moh;
3. From the projects root run cp .env.example .env
4. Configure your .env file
5. Run composer update from the projects root folder
6. From the projects root folder run:
        php artisan vendor:publish --tag=laravelroles &&
        php artisan vendor:publish --tag=laravel2step
7. From the projects root folder run sudo chmod -R 755 ../moh
8. From the projects root folder run php artisan key:generate
9. From the projects root folder run php artisan migrate
10. From the projects root folder run composer dump-autoload
11. From the projects root folder run php artisan db:seed
