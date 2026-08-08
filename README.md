# Employee Management

Employee Management is a Laravel-based Filament web application for managing employee records and related business data. The project includes a modern Filament admin panel where you can manage employees, departments, countries, states, cities, and users in one place.

## Technologies Used

- Laravel 12
- PHP 8.2
- Filament 5 for the admin panel
- SQLite as the default database configuration

## How to Run the Project

1. Clone the repository

```bash
git clone https://github.com/WazhmaHakimi/Employee_Management.git
cd Employee_Management
```

2. Install PHP dependencies

```bash
composer install
```

3. Create the environment file

```bash
cp .env.example .env
php artisan key:generate
```

4. Run database migrations and seed the database

```bash
php artisan migrate
php artisan db:seed
```

5. Start the application

```bash
php artisan serve
```

Then open your browser and visit:

```text
http://127.0.0.1:8000/admin
```

A demo admin user will be created during seeding:

- Email: admin@gmail.com
- Password: 123

