# Quiz Wiz

## Table of Contents
- [Introduction](#introduction)
- [Prerequisites](#prerequisites)
- [Tech Stack](#tech-stack)
- [Getting Started](#getting-started)
- [Development](#development)
- [Deployment](#deployment)
- [Resources](#resources)

## Introduction

**Quiz Wiz** is a platform where users can create and take quizzes. Quizzes are organized by categories, and users get instant feedback on correct/incorrect answers after completing a quiz.

This project is a **Laravel REST API**.

## Prerequisites

- PHP 8.3+
- SQLite 3+
- Composer 2+
- Laravel 13

## Tech Stack

Laravel 13, PHP 8.3, SQLite

## Getting Started

```sh
git clone https://github.com/RedberryInternship/levan-ugulava-quiz-wiz-back.git
cd levan-ugulava-quiz-wiz-back
composer install
cp .env.example .env
```

Set `DB_CONNECTION=sqlite` in `.env`, then:

```sh
php artisan key:generate
php artisan migrate
php artisan serve
```

API runs at `http://localhost:8000`.

## Development

```sh
php artisan storage:link
php artisan serve
```

**Project structure:**

```
├─ app
│  ├─ Console
│  ├─ Enums
│  ├─ Filament
│  ├─ Http
│  ├─ Actions
│  ├─ Models
│  ├─ Notifications
│  ├─ Providers
│  └─ Services
├─ bootstrap
├─ config
├─ database
├─ routes
│  ├─ api.php
│  └─ api
│     ├─ auth.php
│     ├─ filter.php
│     └─ quiz.php
├─ storage
├─ tests
├─ .env
├─ artisan
└─ composer.json
```

## Deployment
**Server:** VPS 

**Web server:** Nginx 

**PHP version:** 8.3

**Database:** SQLITE

**Domain:** https://app.quiz-wiz.levan-ugulava.redberryinternship.ge

### Test User

For testing purposes, you can use:

- **Email:** uleuschke@example.net
- **Password:** password






## Resources

- **Database Diagram:** _https://drawsql.app/teams/levani-workspace/diagrams/quiz-wiz_
