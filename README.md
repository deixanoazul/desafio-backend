![Logo Deixa no Azul](https://github.com/deixanoazul/desafio-backend/blob/main/DNA.png "Deixa no Azul")

# Desafio Back-End - Deixa no Azul

## Pré requisitos

- Lógica de programação;
- Conhecimentos sobre Banco de dados;
- Conhecimentos sobre HTTP, API's eREST ;
- Conhecimentos sobre Git;

## Requisitos do desafio

- Utilizar PHP, caso se sinta confortável, utilize o Láravel
- O código deve seguir o padrão PSR4;
- Adicionar no README instruções de como executar o projeto.
- A API deve receber e retornar dados no formato JSON.

## Diferenciais

- Utilizar o Láravel (7.4)
- Implementar método de autenticação
- Código limpo


### Fase 1 - Usuários
Nessa etapa daremos algumas premissas que devem ser seguidas.

- Criar um endpoint onde é cadastrado um usuário.
  - Esses usuários devem ter obrigátoriamente os seguintes dados modelados, caso você ache necessário outros campos fique a vontade.
    - **name** | string (Nome)
    - **email** | string (E-mail)
    - **birthday** | date (Data de aniversário)
    - **cpf** | string
    - **created_at** | datetime (Criado Em)
    - **updated_at** | datetime (Atualizado Em)
- Criar um endpoint para listagem desses usuários, ordernados por ordem de cadastro decrescente (mais novo para mais antigo);
- Criar um endpoint para listar um único usuário através do seu id;
- Criar um endpoint para excluir um usuário através do seu id.

### Fase 2 - Transação
Nessa etapa você precisará criar a modelagem e lógica para implementar as funcionalidades abaixo:

- Criar um endpoint ou endpoints onde é possível associar uma operação de débito, crédito ou estorno para o usuário;
- Criar um endpoint onde seja possível visualizar todas as transações (páginada) do usuários mais as suas informações pessoais;
- Criar um endpoint onde seja possível excluir uma movimentação relacionada a um usuário;


### Fase 3 - Nova Funcionalidades
Nessa etapa serão itens onde veremos como você pensou e como chegou ao resultado final.

- Adicionar dentro do usuário um campo para saldo inicial, e criar um endpoint para alterar esse valor;
- Criar um endpoint com a soma de todas as transações (débito, crédito e estorno);
- No endpoint que exclui um usuário, adicionar a funcionalidade que agora não será mais possível excluir um usuário que tenha qualquer tipo de transação associada ou saldo;
- No endpoint que cadastra usuário, adicionar a funcionalidade que apenas maiores de 21 anos podem criar uma conta;

### Fase 4 -Itens Não Obrigatórios
- Criar validações com base na Request;
- Implementar ao menos uma camada entre o controller e o model
- Utilizar cache para otimizar as consultas e buscas;
- Criar Seeders ou Inicializadores de dados para o usuários e suas Transações;
- Criar os métodos baseados em algum método de autênticação.
- Documentação dos endpoints;
