# Desafio Back-end PHP

![Workflow](https://github.com/zaclummys/desafio-backend/actions/workflows/laravel.yml/badge.svg)

Esta é uma aplicação para armazenamento e processamento de transações financeiras. Foi construída com **PHP** 7.4 e **Laravel** 7.3, completando todas 4 fases do desafio proposto pelo [Deixa no Azul](https://github.com/deixanoazul/desafio-backend). Pode experimentar a aplicação ao vivo aqui: [Desafio Backend PHP - Heroku](https://desafio-backend-deixa-no-azul.herokuapp.com).

## Instalação :turtle:

Para executar esse projeto, será necessário ter **PHP** 7.4 e **Composer** 2.0 instalado em sua máquina. Após isso, instale os pacotes necessários:

```bash
$ composer install
```

Para gerar uma chave para a aplicação:

```bash
$ php artisan key:generate
```

Para gerar uma chave JWT de autenticação:

```bash
$ php artisan jwt:secret
```

## Começar :running:

Para começar, execute as migrações para criar as tabelas e os índices no banco de dados:

```bash
$ php artisan migrate
```

Se achar conveniente, pode executar também o semeador para preencher as tabelas automaticamente:

```bash
$ php artisan db:seed
```

Para iniciar a aplicação, é só rodar a seguinte linha de comando:

```bash
$ php artisan serve
```

A aplicação será servida em [http://127.0.0.1:8000](http://127.0.0.1:8000/).

### Endpoints
Para acessar os endpoints da API, será necessário utilizar o cabeçalho `accept: application/json`. As rotas podem ser acessadas tanto por um usuário autenticado quanto por modo anônimo. Entretanto, as rotas de criação e remoção de entidades necessitam de autenticação e autorização.

| Método    | URI                               | Descrição                                                     | Campos
|-----------|-----------------------------------|---------------------------------------------------------------|------------------------
| POST      | /api/sign-in                      | Gera um novo token de acesso.                                 | `email` `password`
| POST      | /api/sign-out                     | Invalida o token de acesso atual.                             |
|           |                                   |                                                               |
| GET       | /api/users                        | Lista todos os usuários.                                      |
| POST      | /api/users                        | Cria um novo usuário.                                         | `name` `email` `cpf` `birthdate` `balance` `password`
|           |                                   |                                                               |
| GET       | /api/users/{user}                 | Exibe os dados do usuário especificado.                       |
| PATCH     | /api/users/{user}                 | Atualiza os dados do usuário especificado. :lock:             | `name` `balance` `password`
| DELETE    | /api/users/{user}                 | Destrói o usuário especificado. :lock:                        |
|           |                                   |                                                               |
| GET       | /api/users/{user}/transactions    | Lista todas as transações do usuário especificado.            |
| POST      | /api/users/{user}/transactions    | Cria uma nova transação para o usuário especificado. :lock:   | `amount` `type`
|           |                                   |                                                               |
| GET       | /api/users/{userId}/transacted    | Calcula o total transacionado pelo usuário especificado.      |
|           |                                   |                                                               |
| GET       | /api/transactions/{transaction}   | Exibe os dados da transação especificada.                     |
| DELETE    | /api/transactions/{transaction}   | Destrói a transação especificada. :lock:                      |


### Cache

A operação de calcular o total transacionado para cada usuário é uma operação custosa, pois analisa todo o histórico de transações do usuário. Por isso, o valor calculado é armazenado em cache para garantir a otimização dos recursos. Entretanto, não se preocupe, pois, toda a vez que o usuário criar ou deletar uma transação, o valor em cache será esquecido para que possa ser atualizado quando necessário.

## Testar 

### Testes de integração :bug:
Para executar os testes de integração, execute a seguinte linha de comando:

```bash
$ composer run test
```

### Cobertura :cake:
Para gerar o relatório de cobertura de testes, é necessário ter instalado na sua máquina a extensão [XDebug](https://xdebug.org/docs/install). Feito isso, execute a seguinte linha de comando:

```bash
$ composer run coverage
```

A aplicação tem 100% de cobertura de testes. :smiley:

## Autor :pencil2:

Isaac Luiz Vieira Ferreira <isaacluizvieiraferreira@id.uff.br>
