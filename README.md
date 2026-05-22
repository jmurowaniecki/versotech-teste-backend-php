# Teste Técnico – Desenvolvedor PHP Laravel
![NGINX](https://img.shields.io/badge/NGINX-1.30.1-009933?logo=nginx&logoColor=009933&style=flat-square)
![NodeJS:26.1.0](https://img.shields.io/badge/NodeJS-26.1.0-6cc24a?size&logo=Node.JS&logoColor=6cc24a&style=flat-square)
![PHP 8.4](https://img.shields.io/badge/php-8.4.0-1B09AB?size&logo=php&logoColor=1B09AB&style=flat-square)
![Laravel 13](https://img.shields.io/badge/Laravel-13-FF2D20?size&logo=laravel&logoColor=FF2D20&style=flat-square)

Aplicação backend responsável pelo processamento, transformação e sincronização de dados de produtos e preços, utilizando Views SQL para padronização das informações e disponibilizando os dados por meio de uma API REST.


## Primeiros passos utilizando apenas Docker Compose:

#### **Passo 1** - Para realizar a instalação e montagem dos containers execute o seguinte comando:
```sh
docker compose build --no-cache --pull
```

#### **Passo 2** - Para execução das migrations para criação das tabelas você deve executar o comando:
```sh
docker compose run -it --rm artisan migrate
```

#### **Passo 3** - Para execução do seeder carga inicial de dados você deve executar o comando:
```sh
docker compose run -it --rm artisan db:seed
```

#### **Passo 4** - Inicialize a aplicação web com o seguinte comando:
```sh
docker compose up
```

#### **Passo 5** - Realize requisições nos endpoints desejados.


<br>


## Primeiros passos utilizando `Make`

#### **Passo 1** - Para realizar a instalação e montagem dos containers execute o comando `make install` que é um alias para os comandos de `build` e `fresh`

#### **Passo 2** - Para execução dos serviços execute o comando `make start`

#### **Passo 3** - Realize requisições nos endpoints desejados.


<br>


## Resumo

Note que os seguintes serviços serão iniciados: `proxy` e `php`.

Serviço |   Imagem    | Descrição
--------|:-----------:|---
proxy   | **Nginx**   | Proxy e load balancer da aplicação.<br/><small>Ele é responsável pela interface de comunicação entre o serviço PHP-FPM e as requisições. Ele quem mantém aberta a porta 80 e processa a carga, possibilitando isolamento do serviço do resto da rede.</small>
php     | **PHP_FPM** | Aplicação Laravel.<br/><small>Ela quem realiza o processamento das requisições, realizando a sincronização dos dados e a disponibilização dos mesmos.</small>



<br>


## Acessando os Endpoints

### Requisição de Token de sessão válido

Para adquirir um token de sessão válido execute:
```sh
curl -X 'GET' 'http://localhost/api/csrf_token' \
    -H 'Accept: application/json' \
    -c cookies.txt 
```

Você estará criando um arquivo `cookies.txt` contendo os dados de sessão, e também receberá um resultado similar a:
```json
{"token":"lQF6fDRWLzcUVyn7qzMhDH92sQ9CtlmAOEfx7ApB"}
```

Agora basta você utilizar utilizar o token obtido, em conjunto do arquivo `cookies.txt` para realizar suas demais requisições:



### Requisição de Produtos

```sh
curl -X 'POST' 'http://localhost/api/sincronizar/produtos' \
  -H 'Accept: application/json' \
  -b cookies.txt \
  -H 'X-CSRF-TOKEN: lQF6fDRWLzcUVyn7qzMhDH92sQ9CtlmAOEfx7ApB'
```
> Resultando em:
> ```json
> {"message":"Produtos sincronizados com sucesso"}
> ```



### Requisição de Preços

```sh
curl -X 'POST' 'http://localhost/api/sincronizar/precos' \
  -H 'Accept: application/json' \
  -b cookies.txt \
  -H 'X-CSRF-TOKEN: lQF6fDRWLzcUVyn7qzMhDH92sQ9CtlmAOEfx7ApB'
```
> Resultando em:
> ```json
> {"message":"Pre\u00e7os sincronizados com sucesso"}
> ```



### Requisição de Produtos Sincronizados

```sh
curl -X 'GET' 'http://localhost/api/produtos-precos' \
  -H 'Accept: application/json' \
  -b cookies.txt \
  -H 'X-CSRF-TOKEN: lQF6fDRWLzcUVyn7qzMhDH92sQ9CtlmAOEfx7ApB'
```
> Resultando em um JSON similar a:
> ```json
> {"current_page":1,"data":[{"prod_ins_id":1,"prod_cod":"PRD001","prod_nome":"Teclado  Mec\u00e2nico   RGB","prod_categoria":"PERIFERICOS","prod_subcategoria":"TECLADOS","prod_descricao":"Teclado com ilumina\u00e7\u00e3o RGB e switches azuis","prod_fabricante":"HyperTech","prod_modelo":"HT-KEY-RGB","prod_cor":"PRETO","prod_peso":1200,"prod_largura":45,"prod_altura":5,"prod_profundidade":15,"prod_unidade":"un","prod_ativo":1,"prod_data_cadastro":"2025-10-10","prod_data_processamento":"2026-05-22 00:00:41","prod_hash_origem":"efa654e592bea20f23d7e299768ac2de","prod_observacao":null,"precos":[{"preco_ins_id":1,"prod_cod":"PRD001","preco_valor":499.9,"preco_moeda":"BRL","preco_desconto_percentual":5,"preco_acrescimo_percentual":0,"preco_promocional":474.9,"preco_data_inicio_promocao":null,"preco_data_fim_promocao":null,"preco_data_atualizacao":"2026-05-22","preco_origem":"SISTEMA ERP","preco_tipo_cliente":"VAREJO","preco_vendedor_responsavel":"MARCOS SILVA","preco_observacao":"Produto em destaque","preco_status":"ativo","preco_data_processamento":"2026-05-22 00:00:41","preco_hash_origem":"648d19085e8999a528b58e9519bedec4"}]}, …]}],"first_page_url":"http:\/\/localhost\/api\/produtos-precos?page=1","from":1,"last_page":1,"last_page_url":"http:\/\/localhost\/api\/produtos-precos?page=1","links":[{"url":null,"label":"&laquo; Previous","page":null,"active":false},{"url":"http:\/\/localhost\/api\/produtos-precos?page=1","label":"1","page":1,"active":true},{"url":null,"label":"Next &raquo;","page":null,"active":false}],"next_page_url":null,"path":"http:\/\/localhost\/api\/produtos-precos","per_page":15,"prev_page_url":null,"to":10,"total":10}
> ```




### Inicializando a aplicação via console

Apesar da aplicação já responder a comandos no terminal como `make sync` - para realizar sincronização através do Artisan -, para inicializar a interface web e expor os endpoints/API será necessário subir os serviços via Docker.


<br>


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


<br>


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

A sincronização deve, consumir os dados a partir das views, inserirndo, atualizando ou removendo registros nas tabelas de destino, evitando duplicidade e operações desnecessárias. Para isso foi criado o comando Artisan `sync`:

```Makefile
Description:
  Sincroniza produtos da view normalizada preços, produtos ou ambos.

Usage:
  sync <type>

Arguments:
  type                  ambos|precos|produtos
```

## Execução de testes

Os testes podem ser executados diretamente no container, via artisan, através do comando:
```sh
docker compose run --rm artisan test 
```

Ou apenas utilizando o comando `make run-artisan test` no console.

Ambos comandos apresentaram um resultado similar ao informado abaixo:

```txt
   PASS  Tests\Unit\ExampleTest
  ✓ that true is true                                                   0.01s

   PASS  Tests\Feature\ExampleTest
  ✓ the application returns a successful response                       0.16s

   PASS  Tests\Feature\VwPrecoNormalizadoTest
  ✓ parses and normalizes price and fields                              0.11s
  ✓ sem preco as null                                                   0.01s

   PASS  Tests\Feature\VwProdutoNormalizadoTest
  ✓ normalizes and converts fields                                      0.01s
  ✓ ignores inactive products                                           0.01s

  Tests:    6 passed (19 assertions)
  Duration: 0.44s
```
