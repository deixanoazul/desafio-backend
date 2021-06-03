<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://github.com/deixanoazul/desafio-backend/raw/main/DNA.png" width="400"></a></p>


# Desafio Back-End - Deixa no Azul

## Content Table

* [Technologies](#technologies)
* [Features](#features)
* [Installation](#instalation)
* [QuickDocs](#docs)

<a name="technologies">**Technologies used**</a>
- PHP 
- Laravel
- MySQL


<a name="features">**Features**</a>
- Register user
- List users ordered by desc
- List a specific user
- Delete an user
- Associate an user with transaction
- Add opening amount to user and edit it
- Sum all user operations
- Don't allow to delete an user that have operations or cash
- Don't allow users under 21 years old to create an account
- Custom request validations
- Database seeders
- API Authentication with JWT

<a name="instalation">**Installation**</a><br>
- Clone the repository<br>
```
$ git clone https://github.com/felipebrsk/desafio-backend
```
- Switch to the repo folder<br>
```
$ cd Challenge
```
- Install all the dependencies using composer<br>
```
$ composer install
```
- Copy the example env file and make the required configuration changes in the .env file<br>
```
$ cp .env.example .env
```
- Generate a new application key<br>
```
$ php artisan key:generate
```
- Generate a new JWT key<br>
```
$ php artisan jwt:secret
```
- Run the database migrations (Set the database connection in .env before migrating)<br>
```
$ php artisan migrate
```
- Run the seeds migrations to see how it works with examples<br>
```
$ php artisan db:seed
```
Or use this code to fresh the database and run the migration with the seeds<br>
```
$ php artisan migrate:fresh --seed
```
- Start the local development server<br>
```
$ php artisan serve
```
You can call API routes in http://localhost:8000/v1/users
<br/>
<br/>

<a name="docs">**QuickDocs**</a>

- `POST` http://localhost:8000/v1/users - register users
- `GET` http://localhost:8000/v1/users - List users ordered by desc
- `GET` http://localhost:8000/v1/users/{id} - List a specific user by id
- `DELETE` http://localhost:8000/v1/users/{id} - Delete a specific user by id
- `PUT` http://localhost:8000/v1/users{id} - Change opening amount of an user

<br/>

- `GET` http://localhost:8000/v1/users/{id}/transactions - Get all associated transactions with the user
- `GET` http://localhost:8000/v1/users/{id}/transactions-with-infos - Get all paginated transactions associated to user with his informations 
- `GET` http://localhost:8000/v1/users/{id}/transactions-sum - Get the sum of all user operations
- `DELETE` http://localhost:8000/v1/users/{user_id}/transactions/{transaction_id} - Delete a specific transaction associated to user