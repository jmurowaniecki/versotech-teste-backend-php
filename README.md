# Teste Técnico – Desenvolvedor PHP Laravel
![NGINX](https://img.shields.io/badge/NGINX-1.30.1-009933?label=NGINX%20size&logo=nginx&logoColor=009933&style=flat-square)
![NodeJS:26.1.0](https://img.shields.io/badge/NodeJS-26.1.0-6cc24a?size&logo=Node.JS&logoColor=6cc24a&style=flat-square)
![PHP 8.4](https://img.shields.io/badge/php-8.4.0-1B09AB?size&logo=php&logoColor=1B09AB&style=flat-square)
![Laravel 13](https://img.shields.io/badge/Laravel-13-FF2D20?size&logo=laravel&logoColor=FF2D20&style=flat-square)

Aplicação backend responsável pelo processamento, transformação e sincronização de dados de produtos e preços, utilizando Views SQL para padronização das informações e disponibilizando os dados por meio de uma API REST.


## Primeiros passos

Para realizar a instalação e montagem dos containers execute o comando `make install` que é um alias para o comando `docker compose build --no-cache --pull`.


## Passo a passo da estrutura

A criação da estrutura base foi realizada utilizando as ferramentas [λ.cli](https://github.com/jmurowaniecki/lambda), [λ{ ᴳᴿᴼᵁᴺᴰ … }](https://github.com/jmurowaniecki/ground) e [Cornerstone](https://github.com/jmurowaniecki/cornerstone), disponibilizando infraestrutura em Docker Compose com facilitação de uso via `Makefile`.

```sh
λ add {makefile,ion.{compose.{nginx,php-fpm},editorconfig}}
```

A instalação e configuração dos requisitos pode ser feita manualmente, adicionando os containers presentes no diretório de serviço `./.../docker` no `docker-compose.yaml`, realizando o download e configuração respectivamente do Composer e Laravel, atendendo os requisitos tecnológicos obrigatórios:

Tecnologia     |      Versão
---------------|:----------------:
PHP 8.0+       | _8.4 FPM Alpine_
Laravel 11.0+  | _13_
SQLite         | _3_
Docker         | _29.4.1_
Docker Compose | _v5.1.3_

A criação do projeto inicial foi realizada com a execução do comando `composer create-project laravel/laravel app` na raiz do projeto utilizando o container `composer`, via `make tty-composer`.

Foi adicionado para verificar os endpoints, um serviço do Swagger via `make run-composer require "darkaonline/l5-swagger"` e configurado via `make run-artisan vendor:publish --provider "L5Swagger\L5SwaggerServiceProvider"`.

Foram criadas migrations para as tabelas  `produtos_base` e `precos_base` com o seguinte comando:

```sh
for table in {produtos_base,precos_base,produto_insercao,preco_insercao,produtos_view,precos_view}; \
do make run-artisan make:migration ${table}; \
done
```

## Modelagem e Processamento de Banco de Dados

- Modelagem das tabelas base e destino
- Processamento via Views SQL
- Normalização de dados
- Persistência de registros ativos

```sh
for action in {migrate,db:seed}; \
do make run-artisan ${action}; \
done
```

Com as tabelas de origem e destino criadas, foi implemenatdo normalização dos dados nas migrations das respecivas views.

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
