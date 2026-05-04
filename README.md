# Book App API

Laravel-based REST API for managing books with Swagger documentation and testing support.

## Project Setup

Clone the project

```bash
git clone https://github.com/DenisFriz/laravel-book-app.git
cd laravel-book-app
```

## Install dependencies

```bash
composer install --prefer-dist
```

## Environment setup
```bash
cp .env.example .env
```

Generate application key:
```bash
php artisan key:generate
```

## Configure database

```bash
php artisan migrate
```

## 🚀 Running the Application

```bash
php artisan serve
```

## Swagger Documentation

```bash
http://127.0.0.1:8000/api/documentation
```

## 🧪 Running Tests

```bash
php artisan test
```
