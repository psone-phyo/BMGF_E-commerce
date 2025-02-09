# BMGF_E-commerce
BMGF E-Commerce is the backend for the e-commerce platform, built with Laravel and MySQL to manage products, users, orders, and authentication.

🚀 Features

User authentication & authorization (Laravel Sanctum)

Product management (CRUD operations)

Order processing & payment history

RESTful API for frontend integration

🛠️ Installation Steps

1. Clone the Backend Repository

git clone https://github.com/psone-phyo/BMGF_E-commerce.git

cd BMGF_E-commerce

2. Install Laravel Dependencies

composer install

3. Configure Environment Variables

Create a .env file in the project root and configure your database settings:

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=bmgf_ecommerce
DB_USERNAME=root
DB_PASSWORD=yourpassword

4. Generate Application Key

php artisan key:generate

This will set up the encryption key required for Laravel.

5. Run Database Migrations & Seeders

php artisan migrate --seed

This will set up the database schema and seed initial data.

6. Link Storage to Public Folder

php artisan storage:link

This command creates a symbolic link between storage/app/public and public/storage, allowing public access to uploaded files.

7. Start the Laravel Development Server

php artisan serve

Your backend will run at http://127.0.0.1:8000/.

🖼️ Tech Stack

Backend: Laravel 11, MySQL, RESTful API, Sanctum (for authentication)

Developed by psone-phyo 🚀
