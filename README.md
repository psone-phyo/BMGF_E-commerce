# BMGF_E-commerce
BMGF E-Commerce is the backend for the e-commerce platform, built with Laravel and MySQL to manage products, users, orders, and authentication.

🚀 Features

User authentication & authorization (Laravel Sanctum)

Product management (CRUD operations)

Order processing & Order history

RESTful API for frontend integration

🛠️ Installation Steps

1. Clone the Backend Repository

git clone https://github.com/psone-phyo/BMGF_E-commerce.git

cd BMGF_E-commerce

2. Install Laravel Dependencies

composer install

3. Configure Environment Variables

(1) Create a .env file in the project root and configure your database settings:

DB_CONNECTION=mysql

DB_HOST=127.0.0.1

DB_PORT=3306

DB_DATABASE=ecommerce

DB_USERNAME=root

DB_PASSWORD=


(2) Configure the Admin Authentication

ADMIN_EMAIL="admin0@gmail.com"

ADMIN_PASSWORD="admin1234"

(3) Configure the Google OAuth2.0

GOOGLE_CLIENT_ID=189719759224-cffccn4m57ohd26lva897kebauv7hoaf.apps.googleusercontent.com

GOOGLE_CLIENT_SECRET=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


4. Run Database Migrations & Seeders

php artisan migrate --seed

This will set up the database schema and seed initial data.


5. Start the Laravel Development Server

php artisan serve

Your backend will run at http://127.0.0.1:8000/.

🖼️ Tech Stack

Backend: Laravel 11, MySQL, RESTful API, Sanctum (for authentication)


Developed by psone-phyo 🚀
