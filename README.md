# ⚡️ Laravel CRUD Generator

A simple yet powerful Laravel CRUD Generator to quickly scaffold Models, Migrations, Controllers, Form Requests, API Resources, Views, and Routes — with support for relationships and namespaced modules (like `Admin/Project`).

---

## 🚀 Features

- Generate full CRUD with one command
- Supports:
  - Models in nested namespaces
  - Blade views with field components
  - Enum field generation
  - Eloquent scopes and query filters
  - Relationship methods (e.g., `hasMany`)
- Clean architecture: Model, Controller, Request, Resource, Views, Routes

---

## 🛠️ Setup Instructions

## 🚀 Requirements

Before getting started, make sure your local environment includes:
	•	PHP >= 8.1
	•	Composer
	•	Laravel 10
	•	MySQL or compatible database

## 🛠️ Setup Instructions

1. **Clone the Repository:**

```bash
git clone https://github.com/toukerahmed/CRUD-Generator.git
cd CRUD-Generator

2. **Install Dependencies:**

cp .env.example .env
composer install
php artisan key:generate

3.	Configure Your Database:

Create a database named: 'crud-generator'

4.	Run Migrations:

php artisan migrate

5.	Start the Local Server:

php artisan serve


⚙️ Usage

You can generate CRUD for any model with a single Artisan command.

✅ Basic CRUD Generation

php artisan make:crud Order \
--fields='name:string,details:text,status:enum(ordered,received)' \
--relations='customers:hasMany'

✅ With Namespaces (e.g., Admin Module)

php artisan make:crud Admin/Order \
--fields='name:string,details:text,status:enum(ordered,received)' \
--relations='customers:hasMany'


This will generate:
	•	app/Models/Admin/Order.php
	•	app/Http/Controllers/Admin/OrderController.php
	•	app/Http/Requests/Admin/OrderRequest.php
	•	app/Http/Resources/Admin/OrderResource.php
	•	Views in resources/views/admin/orders/
	•	Routes in routes/web.php and/or routes/api.php

📂 Example Output Structure:

app/
├── Models/
│   └── Admin/
│       └── Order.php
├── Http/
│   ├── Controllers/
│   │   └── Admin/
│   │       └── OrderController.php
│   ├── Requests/
│   │   └── Admin/
│   │       └── OrderRequest.php
│   └── Resources/
│       └── Admin/
│           └── OrderResource.php

resources/views/
└── admin/
    └── orders/
        ├── index.blade.php
        ├── create.blade.php
        ├── edit.blade.php
        └── show.blade.php


🧠 Tips
	•	Enum fields are supported using field:type(option1,option2,...)
	•	Example: status:enum(active,inactive)
	•	Nested namespaces are supported using / or \\:
	•	Admin/Order or Admin\\Order
	•	Views will be generated in kebab-case plural format based on model path
	•	e.g., Admin/Order → resources/views/admin/orders/