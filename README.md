# SCM App - Supply Chain Management Application

**Portfolio Project for PT. Schlemmer Automotive Indonesia**  
*Located at Delta Silicon 3 Industrial Park, Bekasi Regency (Kawasan Industri Delta Silicon 3, Kab. Bekasi).*

---

## 📖 Project Overview

This Supply Chain Management (SCM) Application is built using **Laravel 12** and **Filament PHP**. It provides a robust and comprehensive administration panel designed to manage users, assign roles seamlessly (utilizing Filament Shield), handle secure data exports, and streamline core data management processes tailored for the operational needs of modern automotive manufacturing supply chains.

## 🚀 System Requirements

Before running this application, please ensure your system meets the following requirements:

- **PHP** >= 8.2
- **Composer** (PHP dependency manager)
- **Node.js** & **npm** (for asset bundling)
- **Database** (MySQL, PostgreSQL, or SQLite)

---

## 🛠 Installation & Setup Guide

Follow these steps to set up and run the application on your local development environment:

### 1. Open the Project Directory

Navigate into the project folder using your terminal or command prompt:

```bash
cd c:\Project\php\laravel\v12\scm_app
```

### 2. Install PHP Dependencies

Run Composer to install all the necessary libraries required by the application, including Laravel and Filament:

```bash
composer install
```

### 3. Environment Configuration (`.env`)

Duplicate the `.env.example` file and rename it to `.env`:

- **Windows / CMD**: `copy .env.example .env`
- **Linux / Mac**: `cp .env.example .env`

Open the newly created `.env` file in your text editor and configure your database settings. For example, if using MySQL:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=root
DB_PASSWORD=
```

*(Ensure that the database `your_database_name` is created in your database management system beforehand).*

### 4. Generate Application Key

Run the following Artisan command to generate the Laravel application key:

```bash
php artisan key:generate
```

### 5. Link Storage Directory

Filament applications require a linked local storage directory to handle file uploads such as user avatars or exported documents. Link the storage folder to the public directory:

```bash
php artisan storage:link
```

### 6. Database Migration and Seeding

Run the database migrations and seeders. This step is critical to generate the required database tables, initialize default roles and permissions, and create the initial administrator account:

```bash
php artisan migrate --seed
```

*(Note: If configuring roles manually, you may run `php artisan shield:generate --all` followed by `php artisan make:filament-user` to set up the initial super admin account).*

### 7. Run the Application Server

Start Laravel's built-in development server:

```bash
php artisan serve
```

### 8. Access the Web Application

Your SCM Application is now successfully running and accessible via your web browser:

- **Admin Panel / Main Dashboard**: [http://localhost:8000/admin](http://localhost:8000/admin) (or your configured admin panel path)
- **Login Credentials**: Log in using the default credentials defined in the database seeder (for example: email `admin@admin.com` with password `password`), or use the account created during the CLI setup.

---

## 💻 Core Tech Stack & Libraries

- **Framework**: Laravel 12
- **Admin Dashboard**: Filament PHP 5.x
- **Roles & Permissions**: Filament Shield (Spatie Permission)
- **Data Exporting Engine**: Filament Excel / OpenSpout

---

*This project serves as a showcase of modern web development practices, technical proficiency, and problem-solving skills targeted at building scalable enterprise-grade applications.*
