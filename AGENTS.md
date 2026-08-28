# Project Analysis: My Cashflow API

## Overview
This is a REST API developed in PHP 8.4 using the Slim Framework (v4). It is designed for personal financial management, allowing users to track bank accounts, categories, and transactions (income and expenses).

## Architecture & Patterns
The project follows **Domain-Driven Design (DDD)** and Clean Architecture concepts.
- **Languages / Frameworks**: PHP 8.4, Slim Framework 4
- **Database**: PostgreSQL (via PDO)
- **Migrations**: Phinx
- **Container / DI**: PHP-DI
- **Documentation**: Swagger/OpenAPI (zircote/swagger-php) & Scalar
- **Environment**: Docker (Database)

The codebase is mainly organized into two bounded contexts within `src/`:
1. **Core**: Contains the application foundation, including HTTP routing, Database configurations, Dependency Injection, Middleware, and the domain logic for Users (Authentication, Session management, User registration).
2. **Finance**: Contains the domain logic for Accounts, Categories, and Transactions.

The structure inside these modules generally follows:
- `Application/Controller/`: HTTP Controllers (Slim Framework route handlers).
- `Domain/`: Core business logic, Entities, Exceptions, DTOs, Repository Interfaces, Services (Use Cases/Actions), Validations, and Enums.
- `Infrastructure/`: Concrete implementations of Repositories (PDO), Authentication mechanisms, etc.

## Database Schema
The database structure is managed via Phinx (`db/migrations`) and includes:
- `users`: User accounts and data.
- `sessions`: Authentication session control.
- `accounts`: Bank accounts linked to users.
- `categories`: Categories for classifying transactions (with initial seed data).
- `transactions`: Records of financial entries (incomes and expenses).

## Current Status
As indicated by the `README.md` and folder structure:
- **Implemented**: User Management (registration, JWT authentication, sessions) and Account Management (CRUD operations).
- **In Development/Implemented recently**: Financial Transactions (categories and transactions CRUD).

## Available Scripts (Composer)
- `composer serve`: Starts the built-in PHP web server on `localhost:3000`.
- `composer migrate`: Runs Phinx migrations.
- `composer rollback`: Rolls back the last migration.
- `composer create-migration`: Scaffolds a new Phinx migration.
- `composer dev`: Runs migrations and starts the dev server sequentially.

## AI Assistant Guidelines
When assisting with this project, I will observe the following rules:
- **Follow DDD**: New features should respect the existing layer separation (Controllers -> Services -> Repositories -> Entities). Use DTOs for data transfer.
- **Dependency Injection**: Use `php-di` for resolving dependencies. If a new service or repository is created, ensure it's properly bound if interface-based, or autowired.
- **Validation**: Use the custom validation system located at `src/Core/Domain/Validation`.
- **Documentation**: Keep OpenAPI (Swagger) PHP attributes up-to-date in the Controllers whenever an endpoint changes.
- **Exceptions**: Throw domain-specific exceptions and handle them appropriately, leveraging HTTP status codes defined in `src/Core/Domain/Enum/StatusCode.php`.
