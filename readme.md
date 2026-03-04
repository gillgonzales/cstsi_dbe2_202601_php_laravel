# Exemplos da Disciplina de Desenvolvimento Backend II - CSTSI

## 📋 Visão Geral

Este projeto é uma aplicação web desenvolvida em PHP puro com uma arquitetura MVC (Model-View-Controller) personalizada. Utiliza Docker e Docker Compose para containerização e gerenciamento de serviços, facilitando o desenvolvimento e a padronização do ambiente.

---

## 🐳 Docker e Docker Compose

### O que é Docker?

Docker é uma plataforma de containerização que encapsula a aplicação e suas dependências em um container isolado, garantindo que o código funcione consistentemente em diferentes ambientes.

### Componentes do Docker Compose

O arquivo `compose.yaml` define três serviços principais:

#### 1. **app_php** - Serviço da Aplicação PHP
- **Imagem Base**: PHP 8.5.4RC1 em Alpine Linux
- **Porta**: Acessível em `http://localhost:8083` (configurável via `APP_PORT`)
- **Volume**: Monta o diretório local em `/var/www/html` para sincronização de arquivos
- **Comando Inicial**:
  - Acessa o diretório de trabalho
  - Executa `composer install` para instalar dependências
  - Inicia o servidor built-in do PHP no port 80

#### 2. **mariadb** - Banco de Dados
- **Imagem**: MariaDB (última versão)
- **Porta**: 3306 (configurável via `FORWARD_DB_PORT`)
- **Variáveis de Ambiente**:
  - `DB_PASS`: Senha do root e usuário
  - `DB_NAME`: Nome do banco de dados
  - `DB_USER`: Usuário do banco
- **Volume Persistente**: `vol_db` armazena dados do MySQL
- **Health Check**: Verifica a saúde do banco a cada 5 segundos

#### 3. **phpmyadmin** - Interface de Gerenciamento do Banco
- **Imagem**: PhpMyAdmin (última versão)
- **Porta**: 8093 (configurável via `FORWARD_MYADMIN_PORT`)
- **Funcionalidade**: Interface web para gerenciar o banco de dados
- **Acesso**: `http://localhost:8093`

### Rede e Volumes

- **Rede**: `app_net` (tipo bridge) conecta todos os serviços
- **Volume**: `vol_db` persiste dados do banco de dados entre reinicializações

---

## 🚀 Como Usar Docker Compose

### Pré-requisitos

- Docker instalado
- Docker Compose instalado
- Arquivo `.env` na raiz do projeto com as variáveis:
  ```env
  APP_PORT=8083
  DB_NAME=seu_banco
  DB_USER=seu_usuario
  DB_PASS=sua_senha
  FORWARD_DB_PORT=3306
  FORWARD_MYADMIN_PORT=8093
  ```

### Iniciar os Containers

```bash
# Iniciar em modo foreground (vê os logs)
docker-compose up

# Iniciar em background (modo daemon)
docker-compose up -d
```

### Parar os Containers

```bash
docker-compose down
```

### Parar e Remover Volumes

```bash
docker-compose down -v
```

### Visualizar Logs

```bash
# Todos os serviços
docker-compose logs -f

# Serviço específico
docker-compose logs -f app_php
docker-compose logs -f mariadb
```

### Executar Comandos no Container

```bash
# Acessar shell do PHP
docker-compose exec app_php bash

# Executar comando específico
docker-compose exec app_php php -v
```

---

## 🏗️ Arquitetura MVC

O projeto segue o padrão **Model-View-Controller**, onde:

### **Model** (Modelos de Dados)
- Responsável pela lógica de dados e acesso ao banco
- Localização: `src/app/models/`
- Exemplo: `Produto.php` - Representa a entidade Produto

### **View** (Apresentação)
- Responsável pela exibição de dados ao usuário
- Localização: `src/app/views/`
- Exemplo: Templates HTML em `src/app/views/templates/produtos/`
- Classe de suporte: `src/app/views/View.php`

### **Controller** (Intermediário)
- Responsável por processar requisições e orquestrar Model e View
- Localização: `src/app/controllers/`
- Exemplo: `ProdutoController.php` - Controla operações de Produtos
- Classe base: `Controller.php`

### Fluxo de Requisição

```
Requisição HTTP → Router → Controller → Model (BD) → View → Resposta
```

