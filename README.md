# TineVox

Este projeto é uma interface web desenvolvida para facilitar o gerenciamento e a visualização de informações de um ambiente Asterisk. A ideia central é transformar dados e eventos do Asterisk em uma experiência mais amigável, permitindo acompanhar ramais, gravações, logs e outras funcionalidades por meio de uma interface moderna e intuitiva.

## Objetivo do projeto

O objetivo deste trabalho é criar uma interface web para o Asterisk, oferecendo uma forma simples e visual de monitorar e operar o sistema. Com isso, é possível acessar informações importantes de forma organizada, sem depender apenas de linhas de comando ou ferramentas mais técnicas.

## O que o sistema faz

- Exibe informações de ramais e status.
- Permite visualizar gravações de chamadas.
- Apresenta logs e eventos do sistema.
- Oferece uma interface web mais limpa e amigável para o gerenciamento do ambiente.

## Requisitos

Este projeto depende da API do TineVox para funcionar corretamente. Sem a API do TineVox, a aplicação não terá acesso aos dados e funcionalidades esperadas.

## Configuração

### 1. Instale as dependências do PHP

No diretório do projeto, execute:

```bash
composer install
```

### 2. Instale as dependências do frontend

```bash
npm install
```

### 3. Configure o ambiente

Copie o arquivo de exemplo de variáveis de ambiente:

```bash
cp .env.example .env
```

Edite o arquivo `.env` e ajuste as configurações do banco de dados, URL da aplicação e demais parâmetros necessários.

### 4. Gere a chave da aplicação

```bash
php artisan key:generate
```

### 5. Execute as migrations

```bash
php artisan migrate
```

### 6. Inicie a aplicação

```bash
php artisan serve
```

## Observações importantes

- A aplicação foi desenvolvida para trabalhar em conjunto com a API do TineVox.
- O sistema não funciona de forma completa sem essa integração.
- Para ambiente de desenvolvimento, é importante garantir que a API esteja disponível e configurada corretamente.

## Tecnologias utilizadas

- Laravel
- PHP
- Bootstrap
- JavaScript
- CSS personalizado

## Licença

Este projeto é de uso acadêmico e de desenvolvimento pessoal, com foco em demonstrar a criação de uma interface web para integração com o ambiente Asterisk via TineVox.
