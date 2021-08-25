## A Laravel API

Acess the API Doc in the Postman 
[here](https://www.getpostman.com/collections/999d5a237c9b1aff39d5).

## Requirements

As it is build on the Laravel framework, it has a few system requirements.

- PHP >= 7.3
- MySql >= 5.7
- Composer
- OpenSSL PHP Extension
- PDO PHP Extension
- Mbstring PHP Extension
- Tokenizer PHP Extension
- XML PHP Extension
- Ctype PHP Extension
- JSON PHP Extension
- BCMath PHP Extension

You can check all the laravel related dependecies 
[here](https://laravel.com/docs/8.x/deployment#server-requirements)

## Running the API
Clone the repository and setup

`λ git clone https://github.com/devEzequiel/desafio-backend.git` <br>
`λ cd desafio-backend/challenge`

Then, create the database and add them to the `.env` file.

```
DB_DATABASE=your_db_name
DB_USERNAME=your_db_user
DB_PASSWORD=your_password
```

Then install, migrate, seed, all that jazz:

1. `λ composer install`
2. `λ php artisan migrate:fresh --seed`
3. `λ php artisan key:generate`
4. `λ php artisan serve`

The API will be running on `localhost:8000`

Login with user below if you do not want to create a new user and you want to access the 
protected routes.

```javascript
{
    'email': teste@dna.com,
    'password': 1234abcd
}
```

## API Endpoints and Routes
Laravel follows the Model View Controller (MVC) pattern I have created models associated with
each resource. You can check in the **routes/api.php** file for all the routes that map to 
controllers in order to send out JSON data that make requests to our API. Access this collection
in Postman [here](https://www.getpostman.com/collections/999d5a237c9b1aff39d5) to have access to all documented and exemplified endpoints.


```
+--------+----------+----------------------------------+------------------------------+-----------------------------------------------------------------------------+---------
---------------------------------+
| Domain | Method   | URI                              | Name                         | Action                                                                      | Middlewa
re                               |
+--------+----------+----------------------------------+------------------------------+-----------------------------------------------------------------------------+---------
---------------------------------+
|        | GET|HEAD | /                                |                              | Closure                                                                     | web
|
|        | POST     | api/auth                         | auth.login                   | App\Http\Controllers\Api\AuthController@postAuth                            | api
|
|        | POST     | api/transactions                 | transactions.post            | App\Http\Controllers\Api\Transactions\TransactionController@postTransaction | api
|
|        |          |                                  |                              |                                                                             | App\Http
\Middleware\Authenticate:sanctum |
|        | GET|HEAD | api/transactions                 | transactions.get             | App\Http\Controllers\Api\Transactions\TransactionController@getTransactions | api
|
|        |          |                                  |                              |                                                                             | App\Http
\Middleware\Authenticate:sanctum |
|        | DELETE   | api/transactions/{id}            | transactions.delete          | App\Http\Controllers\Api\Transactions\TransactionController@destroy         | api
|
|        |          |                                  |                              |                                                                             | App\Http
\Middleware\Authenticate:sanctum |
|        | POST     | api/transactions/{id}/chargeback | transactions.post_chargeback | App\Http\Controllers\Api\Transactions\TransactionController@postChargeBack  | api
|
|        |          |                                  |                              |                                                                             | App\Http
\Middleware\Authenticate:sanctum |
|        | POST     | api/users                        | users.create                 | App\Http\Controllers\Api\UserController@store                               | api
|
|        | GET|HEAD | api/users                        | users.list                   | App\Http\Controllers\Api\UserController@index                               | api
|
|        |          |                                  |                              |                                                                             | App\Http
\Middleware\Authenticate:sanctum |
|        | DELETE   | api/users/delete-account         | users.delete                 | App\Http\Controllers\Api\UserController@destroy                             | api
|
|        |          |                                  |                              |                                                                             | App\Http
\Middleware\Authenticate:sanctum |
|        | GET|HEAD | api/users/{id}                   | users.show                   | App\Http\Controllers\Api\UserController@show                                | api
|
|        |          |                                  |                              |                                                                             | App\Http
\Middleware\Authenticate:sanctum |
|        | PUT      | api/users/{id}                   | users.update                 | App\Http\Controllers\Api\UserController@update                              | api
|
|        |          |                                  |                              |                                                                             | App\Http
\Middleware\Authenticate:sanctum |
|        | GET|HEAD | sanctum/csrf-cookie              |                              | Laravel\Sanctum\Http\Controllers\CsrfCookieController@show                  | web
|
+--------+----------+----------------------------------+------------------------------+-----------------------------------------------------------------------------+---------
---------------------------------+
```

## Authorization

Some routes are protected by sanctum middleware. 
To have access, login and use the **Bearer Token** that will be returned in the json response.