---

## 📁 Estrutura do Projeto

```
.
├── src/                          # Código-fonte da aplicação
│   ├── app/                      # Núcleo da aplicação MVC
│   │   ├── controllers/          # Controllers - Processam requisições
│   │   │   ├── Controller.php    # Classe base para controllers
│   │   │   └── ProdutoController.php  # Controller de Produtos
│   │   ├── models/               # Models - Lógica de dados
│   │   │   ├── Model.php         # Classe base para modelos
│   │   │   └── Produto.php       # Modelo de Produto
│   │   ├── views/                # Views - Apresentação
│   │   │   ├── View.php          # Classe para renderizar views
│   │   │   └── templates/        # Arquivos de template HTML
│   │   │       └── produtos/     # Templates específicos de Produtos
│   │   └── core/                 # Núcleo da aplicação
│   │       ├── App.php           # Classe de inicialização da app
│   │       └── Route.php         # Sistema de roteamento
│   ├── config/                   # Configurações
│   │   └── routes.php            # Definição de rotas
│   ├── database/                 # Banco de Dados
│   │   ├── Connection.php        # Classe de conexão com BD
│   │   └── dumps/                # Backups do banco
│   │       ├── mysql_apiprod.sql
│   │       └── pgsql_apiprod.sql
│   └── public/                   # Raiz pública (documentroot)
│       ├── index.php             # Ponto de entrada da aplicação
│       └── templates/            # Assets públicos
│           └── produtos/         # Arquivos de view dos produtos
├── vendor/                       # Dependências do Composer
├── compose.yaml                  # Configuração Docker Compose
├── Dockerfile                    # Definição da imagem Docker
├── composer.json                 # Configuração do Composer
└── readme.md                     # Este arquivo

```

### Descrição das Pastas Principais

#### **src/** - Código-Fonte
Contém toda a lógica da aplicação separada em componentes MVC.

#### **src/app/** - Aplicação
Núcleo do padrão MVC com controllers, models e views.

#### **src/app/controllers/** - Controllers
- Processa requisições HTTP
- Coordena a interação entre Model e View
- `Controller.php`: Classe base para herança
- `ProdutoController.php`: Implementação específica para Produtos

#### **src/app/models/** - Modelos
- Define estrutura dos dados
- Acessa o banco de dados
- `Model.php`: Classe base com métodos comuns
- `Produto.php`: Modelo específico de Produtos

