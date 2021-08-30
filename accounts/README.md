# Account Service

Este projeto baseado em [Docker](https://www.docker.com/) e, por isso, é necessário o ter instalado para execução do ambiente.

A pasta `./bin` possui diversos scripts utilitários, para configuração, execução e manipulação do ambiente de desenvolvimento da aplicação.

Para configurar e acessar o projeto, execute:

## Configurando o projeto

```
./bin/config
```
Faz a cópia dos arquivos de configuração.

```
Obs: Inserir dados de conexão em .env.
```

### Executando containers
```
./bin/run
```
Inicia os containers Docker.

```
./bin/composer install
```
Instala as dependências da aplicação.

```
./bin/artisan key:generate
```
Cria a chave da aplicação.

```
./bin/artisan migrate:fresh --seed
```
Instala as migrações e seeders.

```
./bin/artisan test
```
Excuta os testes da aplicação

```
./bin/workspace
```
Entra no container da aplicação

```
./bin/mysql
```
Entra no container MySql da aplicação
