# My Cash Flow API 💰

<div align="center">
  <img src="https://img.shields.io/badge/PHP-8.4+-777BB4?style=for-the-badge&logo=php&logoColor=white" alt="PHP Version">
  <img src="https://img.shields.io/badge/PostgreSQL-336791?style=for-the-badge&logo=postgresql&logoColor=white" alt="PostgreSQL">
  <img src="https://img.shields.io/badge/Swagger-85EA2D?style=for-the-badge&logo=swagger&logoColor=black" alt="Swagger">
  <img src="https://img.shields.io/badge/Docker-2496ED?style=for-the-badge&logo=docker&logoColor=white" alt="Docker">
</div>

## 📋 Sobre o Projeto

**My Cash Flow** é uma API REST para organização financeira pessoal, permitindo que usuários cadastrem entradas e saídas de suas contas bancárias para melhor controle de suas finanças.

### 🎯 Objetivos do Projeto

Este projeto foi desenvolvido com o objetivo principal de **praticar e aprofundar conhecimentos em PHP**, utilizando:

- **PHP Puro** (sem frameworks) para entender os conceitos fundamentais
- **PDO** para acesso ao banco de dados
- **Orientação a Objetos** com aplicação de princípios SOLID
- **Clean Code** e boas práticas de desenvolvimento
- **Design Patterns** para soluções elegantes e reutilizáveis
- **Domain Driven Design (DDD)** para organização arquitetural

## 🏗️ Arquitetura

O projeto segue os princípios do **Domain Driven Design (DDD)** e está organizado em camadas:

```
src/
├── Core/                    # Módulo principal do sistema
│   ├── Application/         # Camada de aplicação
│   │   └── Controller/      # Controladores REST
│   ├── Domain/              # Camada de domínio
│   │   ├── Auth/            # Autenticação e autorização
│   │   ├── Entity/          # Entidades de domínio
│   │   ├── Enum/            # Enumerações
│   │   ├── Exception/       # Exceções customizadas
│   │   ├── Interfaces/      # Contratos e interfaces
│   │   ├── OpenApi/         # Documentação Swagger
│   │   └── Repository/      # Contratos de repositório
│   └── Infrastructure/      # Camada de infraestrutura
│       ├── Auth/            # Implementação de autenticação
│       ├── Database/        # Configuração e conexão com BD
│       ├── DependencyInjection/ # Container de dependências
│       ├── Environment/     # Gerenciamento de variáveis de ambiente
│       ├── Http/            # Roteamento e middleware HTTP
│       ├── Log/             # Sistema de logs
│       └── Repository/      # Implementação dos repositórios
└── Users/                   # Módulo de usuários
    ├── Application/         # Controladores específicos de usuários
    ├── Domain/              # Lógica de negócio de usuários
    └── Infrastructure/      # Implementações de infraestrutura
```

## 🚀 Funcionalidades

### ✅ Implementadas
- 👤 **Gerenciamento de Usuários**
  - Cadastro de usuários
  - Autenticação JWT
  - Gerenciamento de sessões

- 🏦 **Gerenciamento de Contas**
  - Cadastro de contas bancárias
  - Vinculação de contas a usuários

### 🔄 Em Desenvolvimento
- 💸 **Transações Financeiras**
  - Registro de entradas (receitas)
  - Registro de saídas (despesas)
  - Categorização de transações
  - Relatórios financeiros

## 🛠️ Tecnologias Utilizadas

- **PHP 8.4+** - Linguagem principal
- **PostgreSQL** - Banco de dados
- **PDO** - Interface de acesso ao banco de dados
- **Swagger/OpenAPI** - Documentação da API
- **Scalar** - Interface visual para documentação
- **Docker** - Containerização do banco de dados
- **Composer** - Gerenciador de dependências

## 📦 Dependências

### Principais
- `zircote/swagger-php` - Geração de documentação OpenAPI
- `ramsey/uuid` - Geração de UUIDs

### Extensões PHP Requeridas
- `ext-pdo` - Para acesso ao banco de dados
- `ext-json` - Para manipulação JSON
- `ext-intl` - Para internacionalização

## 🔧 Instalação e Configuração

### Pré-requisitos
- PHP 8.4 ou superior
- Composer
- Docker e Docker Compose
- PostgreSQL (se não usar Docker)

### 1. Clone o repositório
```bash
git clone https://github.com/Tiago0Br/my-cash-flow-api.git
cd my-cash-flow-api
```

### 2. Instale as dependências
```bash
composer install
```

### 3. Configure as variáveis de ambiente
Crie um arquivo `.env` na raiz do projeto baseado no `.env.example`:
```bash
cp .env.example .env
```

Exemplo de configuração:
```env
# Database
DB_HOST=localhost
DB_PORT=5432
DB_NAME=my_cash_flow
DB_USER=postgres
DB_PASSWORD=password

# Application
APP_ENV=development
APP_DEBUG=true
JWT_SECRET=your-jwt-secret-key
```

### 4. Execute o banco de dados com Docker
```bash
docker-compose up -d
```

### 5. Execute as migrações
```bash
composer migrate
```

### 6. Inicie o servidor de desenvolvimento
```bash
composer dev
```

A API estará disponível em `http://localhost:3000`

## 📚 Documentação da API

A documentação completa da API está disponível através do Swagger UI:

**URL:** `http://localhost:3000/docs`

A documentação inclui:
- 📖 Especificação completa de todos os endpoints
- 🧪 Interface interativa para testes
- 📋 Exemplos de requisições e respostas
- 🔐 Informações sobre autenticação

## 🗄️ Banco de Dados

### Migrações

O projeto utiliza um sistema personalizado de migrações SQL:

#### Criar uma nova migração
```bash
composer migrate:create
```

#### Executar migrações pendentes
```bash
composer migrate
```

## 🚀 Scripts Disponíveis

```bash
# Iniciar servidor de desenvolvimento
composer serve

# Executar migrações
composer migrate

# Criar nova migração
composer migrate:create

# Executar migrações e iniciar servidor (desenvolvimento)
composer dev
```

## 📝 Conceitos Aplicados

### Design Patterns
- **Repository Pattern** - Abstração da camada de dados
- **Dependency Injection** - Inversão de controle
- **Factory Pattern** - Criação de objetos
- **Strategy Pattern** - Diferentes estratégias de autenticação

### Princípios SOLID
- **S**ingle Responsibility Principle
- **O**pen/Closed Principle
- **L**iskov Substitution Principle
- **I**nterface Segregation Principle
- **D**ependency Inversion Principle

### Clean Code
- Nomenclatura clara e expressiva
- Funções pequenas e focadas
- Comentários significativos
- Tratamento adequado de erros

---

<div align="center">
  Desenvolvido com ❤️ para aprendizado e prática em PHP
</div>
