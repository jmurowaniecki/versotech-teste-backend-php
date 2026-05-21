# Teste Técnico – Desenvolvedor PHP Laravel
![NGINX](https://img.shields.io/badge/NGINX-1.30.1-009933?label=NGINX%20size&logo=nginx&logoColor=009933&style=flat-square)
![NodeJS:26.1.0](https://img.shields.io/badge/NodeJS-26.1.0-6cc24a?size&logo=Node.JS&logoColor=6cc24a&style=flat-square)
![PHP 8.4](https://img.shields.io/badge/php-8.4.0-1B09AB?size&logo=php&logoColor=1B09AB&style=flat-square)
![Laravel 13](https://img.shields.io/badge/Laravel-13-FF2D20?size&logo=laravel&logoColor=FF2D20&style=flat-square)

A criação da estrutura base foi realizada utilizando as ferramentas [λ.cli](https://github.com/jmurowaniecki/lambda), [λ{ ᴳᴿᴼᵁᴺᴰ … }](https://github.com/jmurowaniecki/ground) e [Cornerstone](https://github.com/jmurowaniecki/cornerstone), disponibilizando infraestrutura em Docker Compose com facilitação de uso via `Makefile`.

```
λ add {makefile,ion.{compose.{nginx,php-fpm},editorconfig}}
```

A criação do projeto inicial foi realizada com a execução do comando `composer create-project laravel/laravel app` na raiz do projeto utilizando o container `composer`, via `make tty-composer`.

Foi adicionado para verificar os endpoints, um serviço do Swagger via `make run-composer require "darkaonline/l5-swagger"` e configurado via `make run-artisan vendor:publish --provider "L5Swagger\L5SwaggerServiceProvider"`.

Foram criadas migrations para as tabelas  `produtos_base` e `precos_base` com o seguinte comando:

```
for i in {produtos_base,precos_base}; \
do make run-artisan make:migration ${i}; \
done
```

## Primeiros passos

Para realizar a instalação e montagem dos containers execute o comando `make install` que é um alias para o comando `docker compose build --no-cache --pull`.


## Objetivo

Desenvolver uma aplicação backend responsável pelo processamento, transformação e sincronização de dados de produtos e preços, utilizando Views SQL para padronização das informações e disponibilizando os dados por meio de uma API REST.

---

## Requisitos Técnicos

Tecnologias obrigatórias:

* PHP 8.0+
* Laravel 11.0+
* SQLite
* Docker
* Docker Compose

---

## Restrições Obrigatórias

O projeto deve:

* Rodar integralmente via Docker.
* Possuir arquivo `docker-compose.yml`.
* Expor exclusivamente endpoints de API REST.
* Conter testes automatizados.
* Incluir instruções de execução no `README.md`.
* Documentar os endpoints disponíveis.

O projeto não deve:

* Exigir instalação de dependências na máquina host além do Docker.
* Conter qualquer tipo de interface web.

---

## Modelagem de Banco de Dados

### Tabelas de Origem

Devem ser criadas duas tabelas base:

* `produtos_base`
* `precos_base`

O script de criação das tabelas base encontra-se na raiz do projeto.

### Tabelas de Destino

Devem ser criadas duas tabelas para armazenamento dos dados processados:

* `produto_insercao`
* `preco_insercao`

Considere modelagem adequada, chaves e índices quando necessário.

---

## Processamento com Views SQL

A transformação dos dados deve ser realizada obrigatoriamente por meio de Views SQL.

Devem ser criadas:

* Uma View para produtos.
* Uma View para preços.

As Views devem contemplar:

* Normalização dos dados.
* Processamento apenas de registros ativos.

---

## Processo de Sincronização

A sincronização deve:

* Consumir os dados a partir das Views.
* Inserir, atualizar ou remover registros nas tabelas de destino.
* Evitar duplicidade.
* Evitar operações desnecessárias.

---

## API REST

A aplicação deve disponibilizar os seguintes endpoints:

### Sincronizar Produtos

POST /api/sincronizar/produtos

Executa o processo de transformação e sincronização dos dados de `produtos_base` para `produto_insercao`.

---

### Sincronizar Preços

POST /api/sincronizar/precos

Executa o processo de transformação e sincronização dos dados de `precos_base` para `preco_insercao`.

---

### Listar Produtos Sincronizados (Paginado)

GET /api/produtos-precos

Deve retornar os produtos processados com seus respectivos preços de forma paginada.
A paginação deve aceitar parâmetros de controle via query string.

---

## Como executar o projeto?

{Esta seção deve ser preenchida pelo candidato com as instruções necessárias para execução da aplicação.}
