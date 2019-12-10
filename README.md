# Soda Inventory

  

## Descrição

Um projeto para fazer o gerenciamento de um estoque de refrigerantes. Por meio do qual, o funcionário poderá criar, editar, excluir e visualizar os refrigerantes cadastrados no estoque.

  

Obs: Não é possível criar um refrigerante que já exista no banco de dados, ex: Se existe uma Coca-Cola de 2 L, não poderá criar outra com o mesmo nome e litragem, o mesmo vale para a edição.

  
  

## Tecnologias Usadas

  

- PHP 7.3

- MongoDb

- Laravel

- Vue (Vuetify)

- Docker

  

## Instalação

  

Primeiro você precisa clonar esse repositório:

  

> git clone https://github.com/tobiasaires/sodaInventory

E depois

> cd sodaInventory && ./docker-run.sh

 Ao subir os containers os **testes** serão realizados.

Caso deseje pode rodar com o comando: 

> docker-compose exec app sh -c "./vendor/phpunit/phpunit/phpunit tests/Feature/SodaTest.php"
  

A api estará rodando na porta 80, já o Vue.js na porta 8080

Basta acessar:
> [http://localhost:8080/](http://localhost:8080/)

## Obs: 
Caso o botão de editar não esteja funcionando ao criar um Refrigerante, basta atualizar a página.
  

## Documentação

  

Todos os retornos da Api são no formato de JSON.

### Obs:

Todos os campos são obrigatórios.

  

### Criar Refrigerante

+ POST /api/soda/create

### Body

```json

{

"brand":  "String",

"measureUnit":  "String",

"measureValue":  "String | Integer",

"type":  "String",

"quantity":  "String | Integer",

"unitPrice":  "String"

}

```

### Response

```json

"status": "success",

"message": "Refrigerante criado com sucesso",

```

  

### Atualizar Refrigerante

+ PUT /api/soda/update/{id}

### Body

```json

{

"brand":  "String",

"measureUnit":  "String",

"measureValue":  "String | Integer",

"type":  "String",

"quantity":  "String | Integer",

"unitPrice":  "String"

}

```

### Response

```json

"status": "success",

"message": "Refrigerante atualizado com sucesso",

"data": {

"brand":  "String",

"measureUnit":  "String",

"measureValue":  "String | Integer",

"type":  "String",

"quantity":  "String | Integer",

"unitPrice":  "String"

}

```

  

### Deletar Refrigerante

+ DELETE /api/soda/{id}/DELETE

### Response

```json

"status": "success",

"message": "Refrigerante excluído com sucesso",

```

  

### Listar Todos os Refrigerantes

+ GET /api/soda/

### Response

```json

[{

"brand":  "String",

"measureUnit":  "String",

"measureValue":  "String | Integer",

"type":  "String",

"quantity":  "String | Integer",

"unitPrice":  "String"

}]

```

  

### Listar Um Refrigerante Refrigerantes

+ GET /api/soda/{id}

### Response

```json

[{

"brand":  "String",

"measureUnit":  "String",

"measureValue":  "String | Integer",

"type":  "String",

"quantity":  "String | Integer",

"unitPrice":  "String"

}]

```

  

### Errors

  

Em casos de erros na api o status code será 422 ou 400.

400 -> Erros de validação

422 -> Erro de tentar criar ou atualizar um refrigerante para um que já existe no banco

  

### 400

```json

"sucess": false,

"http_code": 400,

"message": "The given data was invalid.",

"errors": {

...

}

```

  

### 422

```json

"status": false,

"message": "Já existe um refrigerante com esses dados",

```

  

### Melhorias

+ Adicionar autenticação JWT

+ Melhorias de UI/UX

+ Melhorias nos Formulários de Criação e Edição (Validação dos dados no frontend)

+ Adicionar Tela de Login
