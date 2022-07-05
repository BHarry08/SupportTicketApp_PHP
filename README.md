<p align="center">Support Ticket Application</p>



## Server Requirements



- Requiremtns : 
- PHP >= 7.2.5
- BCMath PHP Extension
- Ctype PHP Extension
- Fileinfo PHP Extension
- JSON PHP Extension
- Mbstring PHP Extension
- OpenSSL PHP Extension
- PDO PHP Extension
- Tokenizer PHP Extension
- XML PHP Extension
- Composer 2.0
- mysql  Ver 8.0.27

## Installation steps

- fire - composer install
- create .env file using .env.example and set the database host, username & password
- go to project root folder and fire - php artisan migrate
- go to project root folder and fire - php artisan db:seed (Will create some users and agents, all users & password is "password"")
- fire "sudo chmod -R 777 /storage" & ""sudo chmod -R 777 /bootstrap/cache""
- serve the application, fire - php artisan serve
- you can create new users or also you can use users created by seeders
- agents are already created using seeder, Please check database.
- for emails. currently, i have set driver as log so once event triggered after user registration, it will go to laravel.log file
- all already created users password is "password"
