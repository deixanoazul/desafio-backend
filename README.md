# Desafio Back-end PHP

Esta é uma aplicação para armazenamento e processamento de transações financeiras. Foi construída utilizando **PHP** 7.4 e **Laravel** 7.3 para o desafio proposto pelo [Deixa no Azul](https://github.com/deixanoazul/desafio-backend).

## Instalação :turtle:

Para executar esse projeto, será necessário ter **PHP** 7.4 e **Composer** 2.0 instalado em sua máquina. Feito isso, instale os pacotes necessários:

```bash
$ composer install
```

Uma chave JWT será gerada automaticamente quando a instalação for finalizada. Além disso, será configurado um base de dados SQLite para facilitar a utilização da aplicação.

## Começar :running:

Para iniciar a aplicação, execute a seguinte linha de comando:

```bash
$ php artisan serve
```

### Endpoints
Para acessar os endpoints da API, será necessário utilizar o cabeçalho `accept: application/json`. As rotas podem ser acessadas tanto por um usuário autenticado quanto por modo anônimo. Entretanto, as rotas de criação e removação de entidades necessitam de autenticação e autorização.

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

A operação de calcular o total transacionado para cada usuário é uma operação custosa, pois analisa todo o histórico de transações do usuário. Por isso, o valor calculado é armazenado em cache para garantir a otimização dos recursos. Mas não se preocupe, pois toda vez que o usuário criar ou deletar uma transação, o valor em cache será esquecido e para que possa ser atualizado quando necessário.

## Testar :beetle:

### Testes de integração
Para executar os testes de integração, execute a seguinte linha de comando:

```bash
$ composer run test
```

### Cobertura
Para gerar o relatório de cobertura de testes, é necessário ter instalado em sua máquina a extensão [XDebug](https://xdebug.org/docs/install). Feito isso, execute a seguinte linha de comando:

```bash
$ composer run coverage
```

A aplicação tem 100% de cobertura de testes. :smiley:

## Autor

Isaac Luiz Vieira Ferreira <isaacluizvieiraferreira@id.uff.br>
