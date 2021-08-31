# Kafka Service

Este projeto baseado em [Docker](https://www.docker.com/) e, por isso, é necessário o ter instalado para execução do ambiente.

A pasta `./bin` possui diversos scripts utilitários, para configuração, execução e manipulação do ambiente de desenvolvimento da aplicação.

Para configurar e acessar o projeto, execute:

### Executando containers
```
./bin/run
```
Inicia os containers Docker.

### Criando Tópicos
```
./bin/create-topic users
```
Cria tópico de Usuários.

```
./bin/create-topic accounts
```
Cria tópico de Contas.

```
./bin/create-topic transaction
```
Cria tópico de Transações.
