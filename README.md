# ACCENDO BACKEND TEST
# -----------------------
## Brief description:
- This projetc was built using laravel faramework
- This project uses mysql as the database
- This project only restful api
- This project implements json web token to secure the api
- This project implements MVC pattern
- This project implements a middleware called authorization to check the authority of the user
- This repository contains the database ERD
- This repository contains the required collection of postman
- This project implements docker & docker compose.

# -----------------------
## Features
- Fast retreival.
- Validation methods for form fields.
- Once the student or teacher signed up/in they will grant a token

# -----------------------

## Installation

Install the dependencies and devDependencies and start the server.

Follow these steps one by one
## Option 1 with docker
### Make sure you already have installed php and laravel
```sh
git clone https://github.com/i3z101/accendo-backend-test.git
```
```sh
docker-compose up
```
```sh
docker exec teacher-app-composer install
```
```sh
docker exec teacher-app-php cp .env.example .env
```
```sh
docker exec teacher-app-php php artisan key:generate
```
```sh
docker exec student-app-php composer install
```
```sh
docker exec student-app-php cp .env.example .env
```
```sh
docker exec student-app-php php artisan key:generate
```
#### Fill up the database information in .env for both app
#### If you don't want to change anything just copy the db data from docker-compose file
#### If you changed the data from docker-compose update it here as well
```sh
DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=db-name
DB_USERNAME=db-user
DB_PASSWORD=db-password
```
```sh
docker exec teacher-app-php php artisan migrate
```
```sh
docker exec student-app-php php artisan migrate
```
### If you want to seed the teachers and students
```sh
docker exec teacher-app-php php artisan db:seed
```
```sh
docker exec student-app-php php artisan db:seed
```

### If faild after settings up every thing
```sh
docker-compose down
```
```sh
docker-compose up --build
```

## Option 2 withou docker
### afetr clone
```sh
cd teacher-app
composer install
cp .env.example .env
php artisan key:generate
php artisan serve
```
```sh
cd student-app
composer install
cp .env.example .env
php artisan key:generate
php artisan serve --port=5000
```

```sh
DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=db-name
DB_USERNAME=db-user
DB_PASSWORD=db-password
```

### If you want to seed the teachers and students
```sh
php artisan db:seed
```
```sh
php artisan db:seed
```

## YOU CAN TEST THE APIS:
## teacher-app: localhost:8000 / 127.0.0.1:8000
## student-app: localhost:5000 / 127.0.0.1:5000

# -----------------------

# SOME NOTES:
##### 1- You will find a route in post man called view-all-courses-by-admin & add-new-course-by-admin. These two just for ensuring data is saved in the database. This should have also a secured api but I did not do that because I want it for testing purposes ONLY.
##### 2- You will find some models are decoupled from each other. The separation came after analysis and found it better to split the models that relate to each projecr.
##### 3- You will find that many controllers and you may wonder why he did not combine it. Well, after the analysis it is better to separate the contorllers with its module. This will make the dealing with the database more easily and for controllers they will be maintainable, testable, and extendable in the future as well as will save developers time.
##### 4- for the synchronization schema between developement and production database, to be honest I failed to handle it and finding a related library ): I hope this will not effect my assessing
##### 5- If you use docker from windows, you will find that it is very slow, this is not my problem. It is windows operating system because with docker in windows we should use virtual machine.



## Plugins

This project is currently extended with the following plugins.

| Plugin | DESCRIPTION |
| ------ | ------ |
| adhocore/jwt | For generating api token and secure it |


## You can follow me there:
- [Linked in](https://www.linkedin.com/in/abdulaziz-baqaleb-1b7752203/)
- [Twitter](https://twitter.com/i_3z1001)
- [My portofoli](https://aziz-portofolio.vercel.app)
#### As well as my github page

