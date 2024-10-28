<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

# Project Laravel Installation Guide

## Prerequisites

Before you begin, make sure you have the following installed:

- **Laragon** (or any other local development environment like XAMPP, WAMP, etc.)
- **Composer** (for PHP dependencies)
- **Node.js** and **NPM** (for frontend dependencies)

## Installation Steps

Follow these steps to set up the project locally:

### 1. Clone the Repository

Clone the project repository from Git:
```bash
git clone https://github.com/yourusername/your-laravel-project.git
```

Move into the project directory:
```bash
cd your-laravel-project
```

### 2. Install Composer Dependencies

Run the following command to install the necessary PHP dependencies:
```bash
composer install
```

### 3. Install NPM Dependencies

Run the following command to install the required Node.js packages:
```bash
npm install
```

### 4. Setup Environment File

Create a copy of the `.env.example` file and rename it to `.env`:
```bash
cp .env.example .env
```

Open the `.env` file and update the following database configuration (adjust as necessary for your environment):
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=root
DB_PASSWORD=
```

### 5. Generate Application Key

Run the following command to generate the application key:
```bash
php artisan key:generate
```

### 6. Run Migrations

If the project requires database tables, run the migrations:
```bash
php artisan migrate
```

### 7. Compile Frontend Assets (Optional)

If the project requires you to compile frontend assets like CSS or JavaScript, run:
```bash
npm run dev
```
For real-time watching of changes:
```bash
npm run watch
```

### 8. Serve the Application

You can use the built-in Laravel development server:
```bash
php artisan serve
```
Alternatively, if you're using Laragon, it will automatically recognize the project and serve it on a local domain (e.g., `http://your-laravel-project.test`).

### 9. (Optional) Running on Laragon

If you're using Laragon, simply place the project in the `C:\laragon\www` directory, and Laragon will automatically detect and serve it. You can access the project at `http://your-laravel-project.test`.

## Troubleshooting

If you encounter any issues during installation, consider the following:

- Ensure the `.env` file is correctly set up.
- Make sure the database is created and properly configured.
- Check for any missing extensions in your PHP installation (such as `ext-mbstring`, `ext-xml`, etc.).

## License

This project is open-source and available under the [MIT License](LICENSE).