#### **src/app/views/** - Visões
- `View.php`: Sistema de renderização de templates
- **templates/**: Contém archivos HTML/PHP
  - **produtos/**: Templates específicos para o módulo de Produtos

#### **src/app/core/** - Núcleo da Aplicação
- `App.php`: Inicializa a aplicação e carrega configurações via `.env`
- `Route.php`: Sistema de roteamento que mapeia URLs para Controllers

#### **src/config/** - Configuração
- `routes.php`: Define as rotas da aplicação (mapeamento URL → Controller)

#### **src/database/** - Banco de Dados
- `Connection.php`: Gerencia conexão com o banco (MySQL/PostgreSQL)
- **dumps/**: Arquivos de backup do banco de dados

#### **src/public/** - Raiz Pública
- `index.php`: Ponto de entrada da aplicação (bootstrap)
- **templates/**: Arquivos de apresentação (HTML, CSS, JS)

#### **vendor/** - Dependências
Gerenciado pelo Composer, contém bibliotecas de terceiros.

---

## 📦 Composer - Gerenciamento de Dependências

### O que é Composer?

Composer é o gerenciador de dependências do PHP, similar ao npm (Node.js) ou pip (Python).

### Arquivo `composer.json`

Define metadados e dependências do projeto:

```json
{
    "name": "gillgonzales/cstsi_dbe2_202601_php_laravel",
    "type": "project",
    "require": {
        "vlucas/phpdotenv": "5.6.x-dev"  // Carrega variáveis .env
    },
    "require-dev": {
        "psy/psysh": "0.12.x-dev"  // Shell interativo PHP
    },
    "autoload": {
        "psr-4": {
            "CSTSI\\Dbe2\\": "src/"  // Autoload PSR-4
        }
    },
    "scripts": {
        "dev": "php -S 0.0.0.0:80 -t src/public"  // Inicia servidor built-in
    }
}
```

### Dependências Principais

#### **vlucas/phpdotenv**
- Carrega variáveis de ambiente do arquivo `.env`
- Permite configuração segura de credenciais
- Inicializado em `src/app/core/App.php`

#### **psy/psysh**
- Shell interativo para PHP (REPL)
- Facilita debugging e testes rápidos

### Instruções Principais do Composer

#### Instalar Dependências
```bash
composer install
```
- Instala todas as dependências definidas em `composer.json`
- Cria/atualiza o arquivo `composer.lock`
- Executado automaticamente pelo Docker ao iniciar

#### Instalar Nova Dependência
```bash
composer require vendor/package
```

#### Instalar Dependência de Desenvolvimento
```bash
composer require --dev vendor/package
```

#### Atualizar Dependências
```bash
composer update
```
- Atualiza pacotes para versões mais recentes

#### Autload PSR-4
```php
require_once __DIR__.'/vendor/autoload.php';
```
- Fornecido automaticamente pelo Composer
- Permite que classes sejam carregadas automaticamente pelo namespace

#### Executar Scripts Personalizados
```bash
# Inicia servidor development
composer run dev

# Acessa shell interativo
composer exec psysh
```

---

## 🔧 Dockerfile - Construção da Imagem

O `Dockerfile` define como a imagem Docker é construída:

```dockerfile
FROM php:8.5.4RC1-alpine3.22
```
- Base: PHP 8.5.4 em Alpine Linux (leve e seguro)

### Instalação de Dependências
```dockerfile
RUN apk update && apk add --no-cache \
    libpq-dev \
    bash \
    curl \
    vim \
    unzip
```
- Instala ferramentas essenciais e suporte a PostgreSQL

### Extensões PHP
```dockerfile
RUN docker-php-ext-install pdo_mysql pdo_pgsql
```
- PDO MySQL: Suporte a banco de dados MariaDB/MySQL
- PDO PostgreSQL: Suporte a banco de dados PostgreSQL

### Composer
```dockerfile
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
```
- Copia Composer da imagem oficial para usar no container

### Configuração Final
```dockerfile
WORKDIR /var/www/html
COPY . .
EXPOSE $APP_PORT
```
- Define diretório de trabalho
- Copia arquivos da aplicação
- Expõe a porta configurada

---

## 🔄 Fluxo de Inicialização

1. **Docker Compose** inicia os containers
2. **Container PHP**:
   - Instala dependências via `composer install`
   - Executa `composer run dev` (inicia servidor)
3. **Container MariaDB**:
   - Inicializa banco de dados
   - Executa health checks
4. **Container PhpMyAdmin**: 
   - Conecta ao MariaDB
   - Disponibiliza interface web
5. **Aplicação**:
   - `src/public/index.php` carrega `App::init()`
   - Carrega variáveis `.env`
   - Router processa requisições
   - Controllers chamam Models e Views

---

## 🌐 Acessando a Aplicação

Após iniciar com `docker-compose up`:

- **Aplicação PHP**: http://localhost:8083
- **PhpMyAdmin**: http://localhost:8093
- **Banco de Dados**: localhost:3306
  - Usuário: definido em `.env`
  - Senha: definida em `.env`

---

## 📝 Variáveis de Ambiente

Crie um arquivo `.env` na raiz do projeto:

```env
APP_PORT=8083
DB_NAME=apiprod
DB_USER=appuser
DB_PASS=senha123
FORWARD_DB_PORT=3306
FORWARD_MYADMIN_PORT=8093
```

---

## ✅ Checklist de Inicialização

- [ ] Docker e Docker Compose instalados
- [ ] Arquivo `.env` criado com variáveis
- [ ] `docker-compose up` executado
- [ ] Aplicação acessível em localhost:8083
- [ ] PhpMyAdmin acessível em localhost:8093
- [ ] Banco de dados funcionando (health check)
- [ ] Dependências instaladas (vendor/)

---

## 📚 Recursos Adicionais

- [Docker Documentation](https://docs.docker.com/)
- [Docker Compose Documentation](https://docs.docker.com/compose/)
- [PHP Official](https://www.php.net/)
- [Composer Documentation](https://getcomposer.org/doc/)
- [PSR-4 Autoloading](https://www.php-fig.org/psr/psr-4/)

---

**Autor**: Prof. Gonzales  
**Email**: gillgonzales@ifsul.edu.br
