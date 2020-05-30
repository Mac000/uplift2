# uplift
 Uplift is a responsive web to assist volunteers for relief of Covid-19

# Instructions for Running Product
1. Install composer. You can donwload .exe from https://getcomposer.org/
OR
type ``composer global require laravel/installer`` in command line.
2. Once Composer is installed, Make sure to place Composer's system-wide vendor bin directory in your $PATH so the laravel executable can be located by your system.
3. Clone this repository.
4. Naviagate to the code folder and open up a command line. type ``composer install`` to install the dependencies.
5. type ``php artisan key:generate`` in command line to generate application key.
6. Next step is setting up DB and .env file.
7. Once you have MySql installed in your device, create a database and add the database  password, username, and database name in .env file.
8. type ``php artisan migrate`` to migrate the database.
9. If you want to follow my env file then you can use it by keeping the DB name, password and username same as env file or if you choose as you like, reflect them in .env file. This will save you from from configuring mail, queues and cron option in env.
10. If you choose to set your own env, then I recommend seeting up mailtrap and adding the mailtrap credentiaals into env file. Choose laravel from "Mailtrap integration" and copy paste the env variable into .env file.
11. Lastly, replace the ``QUEUE_CONNECTION`` with ``QUEUE_CONNECTION=database`` inside your env file.
type ``php artisan serve`` to run the project.
