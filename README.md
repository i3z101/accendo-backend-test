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
- This project implements docker & docker compose

# -----------------------
## Features
- Fast retreival.
- Validation methods for form fields.
- Once the student or teacher signed up/in they will grant a token

# -----------------------

## Installation

Install the dependencies and devDependencies and start the server.

Follow these steps one by one

### Make sure you already have installed php and laravel
```sh
git clone https://github.com/i3z101/accendo-backend-test.git
```
```sh
docker-compose up
```
```sh
docker exec teacher-app-php cp .env.example .env
docker exec teacher-app-php php artisan key:generate
docker exec student-app-php cp .env.example .env
docker exec student-app-php php artisan key:generate
```
#### Fill up the database information for both app
#### If you don't want to change anything just copy the db data from docker-compose file
#### If you changed the data from docker-compose update it here as well
```sh
DB_CONNECTION=mysql
DB_HOST=mysql[Do not change it]
DB_PORT=3306
DB_DATABASE=db-name
DB_USERNAME=db-user
DB_PASSWORD=db-password
```
```sh
docker exec teacher-app-php php artisan migrate
docker exec student-app-php php artisan migrate
```

### If failed after settings up every thing
```sh
docker-compose down
docker-compose up --build
```

# SOME NOTES:
##### 1- You will find some models are decoupled from each other. The separation came after analysis and found it better to split the models that relate to each projecr.
##### 2- You will find that many controllers and you may wonder why he did not combine it. Well, after the analysis it is better to separate the contorllers with its module. This will make the dealing with the database more easily and for controllers they will be maintainable, testable, and extendable in the future as well as will save developers time.
##### 3- for the synchronization schema between developement and production database, to be honest I failed to handle it and finding a related library ): I hope this will not effect my assessing
##### 4- If you use docker from windows, you will find that it is very slow, this is not my problem. It is windows operating system because with docker in windows we should use virtual machine.



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

