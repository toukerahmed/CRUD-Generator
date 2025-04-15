# ⚡️ Laravel CRUD Generator

A simple yet powerful Laravel CRUD Generator to quickly scaffold Models, Migrations, Controllers, Form Requests, API Resources, Views, and Routes — with support for relationships and namespaced modules (like `Admin/Project`).

---

## 🚀 Features

- Generate full CRUD with one command
- Supports:
  - Models in nested namespaces
  - Blade views with field components
  - Enum field generation
  - Relationship methods (e.g., `hasMany`)
- Clean architecture: Model, Controller, Request, Resource, Views, Routes

---

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

php artisan make:crud Project \
--fields='name:string,status:enum(open,closed)' \
--relations='tasks:hasMany'

✅ With Namespaces (e.g., Admin Module)

php artisan make:crud Admin/Project \
--fields='name:string,status:enum(open,closed)' \
--relations='tasks:hasMany'


This will generate:
	•	app/Models/Admin/Project.php
	•	app/Http/Controllers/Admin/ProjectController.php
	•	app/Http/Requests/Admin/ProjectRequest.php
	•	app/Http/Resources/Admin/ProjectResource.php
	•	Views in resources/views/admin/projects/
	•	Routes in routes/web.php and/or routes/api.php

📂 Example Output Structure:

app/
├── Models/
│   └── Admin/
│       └── Project.php
├── Http/
│   ├── Controllers/
│   │   └── Admin/
│   │       └── ProjectController.php
│   ├── Requests/
│   │   └── Admin/
│   │       └── ProjectRequest.php
│   └── Resources/
│       └── Admin/
│           └── ProjectResource.php

resources/views/
└── admin/
    └── projects/
        ├── index.blade.php
        ├── create.blade.php
        ├── edit.blade.php
        └── show.blade.php