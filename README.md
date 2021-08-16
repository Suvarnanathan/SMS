# SMS
Run git clone https://github.com/Suvarnanathan/moh_backend.git
Create a MySQL database for the project create database moh;
From the projects root run cp .env.example .env
Configure your .env file
Run composer update from the projects root folder
From the projects root folder run: php artisan vendor:publish --tag=laravelroles && php artisan vendor:publish --tag=laravel2step
From the projects root folder run sudo chmod -R 755 ../moh
From the projects root folder run php artisan key:generate
From the projects root folder run php artisan migrate
From the projects root folder run composer dump-autoload
From the projects root folder run php artisan db:seed
